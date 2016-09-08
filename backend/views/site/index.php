<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;


$this->title = Yii::t('app','Site Control Panel');
?>
<div class="site-index">

 <?php echo \backend\widgets\orders\Orders::widget();?>

     <?= GridView::widget([
        'dataProvider' => $ordersProvider,
      //  'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute'=>'customer_id',
             'value'=>function($model){return $model->user->name.' <br/> '.$model->user->email.' <br/> '.$model->user->phone;},
             'format'=>'html' ],
            ['attribute'=>'suma','value'=>function($model){
                 return Yii::$app->formatter->asCurrency($model->suma);
            }],
               ['attribute'=> 'payment_status',
               		'value'=>function($model){return Yii::t('app',$model->payment_status);},
               		'filter'=>['cancelled'=>Yii::t('app','cancelled'),'pending'=>Yii::t('app','pending')
               				,'paid'=>Yii::t('app','paid')]],
            ['label'=> Yii::t('app', 'Product'),
              'value' =>  function($model){
                            $string ='';
                            foreach($model->productsPerOrder as $id => $productPerOrder){
                                
                    $string .= $productPerOrder->product->category->title.' '
                              .$productPerOrder->product->title.'<br/>'
                              .' Кол-во: '.$productPerOrder->quantity.'; Цена: '
                              .Yii::$app->formatter->asCurrency($productPerOrder->price)
                              .'; Сумма: '.Yii::$app->formatter->asCurrency($productPerOrder->subtotal).'<br/>';  
                            }
                   return $string;
            },'format'=>'raw'],
               ['attribute'=> 'created','value'=>function($model){
                return date("d.m.Y H:i:s", $model->created);
            }],
              ['attribute'=> 'delivery_status','value'=>function($model){return Yii::t('app',$model->delivery_status);}],
            // 'sposob_oplati',
            // 'sposob_dostavki',
            // 'created',
            // 'updated',
            // 'manager_id',
            // 'memo',
            // 'email:email',

            ['class' => 'yii\grid\ActionColumn',
            		'buttons'=>[
            			'cancel'=>function($url, $model, $key){
            	$myUrl = Yii::$app->urlManager->createUrl(['/order/cancel','id'=>$model->id]);
            	return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-remove-sign red"></span>', 
            			$myUrl,
            			['title' => Yii::t('app', 'Cancel'), 'data-pjax' => '0',
            			'data-confirm'=>Yii::t('app', 'Are you sure you want to cancel this order?'),
            			'data-method'=>'post','class'=>'btn btn-default btn-xs']);},
                                 'complete'=>function($url,$model,$key){
                $myUrl = Yii::$app->urlManager->createUrl(['/order/complete','id'=>$model->id]); 
                return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-ok-sign green"></span>', 
            			$myUrl,
            			['title' => Yii::t('app', 'Complete'), 'data-pjax' => '0',
            			'data-confirm'=>Yii::t('app', 'Are you sure you want to complete this order?'),
            			'data-method'=>'post','class'=>'btn btn-default btn-xs']);
                                 },
                              'view'=>function($url,$model,$key){
                $myUrl = Yii::$app->urlManager->createUrl(['/order/view','id'=>$model->id]); 
                return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', 
            			$myUrl,
            			['title' => Yii::t('app', 'view'), 'data-pjax' => '0']
            			);
                                 }
            ],'template'=>'{view}{complete}{cancel}'  
                     
        ],
    ]]); ?>
</div>
