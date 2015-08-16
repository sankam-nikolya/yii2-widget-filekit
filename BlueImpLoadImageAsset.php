<?php

namespace vetoni\filekit;

use yii\web\AssetBundle;

/**
 * Class BlueImpLoadImageAsset
 * @package vetoni\filekit
 */
class BlueImpLoadImageAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@bower/blueimp-load-image';

    /**
     * @var array
     */
    public $js = [
        'js/load-image.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\jui\JuiAsset',
    ];
}