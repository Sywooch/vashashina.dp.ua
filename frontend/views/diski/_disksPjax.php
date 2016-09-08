<?php 
use yii\widgets\ListView;
?>
        <div class="col-md-9 goods">
            <div class="row">
                  <div class="col-sm-4 col-xs-12 text-left-xs">
              <h1 class="catalog">Диски<span class="count new"><?=$count;?></span></h1>
                </div>
              <?php echo \frontend\widgets\selectOrder\SelectOrder::widget(['tip'=>'Disk']);?>
                
            </div>
            <div class="row">
              <div class="col-xs-12 listView">
<?php echo ListView::widget([
         'dataProvider' => $dataProvider,
    'itemView' => '/diski/_diskView',
    'layout'=>'{items}{pager}',
    'pager'=>['class'=>'kulyk\linkpager\LinkPager',
        'maxButtonCount'=>5]
    ]);?>
              </div>
            </div>
          </div>