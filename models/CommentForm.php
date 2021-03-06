<?php

namespace app\models;

use yii\base\Model;

class CommentForm extends Model
{
    /**@var string Комментарий */
    public $comment;

    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['comment'], 'string', 'length' => [3, 250]],
        ];
    }

    /**
     * Сохранение комментария
     * @param $article_id
     * @return bool
     */
    public function saveComment($article_id)
    {
        $comment = new Comment();
        $comment->text = $this->comment;
        $comment->user_id = \Yii::$app->user->id;
        $comment->article_id = $article_id;
        $comment->status = 0;
        $comment->date = date('Y-m-d');
        return $comment->save();
    }
}