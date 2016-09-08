<?php 
namespace frontend\widgets\findDisk;

use yii\web\AssetBundle;

class FindDiskAsset extends AssetBundle
{
	public $sourcePath = '@frontend/widgets/findDisk/assets';

	public $depends = [
            'frontend\assets\AppAsset',
            'frontend\assets\BootstrapSliderAsset',
		
	];

	public $js = [
		//	'js/bootstrap-slider.min.js',
                        'js/findDisk.js'
	];
        
        public $css = [
		//	'css/bootstrap-slider.min.css'
	];
	
	public $jsOptions = ['position' => \yii\web\View::POS_END];
	
	public $publishOptions =['forceCopy'=>false];
}

?>