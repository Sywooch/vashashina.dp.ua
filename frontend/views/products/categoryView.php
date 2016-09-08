<?php
use yii\widgets\ListView;
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = ($category->page_title)?$category->page_title:$category->title;
 $this->registerMetaTag(['name'=> 'keywords','content' =>$category->meta_k]);
  $this->registerMetaTag(['name'=> 'description','content'=>$category->meta_d]);
?>

    <?php echo ListView::widget([
         'dataProvider' => $dataProvider,
    'itemView' => '/products/_productView',
    'layout'=>'{items}{pager}',
    ]);
    ?>