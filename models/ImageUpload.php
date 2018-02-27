<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class ImageUpload
 * @package app\models
 */
class ImageUpload extends Model
{
    public $image;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image'],'required'],
            [['image'],'file', 'extensions' => 'png,jpg']
        ];
    }

    /**
     * Загрузка картинки
     * @param UploadedFile $file
     * @param $currentImage
     * @return string
     */
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

    /**
     * @return string (путь к картинкам)
     */
    private function getFolder()
    {
        return Yii::getAlias('@web').'uploads/';
    }

    /**
     * Генерация имени картинки
     * @return string
     */
    private function generetaFilename()
    {
        return strtolower(md5(uniqid($this->image->baseName)).'.'.$this->image->extension);
    }

    /**
     * Удаление текущей картинки, если она существует
     * @param $currentImage
     */
    public function deleteCurrentImage($currentImage)
    {
        if ($this->fileExist($currentImage)){
            unlink($this->getFolder().$currentImage);
        }
    }

    /**
     * Проверяем файл на существование
     * @param $currentImage
     * @return bool
     */
    private function fileExist($currentImage)
    {
        //на всякий случай дополнительные проверочки не помешают
        if (!empty($currentImage) && $currentImage != null){
            return file_exists($this->getFolder().$currentImage);
        }
    }

    /**
     * Сохранение картинки
     * @return string
     */
    private function saveImage()
    {
        $filename = $this->generetaFilename();
        $this->image->saveAs($this->getFolder().$filename);
        return $filename;
    }
}