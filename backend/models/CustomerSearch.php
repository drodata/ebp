<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use drodata\validators\DateRangeValidator;
use backend\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `backend\models\Customer`.
 */
class CustomerSearch extends Customer
{
    public function attributes()
    {
        return array_merge(parent::attributes(), ['user.username']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'safe'],
            [['price_group_id'], 'integer'],
            // usefull when filtering on related columns
            [['user.username'], 'safe'],
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
        $query = Customer::find()->joinWith(['user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name' => [
                    'asc'  => ['CONVERT({{%customer}}.name USING gbk)' => SORT_ASC],
                    'desc' => ['CONVERT({{%customer}}.name USING gbk)' => SORT_DESC],
                ],
                'user.username' => [
                    'asc'  => ['{{%user}}.username' => SORT_ASC],
                    'desc' => ['{{%user}}.username' => SORT_DESC],
                ],
            ],
            // Warning: defaultOrder 内指定的列必须在上面的 attributes 内声明过，否则排序无效
            'defaultOrder' => [
                'id' => SORT_DESC,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'price_group_id' => $this->price_group_id,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', '{{%user}}.username', $this->getAttribute('user.username')]);

        return $dataProvider;
    }

}
