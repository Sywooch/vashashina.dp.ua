<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use frontend\widgets\price\Price;
?>
 <div class="col-sm-12">
            <div class="row">
<?php  \yii\widgets\Pjax::begin(['id'=>'disks']); ?>
<?= GridView::widget([
        'dataProvider' => $diskProvider,
        'layout'=>'{items}{pager}',
      //  'filterModel' => $searchModel,
        'columns' => [


       	      ['attribute'=> 'width',
              'value'=>function($disk){return (int)$disk->width;}  ],
            
             ['attribute'=> 'diameter',
              'value'=>function($disk){return $disk->diameter;}  ],
              ['attribute'=> 'pcd',
              'value'=>function($disk){return $disk->pcd;}  ],
              ['attribute'=> 'et',
              'value'=>function($disk){return $disk->et;}  ],
              // 'ship',
             //'usilennaya',
            // 'quantity',
             ['attribute' => 'price', 'value'=>function($disk){return Price::widget(['amount'=>$disk->getPrice()]);}],
            // 'category_id',
            // 'discount',
            // 'discount_begin',
            // 'discount_end',
            // 'status',
            // 'created',
            // 'updated',
            // 'created_by',
            // 'update_by',

            ['class' => 'yii\grid\DataColumn','label'=>'',
            		'value'=>function($disk){return Html::a(Yii::t('app','Buy'),
                    $disk->toCartUrl,['class'=>'toCart btn orange btn-xs','data-pjax'=>0]);},
                    'format'=>'html'],
                    
        ],
    ]); ?>
 <?php \yii\widgets\Pjax::end(); ?>
            </div>
 </div>