<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductParam */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Product Param',
]) . ' ' . $model->product_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Params'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_id, 'url' => ['view', 'product_id' => $model->product_id, 'param_id' => $model->param_id, 'value' => $model->value]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-param-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
