<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\News;

/**
 * NewsSearch represents the model behind the search form about `common\models\News`.
 */
class NewsSearch extends News
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'views', 'created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias', 'page_title', 'meta_d', 'meta_k', 'desc', 'text'], 'safe'],
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
        $query = News::find();
      

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'sort'=> ['defaultOrder' => ['created'=>SORT_DESC]]
        ]);
     

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
        	
            return $dataProvider;
        }
        if ($this->alias == "-2"){$this->alias = NULL;}

        $query->andFilterWhere([
            'id' => $this->id,
        	'views' => $this->views,
            'created' => $this->created,
            'updated' => $this->updated,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'page_title', $this->page_title])
            ->andFilterWhere(['like', 'meta_d', $this->meta_d])
            ->andFilterWhere(['like', 'meta_k', $this->meta_k])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
