<?php 
namespace frontend\widgets\yashare;

use yii\web\AssetBundle;

class YaShareAsset extends AssetBundle
{
	public $sourcePath = '@frontend/widgets/yashare/assets';

	public $depends = [
           
		
	];

	public $js = [	
                        
            'https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js',
            'https://yastatic.net/share2/share.js',
	];
        
        public $css = [
		'css/yashare.less'	
            
	];
	
	public $jsOptions = ['position' => \yii\web\View::POS_END,
            'async' => 'async',];
	
	public $publishOptions =['forceCopy'=>false];
}

?>