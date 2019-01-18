<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Map;

/**
 * MapSearch represents the model behind the search form about `backend\models\Map`.
 */
class MapSearch extends Map
{
    public function attributes()
    {
        return parent::attributes();

        // add related fields to searchable attributes
        // return array_merge(parent::attributes(), ['author.name']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'from_id', 'to_id'], 'integer'],
            [['type'], 'safe'],
            // usefull when filtering on related columns
            //[['author.name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Map::find();
        /*
        $query = Map::find()->joinWith(['company']);
            ->where(['{{%company}}.category' => Company::CATEGORY_LOGISTICS]);
        if (Yii::$app->user->can('saler') && !Yii::$app->user->can('saleDirector')) {
            $query->andWhere(['{{%interaction}}.created_by' => Yii::$app->user->id]);
        }
        */

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                /*
                'office_phone',
                'group.name' => [
                    'asc'   => ['company.name' => SORT_ASC],
                    'desc'  => ['company.name' => SORT_DESC],
                ],
                'company.name' => [
                    'asc'  => ['CONVERT({{%company}}.full_name USING gbk)' => SORT_ASC],
                    'desc' => ['CONVERT({{%company}}.full_name USING gbk)' => SORT_DESC],
                ],
                */
            ],
            /* Warning: defaultOrder 内指定的列必须在上面的 attributes 内声明过，否则排序无效
            'defaultOrder' => [
                'group.name' => SORT_DESC,
            ],
            */
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'from_id' => $this->from_id,
            'to_id' => $this->to_id,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);
            //->andFilterWhere(['LIKE', 'user_group.name', $this->getAttribute('group.name')])
        return $dataProvider;
    }

    /**
     * Template
     * 无需 sort 和 pagination 的 data provider
     * @see 
     */
    public function tpl()
    {
        $query = Map::find();
        /*
        if (Yii::$app->user->can('saler')) {
            $query->andWhere([]);
        }
        */

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);
    }
}
