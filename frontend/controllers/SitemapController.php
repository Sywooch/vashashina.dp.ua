<?php
namespace frontend\controllers;
/**
 * @author Alexander Kulyk
 * @copyright 2013
 */
use Yii;
use yii\web\Controller;

class SitemapController extends Controller
{
    const ALWAYS = 'always';
    const HOURLY = 'hourly';
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';
    const NEVER = 'never';
    
    Public $select = 'id, title, alias, updated';
    
    public function actionIndex()
    {
    	$duration = 60*60*24;
    
        $items = [];   
      
	
       // Категории к товарам
        $dependency = new \yii\caching\DbDependency([
        		'sql' => 'SELECT MAX(updated) FROM'.\common\models\Category::tableName(),
        ]);
        		
  
        $categories = \common\models\Category::getDb()->cache(function ($db) {
        	return \common\models\Category::find()->select($this->select)->all();
        },$duration,$dependency);
    /*
        // Products
        	$dependency = new \yii\caching\DbDependency([
        			'sql' => 'SELECT MAX(updated) FROM'.\common\models\Product::tableName(),
        	]);
        	$products = \common\models\Product::getDb()->cache(function ($db) {
        		return \common\models\Product::find()->select($this->select.', category_id, brand_id')->all();
        	},$duration,$dependency);
        $items = array_merge($items, $products);
        */
        
        // TiresModels
        $dependency = new \yii\caching\DbDependency([
        		'sql' => 'SELECT MAX(updated) FROM'.\common\models\tires\TireModel::tableName(),
        ]);
        $tires = \common\models\tires\TireModel::getDb()->cache(function ($db) {
        	return \common\models\tires\TireModel::find()->select($this->select.',brand_id,category_id')->all();
        },$duration,$dependency);
        
          // DiskModels
        $dependency = new \yii\caching\DbDependency([
        		'sql' => 'SELECT MAX(updated) FROM'.\common\models\disks\DiskModel::tableName(),
        ]);
        $disks = \common\models\disks\DiskModel::getDb()->cache(function ($db) {
        	return \common\models\disks\DiskModel::find()->select($this->select.',brand_id,category_id')->all();
        },$duration,$dependency);
        
        // News
        $dependency = new \yii\caching\DbDependency([
        			'sql' => 'SELECT MAX(updated) FROM'.\common\models\News::tableName(),
        	]);
        $news = \common\models\News::getDb()->cache(function ($db) {
        		return \common\models\News::find()->select($this->select)->all();
        	},$duration,$dependency);
        
         // Articles
        $dependency = new \yii\caching\DbDependency([
        			'sql' => 'SELECT MAX(updated) FROM'.\common\models\Article::tableName(),
        	]);
        $articles = \common\models\Article::getDb()->cache(function ($db) {
        		return \common\models\Article::find()->select($this->select)->all();
        	},$duration,$dependency);        
                
        // Pages
    /*    	$dependency = new \yii\caching\DbDependency([
        				'sql' => 'SELECT MAX(updated) FROM'.\common\models\Page::tableName(),
        		]);
        	$pages = \common\models\Page::getDb()->cache(function ($db) {
        			return \common\models\Page::find()->select($this->select)->all();
        		},$duration,$dependency);
        		*/
        
      	  //    $items = array_merge($items, $categories);
           //   $items = array_merge($items, $products);
              $items = array_merge($items, $tires);
              $items = array_merge($items, $disks);
              $items = array_merge($items, $news);
              $items = array_merge($items, $articles);
		 
 //   foreach($disks as $item) {var_dump(htmlspecialchars($item->getUrl()));}die;
       

	//	var_dump($items);die;
               Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
   $headers = Yii::$app->response->headers;
   $headers->add('Content-Type', 'text/xml');
   
    return  $this->renderPartial('index', array(
            'host'=>Yii::$app->request->hostInfo,
            'items'=>$items,
        ));  
   
    }
}/**/

?>