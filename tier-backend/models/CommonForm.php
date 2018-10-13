<?php
/**
 */
namespace backend\models;

use Yii;
use yii\web\UploadedFile;

class CommonForm extends \yii\base\Model
{
    public $name;

    /* 产品规格下拉菜单 */
    public $specifications;

    const SCENARIO_DEMO = 'demo';
    const SCENARIO_SPU = 'spu';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'on' => self::SCENARIO_DEMO],
            [['name'], 'validateAmount', 'on' => self::SCENARIO_DEMO],

            [['specifications'], 'required', 'on' => self::SCENARIO_SPU],

        ];
    }
    /**
     */
    public function validateAmount($attribute, $params, $validator)
    {
        $this->addError($attribute, "error msg");
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '姓名',
            'specifications' => '产品规格',
        ];
    }
}
