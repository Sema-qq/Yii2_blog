<?php

namespace app\models;


use yii\base\Model;

class SignupForm extends Model
{
    /**@var string (Логин)*/
    public $name;
    /**@var string (Пароль)*/
    public $password;
    /**@var string (email)*/
    public $email;

    /**@inheritdoc*/
    public function rules()
    {
        return [
            [['name', 'password', 'email'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => 'email'],
            [['name'], 'string', 'min' => 3],
            [['password'], 'string', 'min' => 4],
        ];
    }

    /**
     * Созданиие нового пользователя
     * @return mixed
     */
    public function signup()
    {
        if ($this->validate()){
            $user = new User();
            $user->attributes = $this->attributes;
            return $user->create();
        }
    }
}