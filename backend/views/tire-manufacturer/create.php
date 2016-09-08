<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TireManufacturer */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' =>  Yii::t('tires','Tire Manufacturer'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tires', 'Tire Manufacturers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tire-manufacturer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
