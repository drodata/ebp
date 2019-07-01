<?php

namespace backend\models;

use Yii;
use drodata\helpers\Html;
use backend\models\Taxonomy;
use drodata\models\Currency;
use yii\helpers\ArrayHelper;
use yii\base\NotSupportedException;

/**
 * 各个视图内引用的此类而非 drodata\models\Lookup, 目的是可以在这里添加一些
 * application-specific 的静态方法。例如，可以添加一个 customers() 的静态方法，
 * 返回所有客户的 map. 这么做的好处是，不必在视图内再单独引用 Customer 类，
 * 只需引入 Lookup 类即可获取绝大多数的 map。
 */
class Lookup extends \drodata\models\Lookup
{
    /**
     * 根据 $action 返回路由配置内容
     *
     * @param string $action unique
     * @return string|array 
     */
    public static function route($action)
    {
        $map = [
            'home' => '/',
            // append your concrete custom routes here
        ];

        return Url::to($map[$action]);
    }

    /**
     * 返回类似 AR 中 actionLink
     *
     * @param string $action action name
     * @param array $configs 参考 Html::actionLink()
     * @return mixed the link html content
     */
    public static function navigationLink($action, $configs = [])
    {
        // default options
        $visible = true;
        $hint = null;
        $confirm = null;

        switch ($action) {
            case 'home':
                $route = '/';
                $options = [
                    'title' => '返回首页',
                    'color' => 'default',
                ];
                break;
            /**
             * TEMPLATE
            case 'download-container-summary':
                $route = '/export/container-summary';
                $options = [
                    'title' => '下载',
                    'icon' => 'download',
                    'color' => 'success',
                    'data-method' => 'post',
                ];
                $visible = Yii::$app->user->can('president');
                if (0) {
                    $hint = 'hint content';
                }
                break;
            */
        }

        // combine control options with common options
        $options =  ArrayHelper::merge($options, [
            'type' => 'icon',
            'visible' => $visible,
            'disabled' => $hint,
            'disabledHint' => $hint,
        ]);

        return Html::actionLink($route, ArrayHelper::merge($options, $configs));
    }
    /**
     * 品牌
     */
    public static function brands()
    {
        return ArrayHelper::map(Brand::find()->asArray()->all(), 'id', 'name');
    }
    /**
     * SPU 属性
     */
    public static function properties()
    {
        return Taxonomy::items('spu-property');
    }
    /**
     * SPU 属性
     */
    public static function specifications($parent = null)
    {
        return Taxonomy::items('spu-specification', $parent);
    }
    /**
     * SPU 属性、规格总 map. 格式:
     *
     * [
     *     '<PROPERTY_ID>' => [
     *         '<SPECIFICATION_ID>' => '',
     *         // ...
     *     ],
     * ]
     *
     */
    public static function propertyMap()
    {
        $map = [];
        foreach (static::properties() as $id => $property) {
            $subMap = ArrayHelper::map(
                Taxonomy::find()->where(['parent_id' => $id])->asArray()->all(),
                'id', 'name'
            );
            if (empty($subMap)) {
                $map[$id] = [];
            } else {
                foreach ($subMap as $sid => $name) {
                    $map[$id][] = [
                        'id' => $sid,
                        'text' => $name,
                    ];
                }
            } 
        }

        return $map;
    }

    /**
     * 货币下拉菜单
     */
    public static function currencies()
    {
        return ArrayHelper::map(Currency::find()->asArray()->all(), 'code', 'name');
    }
}
