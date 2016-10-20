<?php

namespace backend\models\search\tires;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\tires\Tire;
use common\models\tires\TireModel;
use common\models\tires\TireManufacturer;
use common\models\tires\TireCarType;
use common\models\tires\TireSeason;

/**
 * TireSearch represents the model behind the search form about `app\models\Tire`.
 */
class TireSearch extends Tire
{
    public $brandTitle;
    public $modelTitle;
    public $tireModel;
    public $params;
    public $carTypeTitle;
    public $tireSeasonTitle;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'quantity', 'category_id', 'discount_begin', 'discount_end', 'status', 'created', 'updated', 'created_by', 'update_by'], 'integer'],
            [['brandTitle','carTypeTitle','tireSeasonTitle','tireModel','params', 'full_title', 'ship', 'usilennaya'], 'safe'],
            [['width', 'profile', 'diameter', 'max_load', 'max_speed'],'string'],
             [['width', 'profile', 'diameter'],'number'],
            [['price', 'discount'], 'number']
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
    //    var_dump($params);die;
        $query = Tire::find();
        if ($model_id > 0) $query->andWhere (['model_id'=>$model_id]);
           $query->joinWith(['tireModel']);
             $query->joinWith(['tireModel'=> function ($q) {
        $q->joinWith(['brand','carType','tireSeason']);
        
             }]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
       $dataProvider->sort->attributes['brandTitle']= [
                'asc' => [TireManufacturer::tableName().'.title' => SORT_ASC],
                'desc' => [TireManufacturer::tableName().'.title' => SORT_DESC],
             //   'label' => 'Full Name',
              //  'default' => SORT_ASC 
        ];
        $dataProvider->sort->attributes['tireModel']= [
                'asc' => [TireModel::tableName().'.title' => SORT_ASC],
                'desc' => [TireModel::tableName().'.title' => SORT_DESC],
              //  'label' => 'Full Name',
              //  'default' => SORT_ASC 
        ];
        $dataProvider->sort->attributes['carTypeTitle']= [
                'asc' => [TireCarType::tableName().'.title' => SORT_ASC],
                'desc' => [TireCarType::tableName().'.title' => SORT_DESC],
              //  'label' => 'Full Name',
              //  'default' => SORT_ASC 
        ];
        $dataProvider->sort->attributes['tireSeasonTitle']= [
                'asc' => [TireSeason::tableName().'.title' => SORT_ASC],
                'desc' => [TireSeason::tableName().'.title' => SORT_DESC],
              //  'label' => 'Full Name',
              //  'default' => SORT_ASC 
        ];
       
        if (yii::$app->request->get('per-page') !== NULL){
            $dataProvider->pagination->pageSize=yii::$app->request->get('per-page');
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'model_id' => $this->model_id,
            'width' => $this->width,
            'profile' => $this->profile,
            'diameter' => $this->diameter,
            'max_load' => $this->max_load,
            'max_speed' => $this->max_speed,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'discount' => $this->discount,
            'discount_begin' => $this->discount_begin,
            'discount_end' => $this->discount_end,
            'status' => $this->status,
            'created' => $this->created,
            'updated' => $this->updated,
            'created_by' => $this->created_by,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere([ TireModel::tableName().'.id' => $this->tireModel])
                ->andFilterWhere([ TireManufacturer::tableName().'.id' => $this->brandTitle])
                 ->andFilterWhere([ TireCarType::tableName().'.id' => $this->carTypeTitle])
                 ->andFilterWhere([ TireSeason::tableName().'.id' => $this->tireSeasonTitle])
                ->andFilterWhere(['like', 'full_title', $this->full_title])
            ->andFilterWhere(['like', 'ship', $this->ship])
            ->andFilterWhere(['like', 'usilennaya', $this->usilennaya]);

        return $dataProvider;
    }/**/
    
    
    public function getGridColumns(){
    	$data = [];
    
    	$data = [['class' => 'yii\grid\SerialColumn']];
    
    	$data +=[ 'id','id',
    			['attribute'=> 'full_title',
    					'value'=>function($model){return $model->title;}    ],
    	      ['attribute'=> 'model_id','value'=>function($model){return $model->model->title;}],
    	      ['attribute'=> 'width','value'=>function($model){return intval($model->width);}],
    	['attribute'=> 'profile','value'=>function($model){return (int)$model->profile;}],
    			 'diameter',
    			 'max_load',
    			 'max_speed',
    			'ship',
    			'usilennaya',
    			'quantity',
    			'price',
    			// 'category_id',
    			// 'discount',
    			// 'discount_begin',
    			// 'discount_end',
    			'views',
    			// 'status',
    			// 'created',
    			// 'updated',
    			// 'created_by',
    			// 'update_by'
    	];
    	/*     $attributes = $this->attributes();
    	 foreach ($attributes as $attribute){
    	 array_push($data,  ['attribute'=>$attribute]);
    	 }
    	 *
    	*/
    	// $data = ['brend','model'];
    	array_push($data,['class' => 'yii\grid\ActionColumn']);
    	return $data;//
    	//
    }/**/
    
}/**/
