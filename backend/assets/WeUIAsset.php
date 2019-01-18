<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class WeUIAsset extends AssetBundle
{
    public $basePath = '@bower/weui/dist/';
    public $css = [
        'style/weui.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
