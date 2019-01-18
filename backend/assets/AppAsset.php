<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use drodata\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 *
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $appendMd5Hash = true;
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/ajax-operations.js',
    ];
    public $depends = [
        'drodata\assets\AdminLTECustomAsset',
        'drodata\trekshot\TrekshotAsset',
        'drodata\assets\GenericModelAsset',
    ];
}
