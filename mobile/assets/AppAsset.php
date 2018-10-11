<?php

namespace mobile\assets;

use drodata\web\AssetBundle;

/**
 * Main mobile application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $appendMd5Hash = true;
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/ajax-operations.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'drodata\weui\WeUIAsset',
        'drodata\weui\WeUIJsAsset',
        'drodata\assets\FontAwesomeAsset',
        'drodata\trekshot\TrekshotAsset',
    ];
}
