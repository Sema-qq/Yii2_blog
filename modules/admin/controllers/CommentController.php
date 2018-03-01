<?php

namespace app\modules\admin\controllers;


use app\models\Comment;
use yii\web\Controller;

class CommentController extends Controller
{
    /**
     * Вывод комментариев
     * @return string
     */
    public function actionIndex()
    {
        $comments = Comment::find()->orderBy('id desc')->all();

        return $this->render('index', compact('comments'));
    }


    /**
     * Удаление комментария
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $comment = Comment::findOne($id);
        if($comment->delete()) {
            return $this->redirect(['comment/index']);
        }
    }

    /**
     * Разрешить к публикации комментарий
     * @param $id
     * @return \yii\web\Response
     */
    public function actionAllow($id)
    {
        $comment = Comment::findOne($id);
        if($comment->allow()) {
            return $this->redirect(['index']);
        }
    }

    /**
     * Запретить к публикации комментарий
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDisallow($id)
    {
        $comment = Comment::findOne($id);
        if($comment->disallow()) {
            return $this->redirect(['index']);
        }
    }
}