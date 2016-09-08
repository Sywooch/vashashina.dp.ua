<?php 

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Button;

?>
	      <div class="col-sm-6">
        <h1 class="h-line orange">
        <span><span>Что нового?</span><span class="count"><?=$this->context->count;?></span></span></h1>
      
            <div class="search-box">
            <?php    foreach ($news as $new):?>
        <div class="some-news">
          <?php if ($new->created):?>
            <div class="date"><?=date('d.m.Y',$new->created);?></div>
            <?php endif;?>
            <div class="head"><?=Html::a($new->title,$new->url);?></div>
             <div class="rightArrow">
                <?=Html::a('',$new->url);?></div>
        </div>
            <?php    endforeach;?>
            </div>
        <div class="text-center">
        <?php echo Html::a('Просмотреть все новости', ['/news'], ['class'=>'btn btn-md orange']);?>
        </div>
        
      </div>

