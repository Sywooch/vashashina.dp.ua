<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\disks\DiskModel */

$this->title = Yii::t('disk', 'Create Disk Model');
$this->params['breadcrumbs'][] = ['label' => Yii::t('disk', 'Disk Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disk-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
