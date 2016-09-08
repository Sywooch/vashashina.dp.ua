<?php 
namespace frontend\widgets\topCart;

use yii\web\AssetBundle;

class TopCartAsset extends AssetBundle
{
	public $sourcePath = '@frontend/widgets/topCart/assets';

	public $depends = [
             'frontend\assets\AppAsset',
		
	];

	public $js = [
			
                        'js/topCart.js'
	];
        
        public $css = [
			'css/bootstrap-slider.min.css',
            
	];
	
	public $jsOptions = ['position' => \yii\web\View::POS_END];
	
	public $publishOptions =['forceCopy'=>true];
}

?>