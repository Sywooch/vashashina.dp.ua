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
class ViewAsset extends AssetBundle
{
    public  $jsOptions = ['position'=> View::POS_HEAD];

    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'js/fancybox2/jquery.fancybox.css',
        'js/jquery/fancybox/jquery.fancybox-1.3.4.css',
        'js/slider/bootstrap-slider.css',
        'css/site.css',
    ];
    public $js = [
        'js/slider/bootstrap-slider.min.js',
        'js/fancybox2/jquery.fancybox.pack.js',
        'js/fancybox2/jquery.mousewheel-3.0.6.pack.js',
  //      'js/jquery/fancybox/jquery.fancybox-1.3.4.pack.js',
  //      'js/jquery/fancybox/jquery.easing-1.3.pack.js',
  //      'js/jquery/fancybox/jquery.mousewheel-3.0.6.pack.js',
        
    ];
    public $depends = [
        'frontend\assets\AppAsset',
       
    ];
}
