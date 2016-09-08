<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log','gii'],
	'name'=>'Панель управления сайтом',

    'modules' => [
          'gii' => 'yii\gii\Module',
          'i18n' => Zelenin\yii\modules\I18n\Module::className(),
          'gridview' => [
                    'class' => '\kartik\grid\Module'
                    // enter optional module parameters below - only if you need to
                    // use your own export download action or custom translation
                    // message source
                    // 'downloadAction' => 'gridview/export/download',
                    // 'i18n' => []
                    ],
    		'dynagrid'=>[
    				'class'=>'\kartik\dynagrid\Module',
    				'maxPageSize'=>10000,
    				'dbSettings'=>[
    					'tableName'=>'vs_dynagrid',
    					'filterAttr'=>'filter_id',
    					'sortAttr'	=>'sort_id',	
    				],
    				'dbSettingsDtl'=>[
    						'tableName'=>'vs_dynagrid_dtl'
    				],
                   //     'exportAction' => 'export',
    				// other settings (refer documentation)
    				],
    ],
  
    'components' => [
            'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'suffix' => '.html',
              //  'baseUrl'=>'/admin',
            'rules' => [
                '' => 'site/index',
                  'admin/<controller>'=>'admin/<controller>',
                'admin/<controller>/<action>'=>'admin/<controller>/<action>',
                 'admin/<controller>/<action>/*'=>'admin/<controller>/<action>',
                '<controller:шины>'=>'tire',
                '<controller>'=>'<controller>',
            ],
        ], 
         'assetManager' => [
             'basePath' => '@webroot/assets',
             'baseUrl' => '@web/assets'
        ],  
        'request' => [
         //   'baseUrl' => '/admin'
             'csrfParam' => '_backendCSRF',
            'enableCookieValidation' => true,
            'enableCsrfCookie'=>true,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
