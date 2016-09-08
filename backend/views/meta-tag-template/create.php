<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MetaTagTemplate */

$this->title = Yii::t('app', 'Create Meta Tag Template');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Meta Tag Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-tag-template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
