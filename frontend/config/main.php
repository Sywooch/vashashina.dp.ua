<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
         'request' => [
            'baseUrl' => ($_SERVER['HTTP_HOST']=='localhost') ?'/vashashina.dp.ua':'',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'suffix' => '.html',
              //  'baseUrl'=>'/admin',
            'rules' => require 'routes.php',
        ],
      /*  'view' => [
              'theme' => [
                 'pathMap' => [ 
                    '@app/views' => '@app/themes/'.$params['theme'].'/views',
                    '@app/modules' => '@app/themes/'.$params['theme'].'/views/modules',
                    '@app/widgets' => '@app/themes/'.$params['theme'].'/views/widgets'

                 ],
               ],
            ],//end of view 
       * 
       */
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
