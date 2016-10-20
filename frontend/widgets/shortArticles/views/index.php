<?php 

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>
<?php if(count($articles)>0):?>
  <div class="col-sm-6">
        <h1 class="h-line orange"><span><span>Это интересно</span><span class="count"><?=$this->context->count;?></span></span></h1>
         
        <div class="search-box">
            <?php    foreach ($articles as $article):?>
                 <div class="some-interest">
                     <?php if($article->imageUrl):?>
            <div class="img">  
                <?=Html::img($article->imageUrl,['title'=>$article->title,'alt'=>$article->title]);?>    
            </div>
                     <?php endif;?>
            <div class="head">
            <?=Html::a($article->title,$article->url);?>
            </div>
          </div>
            <?php    endforeach;?>
            </div>
         <div class="text-center">
        <?php echo Html::a('Просмотреть все статьи', ['/articles'], ['class'=>'btn btn-md orange']);?>
        </div>
      </div>
<?php endif;?>


