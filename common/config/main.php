<?php
Yii::setAlias('@root',  realpath(dirname(__FILE__).'/../../'));
$vendorPath = dirname(__DIR__) . '/../vendor';
return [
    'vendorPath' => $vendorPath,
    // РјРѕРґСѓР»Рё
        'language' => 'ru-RU',
		'name'=>'Интернет-магазин VashaShina.Dp.Ua',
    
    'modules' => [
             'gii' => 'yii\gii\Module',
			'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['5.248.1.29','127.0.0.1', '::1']
        ]
   
    ],
    // РєРѕРјРїРѕРЅРµРЅС‚С‹
    'components' => [
     //     'db' => require'db_local.php',
         'db' => (YII_ENV=='dev') ?require 'db_local.php':require 'db_server.php',
         'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
         //    'baseUrl'=>'/vashashina.dp.ua',
        ],
        'user'=>[
       //     'on afterLogin' => ['common\events\UserEvents', 'afterLogin'],
        ],
        'assetManager' => [
             'appendTimestamp' => true,
             'converter' => [
                'class' => 'cakebake\lessphp\AssetConverter',
                'compress' => true, // Optional: You can tell less.php to remove comments and whitespace to generate minimized css files.
                'useCache' => false, // Optional: less.php will save serialized parser data for each .less file. Faster, but more memory-intense.
                //'cacheDir' => null, // Optional: is passed to the SetCacheDir() method. By default "cakebake\lessphp\runtime" is used.
                'cacheSuffix' => false, // Optional: Filename suffix to avoid the browser cache and force recompiling by configuration changes
            ],
            'bundles' => [
                 'yii\web\JqueryAsset' => [
                     'js' => [
                     YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                          ]
                        ],
            ],
        ],
        // RBAC on DB
          'authManager' => [
                           'class' => 'yii\rbac\DbManager',
                           'defaultRoles' => ['клиент'],
          ],
     /*    'i18n' => [
        'translations' => [
            'app*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@root/messages',
                'sourceLanguage' => 'en-US',
                'fileMap' => [
                    'app' => 'app.php',
                    'app/error' => 'error.php',
                ],
            ],
            'tires*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@root/messages',
                'sourceLanguage' => 'en-US',
                'fileMap' => [
                    'tires' => 'tires.php',
                    'tires/error' => 'error.php',
                ],
            ],
            'disks*' => [
            	'class' => 'yii\i18n\PhpMessageSource',
            	'basePath' => '@root/messages',
            	'sourceLanguage' => 'en-US',
            	'fileMap' => [
            		'disks' => 'disks.php',
            		'disks/error' => 'error.php',
            				],
            
            ],
        ] ,
    ],*/
  
        'i18n' => [
    'class' => Zelenin\yii\modules\I18n\components\I18N::className(),
    'languages' => ['ru-RU', 'ua-UA'],
        		'translations' => [
        				'*' => [
        				'class' => yii\i18n\DbMessageSource::className()
        				]
        		]
        ],
    		'formatter' => [ 
    				'class' => 'yii\i18n\Formatter', 
    				'dateFormat' => 'd-M-Y', 
    				'datetimeFormat' => 'd-M-Y H:i:s', 
    				'timeFormat' => 'H:i:s',
    				'currencyCode' =>'UAH',
    				'thousandSeparator' =>' ' ],
 
        //Кеширование
        'cache' => [
           
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 1,
            ]
        
        ],
		'session' => [
    'class' => 'yii\web\Session',
    'timeout'=>60*60*24,
     'useCookies'=>TRUE,
    // 'cache' => 'mycache',
],
    ],
];
