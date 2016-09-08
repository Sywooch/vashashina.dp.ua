<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductParam;
use common\models\CatParam;
use common\models\Product;

/**
 * ProductParamSearch represents the model behind the search form about `common\models\ProductParam`.
 */
class ProductParamSearch extends ProductParam
{
	public $product;
	public $catParam;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'param_id'], 'integer'],
            [['value','product','catParam'], 'safe'],
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
        $query = ProductParam::find();
        $query->joinWith(['product','catParam']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['product'] = [
        		// The tables are the ones our relation are configured to
        		// in my case they are prefixed with "tbl_"
        		'asc' => [ Product::tableName().'.title' => SORT_ASC],
        		'desc' => [ Product::tableName().'.title' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['catParam'] = [
        		// The tables are the ones our relation are configured to
        		// in my case they are prefixed with "tbl_"
        		'asc' => ['vs_cat_params.title' => SORT_ASC],
        		'desc' => ['vs_cat_params.title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'value', $this->value])
        ->andFilterWhere(['like', Product::tableName().'.title', $this->product])
        ->andFilterWhere(['like', CatParam::tableName().'.title', $this->catParam]);

        return $dataProvider;
    }
}
