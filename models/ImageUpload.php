<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 27.11.2017
 * Time: 21:36
 */

class ImageUpload extends Model
{
    public $image;

    public function rules()
    {
        return [
            [['image'],'required'],
            [['image'],'file', 'extensions' => 'png,jpg']
        ];
    }
    //метод загрузки картинки
    public function uploadFile(UploadedFile $file, $currentImage)
    {
        //кладем объект картинки в наше свойство
        $this->image = $file;
        //если валидаця пройдена
        if ($this->validate()){
            //то удалим текущую картинку и
            $this->deleteCurrentImage($currentImage);
            //сохраним новую, вернув имя
            return $this->saveImage();
        }
    }
    //возвращаем путь к картинкам
    private function getFolder()
    {
        return Yii::getAlias('@web').'uploads/';
    }
    //генерируем имя картинки, чтобы не совпало
    private function generetaFilename()
    {
        return strtolower(md5(uniqid($this->image->baseName)).'.'.$this->image->extension);
    }
    //удаляем картинку, если она существует
    public function deleteCurrentImage($currentImage)
    {
        if ($this->fileExist($currentImage)){
            unlink($this->getFolder().$currentImage);
        }
    }
    //проверяем файл на существование
    private function fileExist($currentImage)
    {
        //на всякий случай дополнительные проверочки не помешают
        if (!empty($currentImage) && $currentImage != null){
            return file_exists($this->getFolder().$currentImage);
        }
    }
    //сохраняем картинку
    private function saveImage()
    {
        $filename = $this->generetaFilename();
        $this->image->saveAs($this->getFolder().$filename);
        return $filename;
    }
}