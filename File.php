<?php

namespace vetoni\filekit;

use yii\db\ActiveRecord;

/**
 * Class File
 * @package vetoni\filekit
 *
 * @property string $fid
 * @property string $name
 * @property string $extension
 * @property string $type
 * @property string $fullName
 * @property string $url
 * @property string $path
*/
class File extends ActiveRecord
{
    public function getFullName()
    {
        return implode('.', [$this->fid, $this->extension]);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return \Yii::getAlias("@web") . \Yii::$app->params['fileStorage.basePath'] . "/{$this->fullName}";
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return \Yii::getAlias("@webroot") . \Yii::$app->params['fileStorage.basePath'] . "/{$this->fullName}";
    }
}