<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\assets\AppAsset;
use common\models\Settings;



/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html1>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="IU_Q4dGh6HcZy3x4A1gefi2hbg9qXwjV-bdouH2pmFQ" />
    <meta name='yandex-verification' content='7715a897c74dac3a' />

	<?php $this->registerLinkTag([
   
    'rel' => 'shortcut icon',
    'type' => 'image/ico',
    'href' => YII_BASE_URL.'/favicon.ico',
]);?>
	
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script type="text/javascript">
//<![CDATA[
baseUrl ='<?=Yii::$app->request->baseUrl;?>';
suffix ='<?=Yii::$app->urlManager->suffix;?>';
//]]>
</script>

</head>
<body>
  
    <?php $this->beginBody() ?>  
    <?php if (!YII_DEBUG): ?>
    <?php echo \frontend\widgets\analytics\Analytics::widget(['view'=>'google']);?>
     <?php echo \frontend\widgets\analytics\Analytics::widget(['view'=>'yandex']);?>
    <?php endif; ?>
    <div class="ajax-overlay ajax-overlay-fixed" style="width: auto; height: auto; ">
    <div id="ajax-loading"></div>
    </div>    
     
 <?php echo $content;?>
    
    
 <footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center-xs">
        <h3 class="footer">Наше меню</h3>
  <?php              echo Nav::widget([
    'options'=>['class'=>'nav footerMenu'],
    'items' => [
     
        ['label' => Yii::t('app','Шины'), 'url' => ['/shiny/find']],
        ['label' => Yii::t('app','Disks'), 'url' => ['/diski/find']],
        ['label' => Yii::t('app','Guarantee'), 'url' => ['/garantia']],
        ['label' => Yii::t('app','Payment').'&'.Yii::t('app','Delivery'), 'url' => ['/oplata']],
        ['label' => Yii::t('app','News'), 'url' => ['/news']],
        ['label' => Yii::t('app','Articles'), 'url' => ['/articles']],
        ['label' => Yii::t('app','Autodictionary'), 'url' => ['/avtoslovarik']],
        ['label' => Yii::t('app','Contacts'), 'url' => ['/contacts']],
    //    ['label' => 'Акции', 'url' => ['/site/news']],
        
    ],
]);?>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center-xs">
        <h3 class="footer">Шиномонтаж</h3>
        <ul>
          <li><!--ТЕЛ.: <?=Settings::findOne(['name'=>'Телефон1'])->value;?> <br/>
              ТЕЛ.: <?=Settings::findOne(['name'=>'Телефон2'])->value;?>
              -->
          </li>
          <li></li>
          <li>Г. ДНЕПРОПЕТРОВСК </li>
          <li>УЛ.БУЛЫГИНА, 10 А</li>
          <li>ПН-СБ: С 8:00 ДО 18:00</li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
        </ul>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-center-xs">
          <h3 class="footer">интернет-магазин</h3>
        <ul>
          <li><!--
              ТЕЛ.: <?=Settings::findOne(['name'=>'Телефон3'])->value;?> <br/>
              ТЕЛ.: <?=Settings::findOne(['name'=>'Телефон4'])->value;?>
              -->
          </li>
          <li></li>
          <li>E-MAIL: <?=Settings::findOne(['name'=>'email'])->value;?></li>
          <li>SKYPE: <?=Settings::findOne(['name'=>'skype'])->value;?></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 text-center-xs">
        <ul class="last">
          <li>© VASHASHINA.DP.UA <br>2011 - <?=date("Y");?></li>
          <li></li>
          <li>СОЗДАНИЕ САЙТА</li>
          <li><?=Html::img(['/images/dango.png']);?></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 social">
          <ul id="socialMenuFooter">
              <?php $google = Settings::findOne(['name'=>'google']);?>
              <?php if (isset($google->value) && $google->value):?>
            <li><?=Html::a('',$google->value,['class'=>'footer-icon-google','rel'=>'nofollow']);?></li> 
            <?php endif;?>
            
             <?php $twitter = Settings::findOne(['name'=>'twitter']);?>
              <?php if (isset($twitter->value) && $twitter->value):?>
            <li><?=Html::a('',$twitter->value,['class'=>'footer-icon-twitter','rel'=>'nofollow']);?></li> 
            <?php endif;?>
            
              <?php $facebook = Settings::findOne(['name'=>'facebook']);?>
             <?php if (isset($facebook->value) && $facebook->value):?>
            <li><?=Html::a('',$facebook->value,['class'=>'footer-icon-facebook','rel'=>'nofollow']);?></li> 
            <?php endif;?>
            
             <?php $vkontakte = Settings::findOne(['name'=>'vkontakte']);?>
             <?php if (isset($vkontakte->value) && $vkontakte->value):?>
            <li><?=Html::a('',$vkontakte->value,['class'=>'footer-icon-vkontakte','rel'=>'nofollow']);?></li> 
            <?php endif;?>
          
            <?php $youtube = Settings::findOne(['name'=>'youtube']);?>
             <?php if (isset($youtube->value) && $youtube->value):?>
            <li><?=Html::a('',$youtube->value,['class'=>'footer-icon-youtube','rel'=>'nofollow']);?></li> 
            <?php endif;?>
          
           
        </ul>
      </div>
    </div>
  </div>
</footer>
    <a href="#" class="scrollup">Наверх</a>
    <?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
