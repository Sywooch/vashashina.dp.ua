<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TireMaxLoad */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Tire Max Load',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tires', 'Tire Max Loads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tire-max-load-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
