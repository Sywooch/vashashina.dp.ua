<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use frontend\widgets\price\Price;
?>
 <div class="col-sm-12">
            <div class="row">
<?php  \yii\widgets\Pjax::begin(['id'=>'tires']); ?>
<?= GridView::widget([
        'dataProvider' => $tireProvider,
        'layout'=>'{items}{pager}',
      //  'filterModel' => $searchModel,
        'columns' => [


       	      ['attribute'=> 'width',
              'value'=>function($tire){return (int)$tire->width;}  ],
            ['attribute'=> 'profile',
              'value'=>function($tire){return (int)$tire->profile;}  ],
             ['attribute'=> 'diameter',
              'value'=>function($tire){return $tire->diameter;}  ],
              ['attribute'=> 'max_load',
              'value'=>function($tire){return $tire->max_load;}  ],
              ['attribute'=> 'max_speed',
              'value'=>function($tire){return $tire->max_speed;}  ],
              // 'ship',
             //'usilennaya',
            // 'quantity',
             ['attribute' => 'price', 'value'=>function($tire){return Price::widget(['amount'=>$tire->getPrice()]);}],
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
            		'value'=>function($tire){return Html::a(Yii::t('app','Buy'),
                    $tire->toCartUrl,['class'=>'toCart btn orange btn-xs','data-pjax'=>0]);},
                    'format'=>'html'],
                    
        ],
    ]); ?>
 <?php \yii\widgets\Pjax::end(); ?>
            </div>
 </div>