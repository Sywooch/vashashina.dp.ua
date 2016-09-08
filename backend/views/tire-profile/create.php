<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TireProfile */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Tire Profile',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tires', 'Tire Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tire-profile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
