<?php
use yii\widgets\ListView;
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Купить зимние и летние шины в Днепропетровске:
R13, R14, R15, R16, R17. Склад-магазин ВАША ШИНА. Продажа шин! ';
$this->registerMetaTag(['name'=> 'keywords','content' =>'шины, автошины, зимние шины, купить шины, грузовые шины, летние шины, литые диски, автомобильные диски , шины диски, магазин шины, шины 13, шины 14, шины 15, шины 16']);
$this->registerMetaTag(['name'=> 'description','content'=>'Интернет-магазин  Vashashina реализует летние и зимние шины: 13, 14 ,15, 16 и до 22. Грузовые шины R17,5 и R22,5 . У нас Вы всегда можете купить автомобильные шины и резину по самым низким ценам в Украине']);

?>

    <?php echo ListView::widget([
         'dataProvider' => $dataProvider,
    'itemView' => '/shiny/_tireView',
    'layout'=>'{items}{pager}',
    ]);
