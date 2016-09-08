<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('app','Site Search').'. Поисковая фраза: "'.$q.'"';
$this->params['breadcrumbs'][] = $this->title;
  
?>
<div class="container">
  <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
<div class="row margin-20">
    <div class="col-sm-6">
          <div class="finded bordered">
       <?php if (count($tires)> 0):?>
     <p>Найдено моделей шин: <?=count($tires);?> </p>
        <?php foreach ($tires as $tire):?>
        <?=  Html::a($tire->fullTitle,$tire->url);?><br/>
        <?php endforeach;?>
        <?php else:?>
    <p>Извините, по Вашему запросу шины не найдены</p>
    <?php endif;?>
          </div>
    </div>
    <div class="col-sm-6">
        <div class="finded bordered">
       <?php if (count($disks)> 0):?>
<p>Найдено моделей дисков: <?=count($disks);?> </p>
        <?php foreach ($disks as $disk):?>
        <?=  Html::a($disk->fullTitle,$disk->url);?><br/>
        <?php endforeach;?>
        <?php else:?>
    <p>Извините, по Вашему запросу диски не найдены</p>
    <?php endif;?>
        </div>
    </div>

</div>
</div>
