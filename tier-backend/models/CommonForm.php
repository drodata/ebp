<?php
/**
 */
namespace backend\models;

use Yii;
use yii\web\UploadedFile;

class CommonForm extends \yii\base\Model
{
    public $name;

    const SCENARIO_DEMO = 'demo';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'on' => self::SCENARIO_DEMO],
            [['name'], 'validateAmount', 'on' => self::SCENARIO_DEMO],
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
        ];
    }
}
