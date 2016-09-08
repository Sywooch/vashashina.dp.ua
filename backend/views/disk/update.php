<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\disks\Disk */

$this->title = Yii::t('disk', 'Update {modelClass}: ', [
    'modelClass' => 'Disk',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('disk', 'Disks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('disk', 'Update');
?>
<div class="disk-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
