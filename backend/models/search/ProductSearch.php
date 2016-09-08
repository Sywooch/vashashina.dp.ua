<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form about `common\models\Product`.
 */
class ProductSearch extends Product
{
	public $category;
    public $brand;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'category_id', 'featured', 'price', 'quantity', 'views', 'discount_begin', 'discount_end', 'created', 'updated', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias', 'pageTitle', 'meta_d', 'meta_k', 'short_desc', 'long_desc', 'thumbnail', 'image', 'grouping','category','brand'], 'safe'],
            [['discount'], 'number'],
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
        $query = Product::find();
        
        $query->joinWith(['category','brand']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $dataProvider->sort->attributes['category'] = [
        		// The tables are the ones our relation are configured to
        		// in my case they are prefixed with "tbl_"
        		'asc' => [ \common\models\Category::tableName().'.title' => SORT_ASC],
        		'desc' => [ \common\models\Category::tableName().'.title' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['brand'] = [
        		// The tables are the ones our relation are configured to
        		// in my case they are prefixed with "tbl_"
        		'asc' => [ \common\models\Brand::tableName().'.title' => SORT_ASC],
        		'desc' => [ \common\models\Brand::tableName().'.title' => SORT_DESC],
        ];

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'category_id' => $this->category_id,
            'featured' => $this->featured,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'discount' => $this->discount,
            'views' => $this->views,
            'discount_begin' => $this->discount_begin,
            'discount_end' => $this->discount_end,
            'created' => $this->created,
            'updated' => $this->updated,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like',  parent::tableName().'.title', $this->title])
            ->andFilterWhere(['like',  parent::tableName().'.alias', $this->alias])
            ->andFilterWhere(['like', parent::tableName().'.pageTitle', $this->pageTitle])
            ->andFilterWhere(['like', parent::tableName().'.meta_d', $this->meta_d])
            ->andFilterWhere(['like', parent::tableName().'.meta_k', $this->meta_k])
            ->andFilterWhere(['like', 'short_desc', $this->short_desc])
            ->andFilterWhere(['like', 'long_desc', $this->long_desc])
            ->andFilterWhere(['like', 'thumbnail', $this->thumbnail])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'grouping', $this->grouping])
            ->andFilterWhere(['like', \common\models\Category::tableName().'.title', $this->category])
            ->andFilterWhere(['like', \common\models\Brand::tableName().'.title', $this->brand])
        ;

        return $dataProvider;
    }/**/
    
    public function getGridColumns(){
    	$data = [];
    	 
    	$data = [['class' => 'yii\grid\SerialColumn']];
    
    	$data +=['id','id','title',
    			['attribute'=>'category','value'=>function($model){return $model->category->title;}],
                        ['attribute'=>'brand','value'=>function($model){return $model->brand->title;}],
    			'quantity','price',
    			'discount','views'];
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
