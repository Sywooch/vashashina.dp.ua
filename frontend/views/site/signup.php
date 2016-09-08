<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = Yii::t('app','Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="novosti">
  <h5 class="menu_title"><?= Html::encode($this->title) ?></h5>
<div class="news">
 
    <p><?php echo Yii::t('app','Please fill out the following fields to signup');?>:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'email') ?>
                </div>
                 <div class="col-lg-5">
                <?= $form->field($model, 'phone') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                 <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                 </div>
                 <div class="clear"></div>
                <div class="form-group center" style="text-align: center;">
                    <?= Html::submitButton(Yii::t('app','Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>