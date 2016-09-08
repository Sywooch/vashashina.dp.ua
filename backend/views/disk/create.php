<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\disks\Disk */

$this->title = Yii::t('disk', 'Create Disk');
$this->params['breadcrumbs'][] = ['label' => Yii::t('disk', 'Disks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disk-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
