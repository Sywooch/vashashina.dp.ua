<?php namespace frontend\widgets\findDisk;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\disks\DiskManufacturer;
use common\models\disks\Disk;

class FindDisk extends Widget
{
    public $view ='index';
    public $params = ['disk_type' => '',
  'diameter' => '',
  'width' => '',
  'pcd' => '',
  'et' => '',
  'color' => '',
  'kol_otverstiy' => '',
  'manufacturer_id' => '',
  'minPrice' => '',
  'maxPrice' => ''];

    public function init()
    {
                if (Yii::$app->request->isGet && isset(Yii::$app->request->queryParams['Disk'])){
            $this->params = array_merge($this->params,Yii::$app->request->queryParams['Disk']);
        
        }
        parent::init();
        
    }/**/

    public function run()
    {
         $data = [];
        $duration = 60*60*24;
        $dependencyD = new \yii\caching\DbDependency(['sql'=>'SELECT MAX(updated) FROM '.Disk::tableName()]);
        $dependencyDM = new \yii\caching\DbDependency(['sql'=>'SELECT MAX(updated) FROM '.DiskManufacturer::tableName()]);
        
        $data['dm'] = DiskManufacturer::getDb()->cache(function ($db) {
    return ArrayHelper::map(DiskManufacturer::find()
            ->select(['id','UPPER(title) as title'])
            ->orderBy(['title'=>'ASC'])
            ->where('title IS NOT NULL AND TRIM(IFNULL(title,"")) <> ""')
        
            ->asArray()
            ->all(),'id','title');
},$duration,$dependencyDM);

        $data['disksRadius'] = Disk::getDb()->cache(function ($db) {
    return ArrayHelper::map(Disk::find()->select(['DISTINCT(diameter)'])
            ->orderBy(['diameter'=>'ASC'])
            ->where('diameter IS NOT NULL')
            ->andWhere('quantity > 0')
            ->asArray()
            ->all(),'diameter','diameter');
},$duration,$dependencyD);
        
        $data['disksWidth'] = Disk::getDb()->cache(function ($db) {
    return ArrayHelper::map(Disk::find()->select(['DISTINCT(width)'])
            ->orderBy(['width'=>'ASC'])
            ->where('width IS NOT NULL')
            ->andWhere('quantity > 0')
            ->asArray()
            ->all(),'width','width');
},$duration,$dependencyD);

 $data['disksET'] = Disk::getDb()->cache(function ($db) {
    return ArrayHelper::map(Disk::find()->select(['DISTINCT(et)'])
            ->orderBy(['et'=>'ASC'])
            ->where('et IS NOT NULL')
            ->andWhere('quantity > 0')
            ->asArray()
            ->all(),'et','et');
},$duration,$dependencyD);

 $data['disksPCD'] = Disk::getDb()->cache(function ($db) {
    return ArrayHelper::map(Disk::find()->select(['DISTINCT(pcd)'])
            ->orderBy(['pcd'=>'ASC'])
            ->where('pcd IS NOT NULL')
            ->andWhere('quantity > 0')
            ->asArray()
            ->all(),'pcd','pcd');
},$duration,$dependencyD);
if($this->view == 'leftSide'){
    $data['tipes'] = ['Литые'=>'Литые','Кованные'=>'Кованные','Стальные'=>'Стальные'];
}
        
        
        return $this->render($this->view,$data);
    }/**/
    
        public function getMaxPrice(){
        return (int)(new \yii\db\Query())
    ->select('MAX(price)')
    ->from(Disk::tableName())
    ->where('quantity > 0 AND price > 0')
    ->scalar();
    }/**/
    
    public function getMinPrice(){
              return (int)(new \yii\db\Query())
    ->select('MIN(price)')
    ->from(Disk::tableName())
    ->where('quantity > 0 AND price > 0')
    ->scalar();
    }/**/
    
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
