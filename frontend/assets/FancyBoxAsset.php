<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FancyBoxAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'libs/fancybox2/jquery.fancybox.css',
    ];
    public $js = [
       //  'libs/js/jquery/plugins/jquery.select-customizer.js',
          'libs/fancybox2/jquery.fancybox.pack.js',
          'libs/fancybox2/jquery.mousewheel-3.0.6.pack.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
       
    ];
}
