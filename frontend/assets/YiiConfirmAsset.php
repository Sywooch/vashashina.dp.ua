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
class YiiConfirmAsset extends AssetBundle
{
    public  $jsOptions = ['position'=> View::POS_END];

    
    public $basePath = '@frontend';
    public $baseUrl = '@web';
     public $sourcePath = '@frontend';
  //  public $sourcePath = '@webroot/themes/classic';
    public $css = [
  
    ];
    public $js = [
         'libs/yii-confirm/yii-confirm-bootbox.js'
        
    ];
    public $depends = [
         'yii\web\YiiAsset',
        'frontend\assets\BootBoxAsset',
    ];
    
    public function init() {
       
        parent::init();
    }/**/
    
}/**/
