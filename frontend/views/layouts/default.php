<?php 
//use Yii;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\ActiveForm;
use common\models\Settings;
/* @var $this View */ 
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$headerClass = '';
$phonesClass = 'class="dark"';
if ($controller == 'site' && $action == 'index'){
    $headerClass = 'class="home"';
    $phonesClass = '';
    
}

?>
<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>

    <header <?=$headerClass ;?>>
   <?php     NavBar::begin(['options'=>['id'=>'topMenu',
            'class'=>'navbar navbar-default navbar-fixed-top']]);
   ?>
   
<div class="nav-menu-top">
<?php
echo Nav::widget([
    'options'=>['class'=>'nav navbar-nav','id'=>'navTopMenu'],
    'items' => [
     
        ['label' => Yii::t('app','Шины'), 'url' => ['/shiny/find']],
        ['label' => Yii::t('app','Disks'), 'url' => ['/diski/find']],
        ['label' => Yii::t('app','Guarantee'), 'url' => ['/garantia']],
        ['label' => Yii::t('app','Payment').'&'.Yii::t('app','Delivery'), 'url' => ['/oplata']],
        ['label' => Yii::t('app','News'), 'url' => ['/news']],
        ['label' => Yii::t('app','Autodictionary'), 'url' => ['/avtoslovarik']],
        ['label' => Yii::t('app','Contacts'), 'url' => ['/contacts']],
    //    ['label' => 'Акции', 'url' => ['/site/news']],
        
    ],
]);?>



</div>
<?php NavBar::end();?>
   
    <div class="container">
      <div class="row">
      <div class="mob_block">
        <div class="col-sm-4 logo">
          <h1><?=html::a('ВАША ШИНА',['/']);?></h1>
          <div id="logoPhones" <?=$phonesClass ;?>>
              <span class="phone first"><?=Settings::findOne(['name'=>'Телефон1'])->value;?></span>
          <span class="phone"><?=Settings::findOne(['name'=>'Телефон2'])->value;?></span>
          <span class="phone"><?=Settings::findOne(['name'=>'Телефон3'])->value;?></span>
          <span class="phone"><?=Settings::findOne(['name'=>'Телефон4'])->value;?></span>
          </div>
        </div>
        </div>
        <div class="col-sm-5 col-xs-6 search">
             <?php ActiveForm::begin([
    'id' => 'find-form',
    'method'=>'GET',
    'action'=>['/site/search'],
    'options' => ['class' => 'form-horizontal'],
]);?> 
        
            <input type="text" placeholder="Поиск по Производителю и/или Модели" name="q" class="form-control" id="searchInput">
           <?php ActiveForm::end();?>
        </div>
          <?php echo \frontend\widgets\topCart\TopCart::widget() ;?>
      </div>
    </div>
       
   
<?php if ($controller == 'site' && $action == 'index'):?>            
          <h1 class="h-line"><span>Мне нужны</span></h1>
<div class="container calc">
      
    <div class="row">
        <!-- tire search widget -->
      
          
<?php echo \frontend\widgets\findTire\FindTire::widget();?>
       
             <!-- end of tire search widget -->
          
                  <!-- disk search widget -->
       
           <?php echo \frontend\widgets\findDisk\FindDisk::widget();?>
      
                       <!-- end of disk search widget -->
    </div>
      <!-- FindByCar search widget -->
          <?php echo \frontend\widgets\findByCar\FindByCar::widget();?>
       <!-- end of FindByCar search widget -->
</div>
          <?php endif;?>
  </header> 
    <?php echo  $content;?>
 
<?php $this->endContent(); ?>