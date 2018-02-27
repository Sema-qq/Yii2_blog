<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use app\models\CommentForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        //статьи с пагинацией
        $data = Article::getAll(1);
        //популярныые статьи
        $popular = Article::getPopular();
        //последние посты
        $recent = Article::getRecent();
        //категории
        $categories = Category::find()->all();

        return $this->render('index', [
            'articles' => $data['articles'],
            'pagination' => $data['pagination'],
            'popular' => $popular,
            'recent' => $recent,
            'categories' => $categories
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        //статья
        $article = Article::findOne($id);
        //популярныые статьи
        $popular = Article::getPopular();
        //последние посты
        $recent = Article::getRecent();
        //категории
        $categories = Category::find()->all();
        //комментарии
        $comments = $article->comments;
        //форма для сохранения комментариев
        $commentForm = new CommentForm();
        return $this->render('single', compact(
            'article', 'popular', 'recent', 'categories', 'comments', 'commentForm')
        );
    }

    /**
     * @param $id
     * @return string
     */
    public function actionCategory($id)
    {
        //статьи текущей категории с пагинацией
        $data = Category::getArticlesByCategory($id);
        //текущая категория
        $category = Category::findOne($id);
        //популярныые статьи
        $popular = Article::getPopular();
        //последние посты
        $recent = Article::getRecent();
        //категории
        $categories = Category::find()->all();
        return $this->render('category', [
            'category' => $category,
            'popular' => $popular,
            'recent' => $recent,
            'categories' => $categories,
            'articles' => $data['articles'],
            'pagination' => $data['pagination']
            ]);
    }

    /**
     * @return string|Response
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
