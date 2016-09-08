<?php

namespace frontend\controllers;
use common\models\Service;

class UslugiController extends \yii\web\Controller
{
    public $layout = 'column3';
    public function actionIndex()
    {
        return $this->render('index');
    }/**/

    public function actionView($alias)
    {
        $model = Service::find()->where('alias = :alias', [':alias'=>$alias])->one();
        return $this->render('view',[
            'model' => $model,
        ]);
    }/**/

}/**/
