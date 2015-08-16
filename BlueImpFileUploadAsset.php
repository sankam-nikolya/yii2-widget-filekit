<?php

namespace vetoni\filekit;

use yii\web\AssetBundle;

/**
 * Class BlueImpFileUploadAsset
 * @package vetoni\filekit
 */
class BlueImpFileUploadAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@bower/blueimp-file-upload';

    /**
     * @var array
     */
    public $css = [
        'css/jquery.fileupload.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/jquery.iframe-transport.js',
        'js/jquery.fileupload.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\jui\JuiAsset',
    ];
}