<?php

namespace vetoni\filekit\actions;

use vetoni\filekit\File;
use yii\base\Action;
use yii\helpers\Json;

/**
 * Class DeleteAction
 * @package vetoni\filekit\actions
 */
class DeleteAction extends Action
{
    /**
     * @var
     */
    public $fileParam;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->fileParam = \Yii::$app->request->get('f');
    }

    /**
     * @return string
     * @throws HttpException
     */
    public function run()
    {
        $file = File::findOne(['fid' => $this->fileParam]);

        if (file_exists($file->path)) {
            unlink($file->path);
        }

        if ($file->delete() === FALSE) {
            throw new HttpException(400);
        }

        return Json::encode($this->fileParam);
    }
}