<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TireRadius */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Tire Radius',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tire Radii'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tire-radius-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
