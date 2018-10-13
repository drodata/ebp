<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

/**
 * @author drodata <drodata@gmail.com>
 * @since 2.0
 *
 * Used in order create/update
 */
class SpuAsset extends \drodata\web\AssetBundle
{
    public $appendMd5Hash = true;
	public $basePath = '@webroot';
	public $baseUrl  = '@web';
    public $js = [
		'js/spu.js',
	];
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
