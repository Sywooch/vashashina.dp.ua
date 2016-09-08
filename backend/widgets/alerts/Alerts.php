<?php namespace backend\widgets\alerts;

use yii\base\Widget;
use yii\helpers\Html;


class Alerts extends Widget
{


    public function init()
    {
        parent::init();
       
    }/**/

    public function run()
    {
     $data = [];
         //    var_dump($data);die;
        return $this->render('index',$data);
    }
}/* end of Widget*/
