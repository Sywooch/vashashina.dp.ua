<?php

namespace frontend\controllers;
use yii\data\ActiveDataProvider;

class ProductsController extends \yii\web\Controller
{
	public $layout ='column3';
	
    public function actionIndex()
    {
        return $this->render('index');
    }/**/

     public function actionCategoryView($category_alias)
    {
    	$category = \common\models\Category::find()->where('alias = :alias',[':alias'=>$category_alias])
    	->select('id,title,alias,page_title,meta_k,meta_d')->one();
    	$dataProvider = new ActiveDataProvider([
    			'query' =>  \common\models\Product::find()->where(['category_id'=>$category->id])->orderBy('created DESC'),
    			'pagination'=>['pageSize'=>6],
    			'sort'=>[
    					'attributes'=>[
    					'created'=>['default'=>SORT_DESC]],
    					],
    					//'totalCount'=>6
    ]);
    	
    	return $this->render('categoryView',[
    							'dataProvider' => $dataProvider,
    							'category'=>$category,
        ]);
      
    }

    public function actionView($product_alias)
    {
    	$this->layout ='column2';
    	$model = \common\models\Product::find()->where('alias = :alias',[':alias'=>$product_alias])->one();
        return $this->render('view',['model'=>$model]);
    }

}/**/
