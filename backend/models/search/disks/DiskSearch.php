<?php

namespace backend\models\search\disks;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\disks\Disk;

/**
 * DiskSearch represents the model behind the search form about `common\models\disks\Disk`.
 */
class DiskSearch extends Disk
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'quantity', 'category_id', 'discount_begin', 'discount_end', 'views', 'status', 'created', 'updated', 'created_by', 'update_by'], 'integer'],
            [['full_title', 'width', 'diameter', 'pcd','pcd2','stupitsa','et'], 'safe'],
            [['price', 'discount'], 'number'],
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
    public function search($params,$model_id = 0)
    {
        $query = Disk::find();
        if ($model_id > 0) $query->andWhere (['model_id'=>$model_id]);
        
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
            'model_id' => $this->model_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'discount' => $this->discount,
            'discount_begin' => $this->discount_begin,
            'discount_end' => $this->discount_end,
            'views' => $this->views,
            'status' => $this->status,
            'created' => $this->created,
            'updated' => $this->updated,
            'created_by' => $this->created_by,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'full_title', $this->full_title])
            ->andFilterWhere(['like', 'width', $this->width])
            ->andFilterWhere(['like', 'diameter', $this->diameter])
            ->andFilterWhere(['like', 'pcd', $this->pcd])
            ->andFilterWhere(['like', 'et', $this->et]);

        return $dataProvider;
    }
}
