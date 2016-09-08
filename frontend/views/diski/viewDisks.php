<?php
/* @var $this yii\web\View */
use frontend\assets\ViewAsset;
use yii\widgets\ListView;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
ViewAsset::register($this);
//var_dump(Yii::$app->session->id);die;
$this->registerJs("
         
 
	$('.fancybox').fancybox({
		prevEffect	: 'none',
		nextEffect	: 'none',
        //        maxWidth	: 800,
	//	maxHeight	: 600,
		fitToView	: false,
	//	width		: '70%',
	//	height		: '70%',
		autoSize	: true,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none' , 
		helpers	: {
			title	: {
				type: 'outside'
			},
			thumbs	: {
				width	: 50,
				height	: 50
			}
		}
	});
$('#pjaxDisks').on('pjax:end', function (event, xhr, textStatus, errorThrown, options) {
updateSelect('#sortSelect');
updateSelect('select.perPageSelect');

});
function updateSelect(select){
var item = $(select);
item.easyDropDown();
}/**/
        ");
$this->title = 'Подбор дисков по параметрам - VashaShina.dp.ua';
$this->registerMetaTag(['name'=> 'keywords','content' =>'шины, автошины, зимние шины, купить шины, грузовые шины, летние шины, литые диски, автомобильные диски , шины диски, магазин шины, шины 13, шины 14, шины 15, шины 16']);
$this->registerMetaTag(['name'=> 'description','content'=>'Интернет-магазин  Vashashina реализует летние и зимние шины: 13, 14 ,15, 16 и до 22. Грузовые шины R17,5 и R22,5 . У нас Вы всегда можете купить автомобильные шины и резину по самым низким ценам в Украине']);
?>
<div class="main">
      <div class="container">
       
    <?php echo Breadcrumbs::widget([
    'itemTemplate' => "<li class=\"path\">{link}</li>\n", // template for all links
    'homeLink'=>['label'=>  Yii::t('app', 'Home'),
        'template'=>"<li class=\"this-page\">Вы находитесь здесь: {link}</li>\n",
        'url'=>  yii\helpers\Url::home()],
    'links' => [
        [
            'label' => 'Подбор дисков',
          //  'url' => ['post-category/view', 'id' => 10],
            'template' => "<li><span class=\"path\">{link}</span></li>\n", // template for this link only
        ],
        //['label' => 'Sample Post',
         //'template' => "<li><span class=\"this-page\">{link}</span></li>\n"],
    ],
]);?>
                  
        <div class="row">
     <?php echo \frontend\widgets\findDisk\FindDisk::widget(['view'=>'leftSide']);?>
                        <?php \yii\widgets\Pjax::begin(['id'=>'pjaxDisks','options'=>['class'=>'itemsPjax'],
                'timeout'=>10000,'formSelector'=>'#disk-find-form']); ?>
            <?php echo $this->render('_disksPjax',['dataProvider'=>$dataProvider,'count'=>$count]);?>
            <?php \yii\widgets\Pjax::end(); ?>
  
        </div>
      </div>
</div>
