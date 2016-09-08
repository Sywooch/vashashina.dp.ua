<?php 
use frontend\widgets\yashare\YaShareAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;

YaShareAsset::register($this);
$this->registerJs("

    ",  \yii\web\View::POS_READY,'yashare');
$this->registerMetaTag(['name'=> 'og:title','content' =>$this->context->title]);
$this->registerMetaTag(['name'=> 'og:url','content' =>Yii::$app->request->hostinfo.$this->context->url]);
$this->registerMetaTag(['name'=> 'og:image','content' =>Yii::$app->request->hostinfo.$this->context->image]);
$this->registerMetaTag(['name'=> 'og:description','content' =>strip_tags($this->context->desc)]);

?>
  <div class="socialButtons">
    <div class="ya-share2" 
         data-services="vkontakte,facebook,twitter,odnoklassniki,moimir,gplus,blogger,delicious,digg,evernote,linkedin,lj,pocket,qzone,renren,sinaWeibo,surfingbird,tencentWeibo,tumblr,viber,whatsapp" 
         data-counter
         data-limit ="5"
         data-lang="ru"
         data-title="<?=mb_convert_case($this->context->title, MB_CASE_TITLE, "UTF-8");?>"
         data-url="<?=Yii::$app->request->hostInfo.$this->context->url;?>"
         data-image="<?=Yii::$app->request->hostInfo.$this->context->image;?>"
         data-description="<?=strip_tags($this->context->desc);?>"></div>              
              </div>

    