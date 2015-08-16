<?php

namespace vetoni\filekit;

use yii\base\Exception;
use yii\helpers\Html;
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
    public $removeUrl;

    /**
     * @throws Exception
     */
    public function init()
    {
        parent::init();
        if (!isset($this->uploadUrl)) {
            throw new Exception('uploadUrl property should be set');
        }

        if (!isset($this->removeUrl)) {
            throw new Exception('removeUrl property should be set');
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
            'removeUrl' => $this->removeUrl,
        ]);
    }
    /**
     * Registers all scripts required for the plugin to work
     */
    protected function registerClientScript()
    {
        $this->view->registerAssetBundle(FileUploadAsset::className());
        $this->view->registerJs("jQuery('#{$this->id}').yiiFileKit({removeUrl: '{$this->removeUrl}'});");
    }
}
