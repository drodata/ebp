<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidConfigException;

class UploadForm extends Model
{
    public $key; // 各个模型的主键值
    public $files;

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

	public function upload()
	{
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->uploadAttachment();
            $transaction->commit();
            return true;
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    protected function uploadAttachment()
    {
        list($attributes, $junctionModelClass, $junctionAttribute) = $this->getUploadParams();

        foreach ($this->files as $file) {
            $media = new Attachment($attributes);
            $media->name = $file->name;

            $media->storeFile($file);

            if (!$media->save()) {
                throw new \yii\db\Exception($media->stringifyErrors());
            }

            $junction = new $junctionModelClass([
                $junctionAttribute => $this->key,
                'attachment_id' => $media->id,
            ]);

            if (!$junction->save()) {
                throw new \yii\db\Exception($junction->stringifyErrors());
            }
        }
    }

    protected function getUploadParams()
    {
        switch ($this->scenario) {
            case self::SCENARIO_SPU_IMAGE:
                $attributes = [
                    'format' => Attachment::FORMAT_IMG,
                    'category' => Attachment::CATEGORY_SPU_IMAGE,
                ];
                $junctionModelClass = '\backend\models\SpuImage';
                $junctionAttribute = 'spu_id';
                break;
        }

        return [$attributes, $junctionModelClass, $junctionAttribute];
    }
}

