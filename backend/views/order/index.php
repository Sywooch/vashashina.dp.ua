<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php echo \backend\widgets\alerts\Alerts::widget();?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute'=>'customer_id',
             'value'=>function($model){return $model->user->name.' <br/> '.$model->user->email.' <br/> '.$model->user->phone;},
             'format'=>'html' ],
             ['attribute'=>'suma','value'=>function($model){
                 return Yii::$app->formatter->asCurrency($model->suma);
            }],
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
               ['attribute'=> 'payment_status',
               		'value'=>function($model){return Yii::t('app',$model->payment_status);},
               		'filter'=>['cancelled'=>Yii::t('app','cancelled'),'pending'=>Yii::t('app','pending')
               				,'paid'=>Yii::t('app','paid')]],
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
            	return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', 
            			$myUrl,
            			['title' => Yii::t('app', 'Cancel'), 'data-pjax' => '0',
            			'data-confirm'=>Yii::t('app', 'Are you sure you want to cancel this order?'),
            			'data-method'=>'post'
            	]);
            	
            },
            ],'template'=>'{view}{update}{cancel}'  
                     
        ],
    ]]); ?>

</div>
