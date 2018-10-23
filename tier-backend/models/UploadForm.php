<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidConfigException;

class UploadForm extends \dro\attachment\UploadForm
{
    public $modelClass = 'backend\models\Attachment';
    public $modelFkName = 'attachment_id';

	const SCENARIO_SPU_IMAGE = 'spu-image';

    public function rules()
    {
        return [
            [
                'files',
                'image',
                'extensions' => ['png', 'jpg'],
                'skipOnEmpty' => false,
                'skipOnError' => false,
                'maxFiles' => 2,
                'on' => self::SCENARIO_SPU_IMAGE,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        switch ($this->scenario) {
            case self::SCENARIO_SPU_IMAGE:
                $files = '产品图片';
                break;
            default:
                $files = '图片';
                break;
        }

        return [
            'files' => $files,
        ];
    }

    public function getUploadParams()
    {
        switch ($this->scenario) {
            case self::SCENARIO_SPU_IMAGE:
                $attributes = [
                    'format' => Attachment::FORMAT_IMG,
                ];
                $junctionModelClass = '\backend\models\SpuImage';
                $junctionAttribute = 'spu_id';
                break;
        }

        return [$attributes, $junctionModelClass, $junctionAttribute];
    }
}

