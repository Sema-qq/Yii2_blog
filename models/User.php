<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $is_admin
 * @property string $photo
 * @property integer $vk_id
 *
 * @property Comment[] $comments
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_admin', 'vk_id'], 'integer'],
            [['name', 'email', 'password', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'is_admin' => 'Is Admin',
            'photo' => 'Photo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    /**
     * @param int|string $id
     * @return null|static
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    /** @inheritdoc */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //
    }

    /** @return int */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * @param string $authKey
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    /**
     * Пользователь по логину
     * @param $username
     * @return array|null|ActiveRecord
     */
    public static function findByUserName($username)
    {
        return User::find()->where(['name' => $username])->one();
    }

    /**
     * Проверка пароля
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return ($this->password == $password) ? true : false;
    }

    /**
     * Возвращает метод сейв, для понимания редактируем мы или создаем нового пользователя
     * @return bool
     */
    public function create()
    {
        return $this->save(false); //параметр отменяет валидацию
    }


    /**
     * Регистрация/авторизация через виджет ВК
     * @param int $uid
     * @param string $first_name
     * @param string $photo
     * @return bool
     */
    public function saveFromVk($uid, $first_name, $photo)
    {
        //если такой пользователь уже есть, то авторизуем его
        if($user = User::findOne(['vk_id' => $uid])){
            return Yii::$app->user->login($user);
        }
        //иначе создадим нового и авторизуем его
        $this->vk_id = $uid;
        $this->name = $first_name;
        $this->photo = $photo;
        $this->create();

        return Yii::$app->user->login($this);
    }

    /**
     * Фото пользователя
     * @return string
     */
    public function getImage()
    {
        return $this->photo;
    }
}
