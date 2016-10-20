<?php

namespace backend\models\search\tires;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\tires\TireModel;
use common\models\tires\TireManufacturer;

/**
 * TireModelSearch represents the model behind the search form about `app\models\TireModel`.
 */
class TireModelSearch extends TireModel
{
        public $brand;
	public $brand_id;
        public $desc;
        public $img;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'car_type', 'season', 'created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias','img','desc', 'pageTitle','brand', 'meta_k', 'meta_d', 'short_desc', 'long_desc', 'image', 'thumbnail', 'status', 'featured'], 'safe'],
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
        $query = TireModel::find();
        
        $query->joinWith(['brand']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['brand'] = [
        		// The tables are the ones our relation are configured to
        		// in my case they are prefixed with "tbl_"
        		'asc' => ['vs_tires_manufactures.title' => SORT_ASC],
        		'desc' => ['vs_tires_manufactures.title' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'brand_id' => $this->brand_id,
            'car_type' => $this->car_type,
            'season' => $this->season,
          
        ]);

        $query->andFilterWhere(['like', parent::tableName().'.title', $this->title])
            ->andFilterWhere(['like', parent::tableName().'.alias', $this->alias])
            ->andFilterWhere(['like', 'pageTitle', $this->pageTitle])
            ->andFilterWhere(['like', 'meta_k', $this->meta_k])
            ->andFilterWhere(['like', 'meta_d', $this->meta_d])
            ->andFilterWhere(['like', 'short_desc', $this->short_desc])
            ->andFilterWhere(['like', 'long_desc', $this->long_desc])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'thumbnail', $this->thumbnail])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'featured', $this->featured]);
     $query->andFilterWhere(['like', TireManufacturer::tableName().'.title', $this->brand]);
    
     if ($this->desc && $this->desc == 1){
         $query->andWhere('long_desc IS NOT NULL');
     } 
      if ($this->desc === '0'){
         $query->andWhere('long_desc IS NULL');
     }

        return $dataProvider;
    }
    
    
 
}/**/
