<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TireMaxSpeed */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tire Max Speed',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tires', 'Tire Max Speeds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tire-max-speed-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
