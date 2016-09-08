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
class BootstrapSliderAsset extends AssetBundle
{
    public  $jsOptions = ['position'=> View::POS_HEAD];

    
    public $basePath = '@webroot/libs/bootstrap-slider';
    public $baseUrl = '@web/libs/bootstrap-slider/slider';
    public $css = [
        'css/bootstrap-slider.min.css',
      
    ];
    public $js = [
          'js/bootstrap-slider.min.js',
          
        
    ];
    public $depends = [
      'yii\bootstrap\BootstrapAsset',
    ];
}
