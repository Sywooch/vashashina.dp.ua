<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = Yii::t('app','Reset Password');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="container"> 
                <div class="row"> 
                    <div class="col-lg-12">
                        <h3><?=$this->title;?></h3>
     <p class="text-danger"><?=Yii::t('app','Your password has been reseted!');?><br/>
    <?=Yii::t('app','Please choose your new password');?>:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-primary']) ?>
                    
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>
    </div>
