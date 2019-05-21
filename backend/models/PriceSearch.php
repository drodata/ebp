<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use drodata\validators\DateRangeValidator;
use backend\models\Price;

/**
 * PriceSearch represents the model behind the search form about `backend\models\Price`.
 */
class PriceSearch extends Price
{
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            // add related fields to searchable attributes
        ]);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['sku_id'], 'integer'],
            [['value'], 'number'],
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
        $query = Price::find();
        /*
        $query = Price::find()->joinWith(['company']);
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
                'company.x' => [
                    'asc'  => ['{{%company}}.x USING gbk)' => SORT_ASC],
                    'desc' => ['{{%company}}.x USING gbk)' => SORT_DESC],
                ],
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
            'sku_id' => $this->sku_id,
            'value' => $this->value,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id]);
            //->andFilterWhere(['like', '{{%t}}.c', $this->getAttribute('t.c')]);

        return $dataProvider;
    }

}
