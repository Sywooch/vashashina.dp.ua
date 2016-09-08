<?php

namespace backend\models\search\disks;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\disks\DiskModel;

/**
 * DiskModelSearch represents the model behind the search form about `common\models\disks\DiskModel`.
 */
class DiskModelSearch extends DiskModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'category_id', 'views', 'created', 'updated', 'status', 'featured', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias', 'pageTitle', 'meta_k', 'meta_d', 'short_desc', 'long_desc', 'tip', 'image', 'thumbnail'], 'safe'],
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
        $query = DiskModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'brand_id' => $this->brand_id,
            'category_id' => $this->category_id,
            'views' => $this->views,
            'created' => $this->created,
            'updated' => $this->updated,
            'status' => $this->status,
            'featured' => $this->featured,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'pageTitle', $this->pageTitle])
            ->andFilterWhere(['like', 'meta_k', $this->meta_k])
            ->andFilterWhere(['like', 'meta_d', $this->meta_d])
            ->andFilterWhere(['like', 'short_desc', $this->short_desc])
            ->andFilterWhere(['like', 'long_desc', $this->long_desc])
            ->andFilterWhere(['like', 'tip', $this->tip])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'thumbnail', $this->thumbnail]);

        return $dataProvider;
    }
}
