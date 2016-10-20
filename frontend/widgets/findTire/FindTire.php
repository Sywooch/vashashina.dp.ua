<?php namespace frontend\widgets\findTire;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\tires\TireManufacturer;
use common\models\tires\Tire;


class FindTire extends Widget
{
    public $view = 'index';
    public $params = ['car_type' => '',
  'diameter' => '',
  'width' => '',
  'profile' => '',
  'season' => '',
  'ship' => '',
  'manufacturer_id' => '',
  'minPrice' => '',
  'maxPrice' => ''];
   // public $minPrice;
   //  public $maxPrice;

    public function init()
    {
        if (Yii::$app->request->isGet && isset(Yii::$app->request->queryParams['Tire'])){
            $this->params = array_merge($this->params,Yii::$app->request->queryParams['Tire']);
            if (!isset($this->params['ship'])) $this->params['ship'] = '';
        }
        parent::init();
        
    }

    public function run()
    {
        $data = [];
        $duration = 60*60*24*7;
        $dependencyT = new \yii\caching\DbDependency([
            'sql'=>'SELECT MAX(updated) FROM '.Tire::tableName(),
            'reusable'=>true]);
        $dependencyTM = new \yii\caching\DbDependency([
            'sql'=>'SELECT MAX(updated) FROM '.TireManufacturer::tableName(),
            'reusable'=>true]);
        // getting tires manufacturers
        $data['tm'] = TireManufacturer::getDb()->cache(function ($db) {
    return ArrayHelper::map(TireManufacturer::find()
            ->select(['id','UPPER(title) as title'])
            ->orderBy(['title'=>'ASC'])
            ->where('title IS NOT NULL AND TRIM(IFNULL(title,"")) <> ""')
        
            ->asArray()
            ->all(),'id','title');
},$duration,$dependencyTM);

        $data['tiresRadius'] = Tire::getDb()->cache(function ($db) {
    return ArrayHelper::map(Tire::find()->select(['DISTINCT(diameter)'])
            ->orderBy(['diameter'=>'ASC'])
            ->where('diameter IS NOT NULL')
            ->andWhere('quantity > 0')
            ->asArray()
            ->all(),'diameter','diameter');
},$duration,$dependencyT);
        
        $data['tiresWidth'] = Tire::getDb()->cache(function ($db) {
    return ArrayHelper::map(Tire::find()->select(['DISTINCT(width)'])
            ->orderBy(['width'=>'ASC'])
            ->where('width IS NOT NULL')
            ->andWhere('quantity > 0')
            ->asArray()
            ->all(),'width','width');
},$duration,$dependencyT);

         $data['tiresProfile'] = Tire::getDb()->cache(function ($db) {
    return ArrayHelper::map(Tire::find()->select(['DISTINCT(profile)'])
            ->orderBy('CAST(profile AS DECIMAL) ASC')
            ->where('profile IS NOT NULL')
            ->andWhere('quantity > 0')
            ->andWhere('profile > 0')
            ->asArray()
            ->all(),'profile','profile');
},$duration,$dependencyT);
        if($this->view == 'leftSide'){
            $data['car_types'] = ArrayHelper::map(\common\models\tires\TireCarType::find()
            ->select(['id','plural'])
            ->orderBy(['plural'=>'ASC'])
            ->where('plural IS NOT NULL')
            ->asArray()
            ->all(),'id','plural');
            $data['ship'] = ['шип'=>'Да','нешип'=>'Нет']; 

                   
        }
       
        return $this->render($this->view,$data);
    }
    
    public function getMaxPrice(){
        return (int)(new \yii\db\Query())
    ->select('MAX(price)')
    ->from(Tire::tableName())
    ->where('quantity > 0 AND price > 0')
    ->scalar();
    }/**/
    
    public function getMinPrice(){
              return (int)(new \yii\db\Query())
    ->select('MIN(price)')
    ->from(Tire::tableName())
    ->where('quantity > 0 AND price > 0')
    ->scalar();
    }
    // получаем текущие значения для диапазона цен
    public function getCurrentMinPrice(){
       if (isset($this->params['minPrice']) && $this->params['minPrice'] > 0){
        return $this->params['minPrice'];} else{
    return $this->minPrice;
        }
    }/**/
    
     public function getCurrentMaxPrice(){
       if (isset($this->params['maxPrice']) && $this->params['maxPrice'] > 0){
        return $this->params['maxPrice'];} else{
    return $this->maxPrice;
        }
    }/**/
    
}/* end of Widget*/
