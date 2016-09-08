<?php namespace backend\widgets\selectPerPage;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use common\models\Order;

class SelectPerPage extends Widget
{
    public $modelName;
   
    public $options = [10=>10,20=>20,50=>50,
                       100=>100,250=>250,500=>500,
                       1000=>1000,2000=>2000,
                       4000=>4000,6000=>6000,-1=>'Все'];

    public function init()
    {
        if (yii::$app->request->get('per-page') !== NULL){
          yii::$app->session['perPage'] = yii::$app->request->get('per-page');  
        }
        parent::init();
       
    }/**/

    public function run()
    {
    
        $data = [];
        $data['options'] = $this->options;
        $data['selected'] = yii::$app->session['perPage'];
         $data['name']='per-page';
    if ($this->modelName){
      //  $data['modelName'] = $this->modelName;
        $data['name'] =$this->modelName.'['.$data['name'].']';
        }
        return $this->render('index',$data);
      
    }/**/
}/* end of Widget*/
