<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BootBoxAsset extends AssetBundle
{
    public  $jsOptions = ['position'=> View::POS_END];

    
    public $basePath = '@frontend';
    public $baseUrl = '@web';
    public $sourcePath = '@frontend';
    public $css = [
  
    ];
    public $js = [
         'libs/bootbox/bootbox.min.js'
        
    ];
    public $depends = [

        'yii\bootstrap\BootstrapAsset',
    ];
    
    public function init() {
       
        parent::init();
    }/**/
    
}/**/
