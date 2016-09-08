<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace backend\components;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * Description of AdminController
 *
 * @author AKulyk
 */
class AdminController extends Controller{
    //put your code here
        public function behaviors()
    {
    	//var_dump(Yii::$app->user->can('admin'));die;
        return [
            'access' => [
                'class' => AccessControl::className(),
            //	'only' => ['login', 'logout', 'error'],
                'rules' => [
                    [
                        'actions' => ['login', 'error','logout',
                            'request-password-reset',
                                      'reset-password'],
                        'allow' => true,
                    ],
                    [
                       'roles' => ['менеджер','admin'],
                       'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete' => ['post'],
                ],
            ],
        ];
    }
}
