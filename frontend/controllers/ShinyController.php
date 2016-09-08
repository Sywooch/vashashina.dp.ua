<?php

namespace frontend\controllers;
use Yii;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

class ShinyController extends \yii\web\Controller
{
    use \frontend\traits\CommentTrait,\frontend\traits\SortandPageNaviTrait;
   
    public $layout = 'default';
    public $tab ='items';
 
    
    private $car_type_id;
    private $season_id;
    private $brand_id;
    private $width_id;
    private $profile_id;
    private $diameter_id;
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionTypeView($tire_type)
    {
        switch ($tire_type){
            case "Шины_для_легковых_автомобилей":
            case "legkovie":
             $url = ['/shiny/find','Tire[car_type]'=>1];
          
                break;
            case "Шины_для_внедорожников":
            case "vnedorozhniki":
          $url = ['/shiny/find','Tire[car_type]'=>2];
                break;
            case "Шины_для_грузовых_автомобилей":
            case "gruzovie":
         $url = ['/shiny/find','Tire[car_type]'=>4];
                break;
            case "Летние_шины":
            case "letnie_shini":
                 $url = ['/shiny/find','Tire[season]'=>'summerA'];
         
                break;
            case "Зимние_шины":
            case "zimnie_shini":
              $url = ['/shiny/find','Tire[season]'=>'winterA'];
                break;
            case "Всесезонные_шины":
                $url = ['/shiny/find','Tire[season]'=>'allSeasonA'];
         
                break;
        }
         return $this->redirect($url, 301);
         /*
        $this->where =$where;
        $query = \common\models\tires\Tire::find();
        $query->joinWith(['tireModel'=> function ($q) {
       $q->where($this->where);}]);
//var_dump($query);die;
    	$dataProvider = new ActiveDataProvider([
    			'query' =>  $query,
    			'pagination'=>['pageSize'=>6],
    			'sort'=>[
    					'attributes'=>[
    					'created'=>['default'=>SORT_DESC]],
    					],
    				//	'totalCount'=>6
    ]);
    //	 var_dump($dataProvider->getModels());die;
    return $this->render('typeView',['dataProvider' => $dataProvider,]);
       */
    }/**/

    public function actionView($model_alias,$tire_id = 0,$tab = 'items')
    {
        $this->tab = $tab;
      // var_dump($model_alias);die;
        $view = 'view';
    	$model = \common\models\tires\TireModel::find()->where('alias = :alias',[':alias'=>$model_alias])->one();
          if (!$model){
            throw new NotFoundHttpException();
        }
        if ($tire_id > 0){
        $tire = \common\models\tires\Tire::findOne((int)$tire_id);
  
        } else{
               $tire = \common\models\tires\Tire::find()
                       ->where('model_id = :model_id',[':model_id'=>$model->id])
                       ->orderBy('price ASC')
                       ->limit(1)
                       ->one();
        }
          if (!$tire){
            throw new NotFoundHttpException();
        }
      
        
    	$searchModel = new \frontend\models\TireSearch;
    	//	var_dump($searchModel->search(Yii::$app->request->queryParams,$model->id));die;
    	 
    	$tireProvider = $searchModel->search(Yii::$app->request->queryParams,$model->id);
    	if (Yii::$app->request->isAjax){
    return $this->renderPartial('_tireGridView',['tireProvider'=>$tireProvider]);
    	}else{
    	
      //  $this->layout ='column2';
    $comData =  $this->getComments($tire);
          
    	
    	
    	return $this->render($view,['model'=>$model,
            'tireProvider'=>$tireProvider, 'comments'=>$comData['comments'],
            'tire'=>$tire,'commentModel'=>$comData['commentModel'],
            'countComments'=>$comData['countComments']]);
    	}
    }/**/

    public function actionSelect(){
    	$this->width_id = Yii::$app->request->get('Tire')['width'];
    	$this->profile_id = Yii::$app->request->get('Tire')['profile'];
    	$this->diameter_id = Yii::$app->request->get('Tire')['radius'];
    	$this->car_type_id = Yii::$app->request->get('Tire')['car_type'];
    	$this->season_id = Yii::$app->request->get('Tire')['season'];
    	$this->brand_id = Yii::$app->request->get('Tire')['brand'];
    	$avalible = Yii::$app->request->get('avalible');
    	$sort = Yii::$app->request->get('sort');
    	
    	
    	if ($sort){
    	//	var_dump($sort);die;
    		$sort = explode('_',$sort);
    		$column = $sort[0];
    		$order = $sort[1];
    		switch ($column){
    			case 'price':
    				$table = \common\models\tires\Tire::tableName();
    				break;
    			case 'title':
    				$table = \common\models\tires\TireModel::tableName();
    				break;
    		}
    		$sort = $table.'.'.$column.' '.$order;}
    			else {$sort = \common\models\tires\Tire::tableName().'.created DESC';}
    	//var_dump($this->car_type_id);die;
    	
    	$query = \common\models\tires\Tire::find();
    	$query->joinWith(['tireModel'=> function ($q) {
    		$q->andFilterWhere(['=','car_type', $this->car_type_id]);
    		$q->andFilterWhere(['=','season', $this->season_id]);
    		$q->andFilterWhere(['=','brand_id', $this->brand_id]);
    	//	var_dump($q);die;
    	}]);
    	 	if ($avalible){
    	$query->where('quantity >0');
    	}
    	$query->andFilterWhere(['=','width_id',$this->width_id]);
    	$query->andFilterWhere(['=','profile_id',$this->profile_id]);
    	$query->andFilterWhere(['=','diameter_id',$this->diameter_id]);
    	$query->orderBy($sort);
    	//	var_dump($query);die;
    		$dataProvider = new ActiveDataProvider([
    				'query' =>  $query,
    				'pagination'=>['pageSize'=>6],
    		]);
    		//			 var_dump($dataProvider->getModels());die;
    		if(Yii::$app->request->isAjax){
    			return $this->renderAjax('typeView',['dataProvider' => $dataProvider,]);
    		}else{
    				return $this->render('typeView',['dataProvider' => $dataProvider,]);
    		}
    	
    }/**/
    
public function actionFind($onlyCount = FALSE){
     
                        if (Yii::$app->request->isPost){
    $tireParams = Yii::$app->request->post('Tire');
                        }
      if (Yii::$app->request->isGet){
    $tireParams = Yii::$app->request->get('Tire');
                        }                   
   // $tireModels =  \common\models\tires\TireModel::find();
    $tire = \common\models\tires\Tire::find();
   
    if (isset($tireParams['car_type']) && $tireParams['car_type'] && $tireParams['car_type']!='all'){
        // если пришло число
        if (is_numeric($tireParams['car_type'])){
             $this->car_type_id = $tireParams['car_type'];
    } else{
        $this->car_type_id = \common\models\tires\TireCarType::find()
                ->where('plural = :car_type',[':car_type'=>$tireParams['car_type']])
               
                ->one()->id;
    }
     
    }// end if
    if (isset($tireParams['season']) && $tireParams['season']){
        switch($tireParams['season']){
            case"summerA":
                $this->season_id = 3;
                break;
            case"winterA":
                $this->season_id = 2;
                break;
            case"allSeasonA":
                $this->season_id = 1;
                break;
            default :
                $this->season_id = 0;
                break;
        }
        
    
    }// end if season
     if (isset($tireParams['manufacturer_id']) && $tireParams['manufacturer_id']){
    $this->brand_id = (int)$tireParams['manufacturer_id'];
     }
     
    if (isset($tireParams['width']) && $tireParams['width'])
     $tire->andWhere ('width = :width', [':width'=>$tireParams['width']]);
    
    if (isset($tireParams['profile']) && $tireParams['profile'])
     $tire->andWhere ('profile = :profile', [':profile'=>$tireParams['profile']]);
    
    if (isset($tireParams['diameter']) && $tireParams['diameter']) 
     $tire->andWhere ('diameter = :diameter', [':diameter'=>$tireParams['diameter']]);
    
    if (isset($tireParams['ship']) && $tireParams['ship']){
        if ($tireParams['ship'] == 'шип'){
     $tire->andWhere ('ship = :ship', [':ship'=>$tireParams['ship']]);
        } else{
           $tire->andWhere ('(ship = :ship OR ship IS Null)', [':ship'=>$tireParams['ship']]); 
        }
    }
     
     if (isset($tireParams['minPrice']) && $tireParams['minPrice']) 
     $tire->andWhere ('price >= :minPrice', [':minPrice'=>$tireParams['minPrice']]);
    if (isset($tireParams['maxPrice']) && $tireParams['maxPrice'])
         $tire->andWhere ('price <= :maxPrice', [':maxPrice'=>$tireParams['maxPrice']]);
    
     $tire->andWhere ('quantity > 0');
     $tire->andWhere ('price > 0');
          
    $tire->joinWith(['tireModel'=> function ($q) {
        $q->joinWith(['brand']);
    if ($this->car_type_id){
    		$q->andFilterWhere(['=','car_type', $this->car_type_id]);
       if ($this->car_type_id == 4 || $this->car_type_id == 3){
            $q->orFilterWhere(['=','car_type', 7]);
               $q->orFilterWhere(['=','car_type', 8]);
                  $q->orFilterWhere(['=','car_type', 9]);
                     $q->orFilterWhere(['=','car_type', 10]);
        }
    }
    if ($this->season_id)
    		$q->andFilterWhere(['=','season', $this->season_id]);
      if ($this->brand_id)
    		$q->andFilterWhere(['=','brand_id', $this->brand_id]);
         
    }]);
    $db = Yii::$app->db;
      $duration = 60*60*24;
        $dependency = new \yii\caching\DbDependency(
           ['sql'=>'SELECT MAX(updated) FROM '.\common\models\tires\Tire::tableName()]);
       $count = $db->cache(function ($db) use ($tire) {
    return $tire->count();
}, $duration,$dependency);
      if(Yii::$app->request->isAjax && $onlyCount == TRUE){
          
     echo $count;
    }else{
     //   Yii::$classMap['LinkPager'] = '@vendor/kulyk/widgets/LinkPager.php';
     
       // var_dump(Yii::$app->request->get());
   
        $this->setPerPage();
             
       
       
        $tire->orderBy($this->getSortOrder('Tire'));
     //   var_dump($tire);die;
        
       $dataProvider = new ActiveDataProvider([
    				'query' =>  $tire,
    				'pagination'=>['pageSize'=>Yii::$app->session['perPage'],'defaultPageSize'=>5],
    				
    		]);
       
       
       Yii::$app->db->cache(function ($db) use ($dataProvider) {
      return $dataProvider->prepare();
        },60*60*24,$dependency);
       
       if ($onlyCount === FALSE){
        return $this->render('viewTires',['dataProvider'=>$dataProvider,'count'=>$count]);
       }else{
           return $this->renderPartial('_tiresPjax',['dataProvider'=>$dataProvider,'count'=>$count]);  
       }
    }
     
}/**/
    
}/**/
