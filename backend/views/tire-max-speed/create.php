<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TireMaxSpeed */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Tire Max Speed',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tires', 'Tire Max Speeds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tire-max-speed-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
