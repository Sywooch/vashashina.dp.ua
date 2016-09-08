<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductParam */

$this->title = $model->product->title.': '.$model->catParam->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Params'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-param-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'product_id' => $model->product_id, 'param_id' => $model->param_id, 'value' => $model->value], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'product_id' => $model->product_id, 'param_id' => $model->param_id, 'value' => $model->value], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute'=>'product_id','value'=>$model->product->title],
            ['attribute'=>'param_id','value'=>$model->catParam->title],
            ['attribute'=>'value'],
        ],
    ]) ?>

</div>
