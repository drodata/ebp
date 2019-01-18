<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string $parent_id
 * @property string $team_id
 *
 * @property Team $team
 * @property User[] $users
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'parent_id', 'team_id'], 'required'],
            [['parent_id', 'team_id'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['slug'], 'string', 'max' => 30],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
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
            'slug' => 'Slug',
            'parent_id' => 'Parent ID',
            'team_id' => 'Team ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['department_id' => 'id']);
    }
}
