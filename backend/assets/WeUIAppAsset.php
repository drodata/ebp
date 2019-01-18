<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class WeUIAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\WeUIAsset',
    ];
}
