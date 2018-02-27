<?php

namespace app\modules\admin;
use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    public $layout = '/admin';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * Проверяем, является ли пользователь админом
     * (пустим только админа)
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' =>  [
                'class' => AccessControl::className(),
                'denyCallback' => function($rule, $action){
                    throw new ForbiddenHttpException();
                },
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->identity->is_admin;
                        }
                    ]
                ]
            ]
        ];
    }
}
