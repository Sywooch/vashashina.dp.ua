<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tire */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('tires','Tire'),
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tires', 'Tires'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tire-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
