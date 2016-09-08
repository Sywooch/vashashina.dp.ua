<?php

namespace frontend\controllers;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class DiskiController extends \yii\web\Controller
{
     use \frontend\traits\CommentTrait,\frontend\traits\SortandPageNaviTrait;
    public $layout = 'default';
    public $tab ='items';

    
    private $tip;
    private $pcd;
    private $et;
    private $width;
    private $brand_id;
    private $diameter;
    
    public function actionIndex()
    {
        return $this->render('index');
    }/**/
    
    

    public function actionView($model_alias,$disk_id = 0, $tab = 'items')
    {
         $this->tab = $tab;
    	$model = \common\models\disks\DiskModel::find()->where('alias = :alias',[':alias'=>$model_alias])->one();
    	 
    	$searchModel = new \frontend\models\DiskSearch;
    	//	var_dump($searchModel->search(Yii::$app->request->queryParams,$model->id));die;
    	    if (!$model){
            throw new NotFoundHttpException();
        }
        if ($disk_id > 0){
        $disk = \common\models\disks\Disk::findOne((int)$disk_id);
  
        } else{
               $disk = \common\models\disks\Disk::find()
                       ->where('model_id = :model_id',[':model_id'=>$model->id])
                       ->orderBy('price ASC')
                       ->limit(1)
                       ->one();
        }
          if (!$disk){
            throw new NotFoundHttpException();
        } 
    	$diskProvider = $searchModel->search(Yii::$app->request->queryParams,$model->id);
    	if (Yii::$app->request->isAjax){
    return $this->renderAjax('_diskGridView',['diskProvider'=>$diskProvider]);
    	}else{
  $comData =  $this->getComments($disk);
    	return $this->render('view',['model'=>$model,'diskProvider'=>$diskProvider,
            'disk'=>$disk,'commentModel'=>$comData['commentModel'],
            'countComments'=>$comData['countComments'],'comments'=>$comData['comments']]);
    	}
    }/**/

       
public function actionFind($onlyCount = FALSE){
     
  
   if (Yii::$app->request->isPost){
    $diskParams = Yii::$app->request->post('Disk');
                        }
      if (Yii::$app->request->isGet){
    $diskParams = Yii::$app->request->get('Disk');
                        }
                        
    $diskModels =  \common\models\disks\DiskModel::find();
    $disk = \common\models\disks\Disk::find();
   
    if (isset($diskParams['disk_type'])&& $diskParams['disk_type']!='all'){
        switch ($diskParams['disk_type']){
            case "Стальные":
                $this->tip = "стальной";
                break;
            case "Литые":
                $this->tip = "литой";
                break;
            case "Кованные":
                $this->tip = "кованный";
                break;
        }
       
     
    }// end if
    
     if (isset ($diskParams['manufacturer_id']) && $diskParams['manufacturer_id']){
    $this->brand_id = (int)$diskParams['manufacturer_id'];
     }
     
    if (isset ($diskParams['width']) && $diskParams['width']) 
     $disk->andWhere ('width = :width', [':width'=>$diskParams['width']]);
    
    if (isset ($diskParams['pcd']) && $diskParams['pcd']) 
     $disk->andWhere ('pcd = :pcd', [':pcd'=>$diskParams['pcd']]);
    
    if (isset ($diskParams['et']) && $diskParams['et']) 
     $disk->andWhere ('et = :et', [':et'=>$diskParams['et']]);
    
    if (isset ($diskParams['diameter']) && $diskParams['diameter']) 
     $disk->andWhere ('diameter = :diameter', [':diameter'=>$diskParams['diameter']]);
     
    if (isset ($diskParams['minPrice']) && $diskParams['minPrice']) 
     $disk->andWhere ('price >= :minPrice', [':minPrice'=>$diskParams['minPrice']]);
     
    if (isset ($diskParams['maxPrice']) && $diskParams['maxPrice'])
         $disk->andWhere ('price <= :maxPrice', [':maxPrice'=>$diskParams['maxPrice']]);
    
     $disk->andWhere ('quantity > 0');
     $disk->andWhere ('price > 0');
          
    $disk->joinWith(['diskModel'=> function ($q) {
         $q->joinWith(['brand']);
    if ($this->tip)
    		$q->andFilterWhere(['=','tip', $this->tip]);
    if ($this->brand_id)
    		$q->andFilterWhere(['=','brand_id', $this->brand_id]);
    }]);
     $db = Yii::$app->db;
      $duration = 60*60*24;
       $dependency = new \yii\caching\DbDependency(['sql'=>'SELECT MAX(updated) FROM '.
           \common\models\disks\Disk::tableName()]);
       $count = $db->cache(function ($db) use ($disk) {
    return $disk->count();
}, $duration,$dependency);
      if(Yii::$app->request->isAjax && $onlyCount == TRUE){
     echo $count;
    }else{
        
         
       $this->setPerPage();
        
 
        
         $disk->orderBy($this->getSortOrder('Disk'));
        
       $dataProvider = new ActiveDataProvider([
    				'query' =>  $disk,
    				'pagination'=>['pageSize'=>Yii::$app->session['perPage'],'defaultPageSize'=>5],
    				
    		]);
     
       Yii::$app->db->cache(function ($db) use ($dataProvider) {
      return $dataProvider->prepare();
        },$duration,$dependency);
        
         if ($onlyCount === FALSE){
        return $this->render('viewDisks',['dataProvider'=>$dataProvider,'count'=>$count]);
       }else{
           return $this->renderPartial('_disksPjax',['dataProvider'=>$dataProvider,'count'=>$count]);  
       }
    }
     
}/**/
    
}/**/
