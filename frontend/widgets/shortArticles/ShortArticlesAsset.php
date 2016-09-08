<?php 
namespace frontend\widgets\searchtire;

use yii\web\AssetBundle;

class SearchTireAsset extends AssetBundle
{
	public $sourcePath = '@frontend/widgets/searchtire/assets';

	public $depends = [
		
	];

	public $js = [
			'js/searchtire.js'
	];
	
	public $jsOptions = ['position' => \yii\web\View::POS_END];
	
	public $publishOptions =['forceCopy'=>true];
}

?>