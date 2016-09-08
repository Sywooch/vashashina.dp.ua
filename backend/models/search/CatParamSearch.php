<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CatParam;
use common\models\Category;

/**
 * CatParamSearch represents the model behind the search form about `common\models\CatParam`.
 */
class CatParamSearch extends CatParam
{
	public $category;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat_id', 'created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['title','category'], 'safe'],
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
        $query = CatParam::find();
        
        $query->joinWith(['category']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['category'] = [
        		// The tables are the ones our relation are configured to
        		// in my case they are prefixed with "tbl_"
        		'asc' => ['vs_category.title' => SORT_ASC],
        		'desc' => ['vs_category.title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'cat_id' => $this->cat_id,
            'created' => $this->created,
            'updated' => $this->updated,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', CatParam::tableName().'.title', $this->title]);
        $query->andFilterWhere(['like', Category::tableName().'.title', $this->category]);
        

        return $dataProvider;
    }
}
