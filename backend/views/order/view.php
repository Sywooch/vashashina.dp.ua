<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use backend\widgets\alerts\Alerts;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = Yii::t('app', 'Order').' #'. $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>
<?=Alerts::widget();?>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['cancel', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to cancel this order?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute'=>'id',
                'contentOptions'=>['id'=>'order_id']
            ],
             ['attribute'=>'customer_id',
             'value'=>$model->user->name.' <br/> '.$model->user->email.' <br/> '.$model->user->phone,
             'format'=>'html' ],
            ['attribute'=>'suma',
                'contentOptions'=>['id'=>'orderTotalSum']
            ],
              ['attribute'=> 'payment_status','value'=>Yii::t('app',$model->payment_status)],
              ['attribute'=> 'delivery_status','value'=>Yii::t('app',$model->delivery_status)],
            
            ['attribute'=> 'sposob_oplati','value'=> $model->sposobOplati->title],
             ['attribute'=> 'sposob_dostavki','value'=> $model->sposobDostavki->title],
           
            ['attribute'=>'created','value'=>date('d.m.Y H:i:s',$model->created)],
             ['attribute'=>'updated','value'=>date('d.m.Y H:i:s',$model->updated)],
            'manager_id',
            'memo',
       //     'email:email',
        ],
    ]) ?>
    
 <?php echo $this->render('_productsView',['productsProvider'=>$productsProvider]);?>

</div>
