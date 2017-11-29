<?php

namespace app\modules\admin\controllers;

use app\models\Category;
use app\models\ImageUpload;
use app\models\Tag;
use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSetImage($id)
    {
        $model = new ImageUpload();
        //если форма была отправлена
        if(Yii::$app->request->isPost){
            //вытащим статью по id
            $article = $this->findModel($id);
            //получим объект с картинкой, который почему то в массиве..
            $file = UploadedFile::getInstances($model, 'image');
            //параметр сохраняет картинку на сервер и возвращает имя
            //saveImage сохраняет картинку в базу
            if ($article->saveImage($model->uploadFile($file[0], $article->image))){
                //если всё успешно сохранилось, то направимся на страницу статьи
                return $this->redirect(['view', 'id' => $id]);
            }
        }
        //иначе опять покажем форму
        return $this->render('image', compact('model'));
    }

    public function actionSetCategory($id)
    {
        //вытащим статью по id
        $article = $this->findModel($id);
        //получим текущее id категории в статье
        $selectedCategory = $article->category->id;
        //список названий всех категорий для дропдаунлиста во вьюхе
        $categories = ArrayHelper::map(Category::find()->all(), 'id','title');
        //если форма отправлена, то
        if (Yii::$app->request->isPost){
            //получим значение выбранной категории
            $category = Yii::$app->request->post('category');
            //и сохраним его
            if ($article->saveCategory($category)){
                //если сохранение прошло успешно, то редирект во вьюху статьи
                return $this->redirect(['view', 'id' => $id]);
            }
        }
        //иначе опять покажем форму
        return $this->render('category', compact('article','selectedCategory', 'categories'));
    }

    public function actionSetTag($id)
    {
        //вытащим статью по id
        $article = $this->findModel($id);
        //все теги статьи
        $selectedTags = $article->getSelectedTags();
        //все теги
        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title');
        //если форма отправлена, то получим выбранные теги с формы и
        if(Yii::$app->request->isPost){
            $tags = Yii::$app->request->post('tags');
            //сохраним, в случае успешного сохранения редирект на страницу статьи
            $article->saveTags($tags);
            return $this->redirect(['view', 'id' => $id]);

        }//иначе опять покажем форму
        return $this->render('tags', compact('article', 'selectedTags','tags'));
    }
}
