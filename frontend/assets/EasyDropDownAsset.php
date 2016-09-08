<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class EasyDropDownAsset extends AssetBundle
{
    public  $jsOptions = ['position'=> View::POS_HEAD];

    
    public $basePath = '@webroot/libs/jquery/easydropdown';
    public $baseUrl = '@web/libs/jquery/easydropdown';
    public $css = [
        'css/easydropdown.css',
      
    ];
    public $js = [
          'js/jquery.easydropdown.min.js',
          
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
