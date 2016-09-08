<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\disks\DiskManufacturer */

$this->title = Yii::t('disk', 'Update {modelClass}: ', [
    'modelClass' => 'Disk Manufacturer',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('disk', 'Disk Manufacturers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('disk', 'Update');
?>
<div class="disk-manufacturer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
