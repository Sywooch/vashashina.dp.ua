<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TireModel */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Tire Model',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tires', 'Tire Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tire-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
