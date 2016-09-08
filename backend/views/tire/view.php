<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tire */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tires', 'Tires'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tire-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
      //  'mode'=>DetailView::MODE_EDIT,
        'panel'=>['heading'=>$model->title,
                  'type'=>'info',
                  'mainTemplate'=>'{detail}{buttons}'
            ],
        'attributes' => [
            'id',
            'full_title',
             ['attribute'=>'model_id','value'=>$model->tireModel->title,],
             ['attribute'=> 'width','value'=>$model->width,],
            ['attribute'=>'profile','value'=>(int)$model->profile,  ],
             ['attribute'=>'diameter','value'=>$model->diameter,],
             ['attribute'=>'max_load','value'=>$model->max_load,],
             ['attribute'=>'max_speed','value'=>$model->max_speed,],
            'ship',
            'usilennaya',
            'quantity',
            'price',
            'category_id',
            'discount',
            ['attribute'=>'discount_begin','value'=>($model->discount_begin)?date('d-m-Y H:i',$model->discount_begin):false],
            ['attribute'=>'discount_end','value'=>($model->discount_end)?date('d-m-Y H:i',$model->discount_end):false],
            'status',
            'created',
            'updated',
            'created_by',
            'update_by',
        ],
    ]) ?>

</div>
