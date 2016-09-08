<?php namespace frontend\traits;
use Yii;
trait SortandPageNaviTrait
{
    public function getSortOrder($type='Product') {
         if (!Yii::$app->session->get($type)){
           
            Yii::$app->session->set($type,[]);
        
        }
    if (isset(Yii::$app->request->get($type)['sort'])){
          
            $sort['sort']=Yii::$app->request->get($type)['sort'];
           Yii::$app->session[$type] = $sort ;
        }
     //   var_dump( Yii::$app->session[$type]);
        switch ($type){
            case 'Tire':
                $brand = '\common\models\tires\TireManufacturer';
                $item = '\common\models\tires\TireModel';
                break;
            case 'Disk':
                $brand = '\common\models\disks\DiskManufacturer';
                $item = '\common\models\disks\DiskModel';
                break;
             case 'Product':
                $brand = '\common\models\Brand';
                $item = '\common\models\Product';
                break;
        }
         if (!isset(Yii::$app->session[$type]['sort'])){
                 $sort['sort']= $order = 'price ASC';
           Yii::$app->session[$type] = $sort ;
         }
        
         if (isset(Yii::$app->session[$type]['sort'])){
        	$order = Yii::$app->session[$type]['sort'];
             
        	if (strstr($order, 'title')){
        		$sr = explode(' ', $order);
        		$direction = $sr[1];
        		$col = $sr[0];
        		$order = $brand::tableName().'.'.$col;
        		$order .= ' '.$direction;
        		$order .=',';
        		$order .= $item::tableName().'.'.$col;
        		$order .= ' '.$direction;
        	}
  // var_dump($order);die;
        } 
    
  //     var_dump( Yii::$app->session[$type]);die;
        return $order;
  
    }/**/
    
    private function setPerPage($default = 9){
            if (Yii::$app->request->get('per-page') || Yii::$app->request->get('per-page') == 0){
            Yii::$app->session['perPage'] = Yii::$app->request->get('per-page');
        }
         if (!isset(Yii::$app->session['perPage'])){
          Yii::$app->session['perPage'] = $default;  
        } 
    }/**/
    
}/*end of trait*/