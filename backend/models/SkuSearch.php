<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use drodata\validators\DateRangeValidator;
use backend\models\Sku;

/**
 * SkuSearch represents the model behind the search form about `backend\models\Sku`.
 */
class SkuSearch extends Sku
{
    public function attributes()
    {
        return array_merge(parent::attributes(), ['price.value']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'description', 'introduction'], 'safe'],
            [['spu_id', 'status', 'visible', 'stock', 'threshold'], 'integer'],
            // usefull when filtering on related columns
            [['price.value'], 'safe'],
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
        $query = Sku::find()->joinWith(['price']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name',
                'status',
                'stock',
                'threshold',
                'description',
                'price.value' => [
                    'asc'  => ['{{%price}}.value' => SORT_ASC],
                    'desc' => ['{{%price}}.value' => SORT_DESC],
                ],
                /*
                'company.name' => [
                    'asc'  => ['CONVERT({{%company}}.full_name USING gbk)' => SORT_ASC],
                    'desc' => ['CONVERT({{%company}}.full_name USING gbk)' => SORT_DESC],
                ],
                */
            ],
            // Warning: defaultOrder 内指定的列必须在上面的 attributes 内声明过，否则排序无效
            'defaultOrder' => [
                //'created_at' => SORT_DESC,
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
            'spu_id' => $this->spu_id,
            'status' => $this->status,
            'visible' => $this->visible,
            'stock' => $this->stock,
            'threshold' => $this->threshold,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'introduction', $this->introduction])
            ->andFilterWhere(['like', 'price.value', $this->getAttribute('price.value')]);

        return $dataProvider;
    }

}
