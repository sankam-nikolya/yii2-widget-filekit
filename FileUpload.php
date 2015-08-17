<?php

namespace vetoni\filekit;

use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\jui\InputWidget;

/**
 * Class FileUpload
 * @package vetoni\filekit
 */
class FileUpload extends InputWidget
{
    /**
     * @var
     */
    public $uploadUrl;

    /**
     * @var
     */
    public $deleteUrl;

    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     * @throws Exception
     */
    public function init()
    {
        parent::init();
        if (!isset($this->uploadUrl)) {
            throw new Exception('uploadUrl property should be set');
        }

        if (!isset($this->deleteUrl)) {
            throw new Exception('deleteUrl property should be set');
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->registerClientScript();
        $attributeValue = $this->model->{$this->attribute};
        $file = File::findOne(['fid' => $attributeValue]);

        return $this->renderFile(dirname(__FILE__) . '/views/widget.php', [
            'id' => $this->options['id'],
            'name' => Html::getInputName($this->model, $this->attribute),
            'fileInputId' => $this->id,
            'fileInputName' => "_fileinput_" . $this->id,
            'fid' => $attributeValue,
            'url' => isset($file) ? $file->url : null,
            'uploadUrl' => $this->uploadUrl,
            'deleteUrl' => $this->deleteUrl,
        ]);
    }
    /**
     * Registers all scripts required for the plugin to work
     */
    protected function registerClientScript()
    {
        $this->view->registerAssetBundle(FileUploadAsset::className());

        $options = Json::encode($this->clientOptions);
        $this->view->registerJs("jQuery('#{$this->id}').yiiFileKit({$options});");
    }
}
