<?php 
namespace frontend\widgets\findByCar;

use yii\web\AssetBundle;

class FindByCarAsset extends AssetBundle
{
	public $sourcePath = '@frontend/widgets/findByCar/assets';

	public $depends = [
             'yii\bootstrap\BootstrapAsset',
		
	];

	public $js = [
        //    'js/jquery.easydropdown.min.js',
			'js/findByCar.js'
	];
        
        public $css = [
			
	];
	
	public $jsOptions = [];
	
	public $publishOptions =['forceCopy'=>true];
}

?>