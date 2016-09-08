<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TireWidth */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Tire Width',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tire Widths'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tire-width-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
