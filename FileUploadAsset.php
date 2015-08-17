<?php

namespace vetoni\filekit;

use yii\web\AssetBundle;

/**
 * Class FileUploadAsset
 * @package vetoni\filekit
 */
class FileUploadAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vetoni/filekit/assets';

    /**
     * @var array
     */
    public $css = [
        'css/file-kit.css'
    ];

    /**
     * @var array
     */
    public $js = [
        'js/url.js',
        'js/file-kit.js'
    ];

    /**
     * @var array
     */
    public $depends = [
        'vetoni\filekit\BlueImpFileUploadAsset',
        'vetoni\filekit\BlueImpLoadImageAsset',
    ];
}