<?php

namespace vetoni\filekit\actions;

use vetoni\filekit\File;
use yii\base\Action;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * Class UploadAction
 * @package vetoni\filekit\actions
 */
class UploadAction extends Action
{
    /**
     * @var
     */
    public $fileParam;

    /**
     *
     */
    public function init()
    {
        $this->fileParam = \Yii::$app->request->get('f');
    }

    /**
     * @return string
     */
    public function run()
    {
        $uploaded = UploadedFile::getInstanceByName($this->fileParam);

        $file = new File();

        $file->fid = \Yii::$app->security->generateRandomString(16);
        $file->name = $uploaded->name;
        $file->extension = $uploaded->extension;
        $file->type = $uploaded->type;
        $file->save();

        $uploaded->saveAs($file->path, true);

        return Json::encode($file->fid);
    }
}