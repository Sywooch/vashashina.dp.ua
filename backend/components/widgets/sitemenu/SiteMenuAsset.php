<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components\widgets\sitemenu;

use yii\web\AssetBundle;
/**
 * Description of SiteMenuAsset
 *
 * @author SParadox
 */
class SiteMenuAsset extends AssetBundle {
    //public $sourcePath = '@app/components/widgets/sitemenu/assets';
    public $sourcePath = __DIR__. '/assets'; 

    public $css = [
        'cssmenu.css',
    ];
    public $js = [
        
    ];
    
    /** @var array */
    public $depends = [
//        'yii\jui\JuiAsset'
        ];
}
