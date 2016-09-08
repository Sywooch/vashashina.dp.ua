<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductParam */

$this->title = Yii::t('app', 'Create Product Param');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Params'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-param-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
