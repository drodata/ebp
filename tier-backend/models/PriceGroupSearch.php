<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use drodata\validators\DateRangeValidator;
use backend\models\PriceGroup;

/**
 * PriceGroupSearch represents the model behind the search form about `backend\models\PriceGroup`.
 */
class PriceGroupSearch extends PriceGroup
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
            [['id', 'currency_code', 'name'], 'safe'],
            [['is_base'], 'integer'],
            [['discount'], 'number'],
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
        $query = PriceGroup::find();
        /*
        $query = PriceGroup::find()->joinWith(['company']);
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
            'is_base' => $this->is_base,
            'discount' => $this->discount,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'currency_code', $this->currency_code])
            ->andFilterWhere(['like', 'name', $this->name]);
            //->andFilterWhere(['like', '{{%t}}.c', $this->getAttribute('t.c')]);

        return $dataProvider;
    }

}
