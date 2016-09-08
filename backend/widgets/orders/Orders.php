<?php namespace backend\widgets\orders;

use yii\base\Widget;
use yii\helpers\Html;
use common\models\Order;

class Orders extends Widget
{
    public $count;
    public $limit = 2;

    public function init()
    {
        parent::init();
       
    }/**/

    public function run()
    {
        $data = [];
           $data['orders'] = Order::findAll(array('payment_status = "pending" OR delivery_status = "pending"'));
          $thisMonth = date('m-Y');
          $lastMonth = date('m-Y', strtotime('first day of previous month'));
          $select = ['COUNT(id) as count', 'SUM(suma) as sum','payment_status'];
          $order = 'created DESC';
//Заказы в этом месяце
             $data['ordersThisMonth']['total'] =Order::find()
                      ->select($select)
                     ->orderBy($order)
                     ->where('DATE_FORMAT(FROM_UNIXTIME(created),"%m-%Y") =:thisMonth')
                     ->params([':thisMonth'=>$thisMonth])
                     ->asArray()
                     ->one();
                  
             $data['ordersThisMonth']['completed'] =Order::find()
                     ->select($select)
                     ->orderBy($order)
                     ->where('DATE_FORMAT(FROM_UNIXTIME(created),"%m-%Y") =:thisMonth AND payment_status = "completed"')
                     ->params([':thisMonth'=>$thisMonth])
                     ->asArray()
                     ->one();
             
             $data['ordersThisMonth']['pending'] =Order::find()
                     ->select($select)
                     ->orderBy($order)
                     ->where('DATE_FORMAT(FROM_UNIXTIME(created),"%m-%Y") =:thisMonth AND payment_status = "pending"')
                     ->params([':thisMonth'=>$thisMonth])
                     ->asArray()
                     ->one();
             $data['ordersThisMonth']['cancelled'] =Order::find()
                     ->select($select)
                     ->orderBy($order)
                     ->where('DATE_FORMAT(FROM_UNIXTIME(created),"%m-%Y") =:thisMonth AND payment_status = "cancelled"')
                     ->params([':thisMonth'=>$thisMonth])
                     ->asArray()
                     ->one();               
// Заказы в прошлом месяце   
                      $data['ordersLastMonth']['total'] =Order::find()
                      ->select($select)
                     ->orderBy($order)
                     ->where('DATE_FORMAT(FROM_UNIXTIME(created),"%m-%Y") =:lastMonth')
                     ->params([':lastMonth'=>$lastMonth])
                     ->asArray()
                     ->one();
                  
             $data['ordersLastMonth']['completed'] =Order::find()
                     ->select($select)
                     ->orderBy($order)
                     ->where('DATE_FORMAT(FROM_UNIXTIME(created),"%m-%Y") =:lastMonth AND payment_status = "completed"')
                     ->params([':lastMonth'=>$lastMonth])
                     ->asArray()
                     ->one();
             
             $data['ordersLastMonth']['pending'] =Order::find()
                     ->select($select)
                     ->orderBy($order)
                     ->where('DATE_FORMAT(FROM_UNIXTIME(created),"%m-%Y") =:lastMonth AND payment_status = "pending"')
                     ->params([':lastMonth'=>$lastMonth])
                     ->asArray()
                     ->one();
             $data['ordersLastMonth']['cancelled'] =Order::find()
                     ->select($select)
                     ->orderBy($order)
                     ->where('DATE_FORMAT(FROM_UNIXTIME(created),"%m-%Y") =:lastMonth AND payment_status = "cancelled"')
                     ->params([':lastMonth'=>$lastMonth])
                     ->asArray()
                     ->one(); 
         //    var_dump($data);die;
        return $this->render('index',$data);
    }
}/* end of Widget*/
