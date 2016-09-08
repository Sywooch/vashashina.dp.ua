<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tire */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => Yii::t('tires','Tire'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tires', 'Tires'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tire-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
