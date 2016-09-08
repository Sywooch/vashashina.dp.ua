<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\disks\DiskManufacturer */

$this->title = Yii::t('disk', 'Create Disk Manufacturer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('disk', 'Disk Manufacturers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disk-manufacturer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
