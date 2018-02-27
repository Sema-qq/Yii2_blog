<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $title
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Получение статей по категории
     * @param $id
     * @return array
     */
    public static function getArticlesByCategory($id)
    {
        //вытащили все статьи
        $query = Article::find()->where(['category_id'=>$id]);
        //получили их количество
        $count = $query->count();
        //создали объект пагинации, в конструктор положили количество статей
        // и количество на одной странице
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 6]);
        //статьи с пагинацией уже
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        //кладем всё в массив для передачи в контроллер
        $data = [
            'articles' => $articles,
            'pagination' => $pagination
        ];
        return $data;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }
}
