<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property string $id
 * @property string $name
 * @property integer $level
 *
 * @property Department[] $departments
 * @property Shop[] $shops
 */
class Team extends \yii\db\ActiveRecord
{
    const LEVEL_BASIC = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'level'], 'required'],
            [['level'], 'integer'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'level' => 'Level',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Department::className(), ['team_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShops()
    {
        return $this->hasMany(Shop::className(), ['team_id' => 'id']);
    }
}
