<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\events;

use Yii;
use yii\base\Event;
use common\models\LoginsLog;
/**
 * Description of UserEvents
 *
 * @author akulyk
 */
class UserEvents extends Event {
  
    public static function afterLogin(){
        $model = new LoginsLog();
        $model->save();
      
        
    }/**/
}/* end of Class */
