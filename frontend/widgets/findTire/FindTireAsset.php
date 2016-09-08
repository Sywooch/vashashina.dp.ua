<?php 
namespace frontend\widgets\findTire;

use yii\web\AssetBundle;

class FindTireAsset extends AssetBundle
{
	public $sourcePath = '@frontend/widgets/findTire/assets';

	public $depends = [
             'frontend\assets\AppAsset',
            'frontend\assets\BootstrapSliderAsset',
		
	];

	public $js = [
		//	'js/bootstrap-slider.min.js',
                        'js/findTire.js'
	];
        
        public $css = [
		//	'css/bootstrap-slider.min.css',
            
	];
	
	public $jsOptions = ['position' => \yii\web\View::POS_END];
	
	public $publishOptions =['forceCopy'=>false];
}

?>