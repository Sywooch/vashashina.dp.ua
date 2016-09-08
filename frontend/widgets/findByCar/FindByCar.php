<?php namespace frontend\widgets\findByCar;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\PodborShiniDiski;

class FindByCar extends Widget
{
    public $params = ['vendor'=>'',
        'carModel'=>'','carMod'=>'',
        'carYear'=>''];

    public function init()
    {
        if (isset(Yii::$app->request->queryParams['PodborShiniDiski'])){
            $this->params = array_merge($this->params,Yii::$app->request->queryParams['PodborShiniDiski']);
        }
        parent::init();
       
    }

    public function run()
    {
        $data = [];
        $duration = 60*60*24;
        $dependency = new \yii\caching\DbDependency(['sql'=>'SELECT MAX(id) FROM '.PodborShiniDiski::tableName()]);
        $data['vendors'] = PodborShiniDiski::getDb()->cache(function ($db) {
    return ArrayHelper::map(PodborShiniDiski::find()
            ->select('DISTINCT (vendor)')
            ->orderBy(['vendor'=>'ASC'])
            ->where('vendor IS NOT NULL AND TRIM(IFNULL(vendor,"")) <> ""')
         //   ->groupBy('vendor')
            ->asArray()
            ->all(),'vendor','vendor');
},$duration,$dependency);

    $data['carModels'] = [];
if (isset($this->params['carModel']) && $this->params['carModel']){
    $cmodels = \common\models\PodborShiniDiski::find()
            ->select('DISTINCT(car)')
            ->orderBy(['car'=>'ASC'])
            ->where('car IS NOT NULL AND TRIM(IFNULL(car,"")) <> ""');
           if ($this->params['vendor'])
           $cmodels ->andWhere('vendor = :vendor',[':vendor'=>$this->params['vendor']]);
           $cmodels ->asArray();
       $result = $cmodels ->all();
  $data['carModels']  = \yii\helpers\ArrayHelper::map($result,'car','car');
}

    $data['carMods'] = [];
if (isset($this->params['carMod']) && $this->params['carMod']){
   $cms = \common\models\PodborShiniDiski::find()
            ->select('DISTINCT(modification)')
            ->orderBy(['modification'=>'ASC'])
            ->where('modification IS NOT NULL AND TRIM(IFNULL(modification,"")) <> ""');
   if ($this->params['vendor'])
           $cms ->andWhere('vendor = :vendor',[':vendor'=>$this->params['vendor']]);
   
   if ($this->params['carModel'])
          $cms  ->andWhere('car = :car',[':car'=>$this->params['carModel']]);
         $cms   ->asArray();
       $result =   $cms   ->all();
   //      var_dump($result);die;
  $data['carMods'] =  \yii\helpers\ArrayHelper::map($result,'modification','modification');
}

    $data['carYears'] = [];
if (isset($this->params['carYear']) && $this->params['carYear']){
  $carYear = \common\models\PodborShiniDiski::find()
            ->select('DISTINCT(year)')
            ->orderBy(['year'=>'ASC'])
            ->where('year IS NOT NULL AND TRIM(IFNULL(year,"")) <> ""');
  if ($this->params['vendor'])
      $carYear      ->andWhere('vendor = :vendor',[':vendor'=>$this->params['vendor']]);
  if ($this->params['carModel'])
       $carYear     ->andWhere('car = :car',[':car'=>$this->params['carModel']]);
   if ($this->params['carMod'])
     $carYear       ->andWhere('modification = :mod',[':mod'=>$this->params['carMod']]);
      $carYear      ->asArray();
     $result =   $carYear     ->all();
  $data['carYears']  =  \yii\helpers\ArrayHelper::map($result,'year','year');
}
      
        return $this->render('index',$data);
    }
}/* end of Widget*/
