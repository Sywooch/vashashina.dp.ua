<?php
use yii\widgets\ListView;
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Купить зимние и летние шины в Днепропетровске:
R13, R14, R15, R16, R17. Склад-магазин ВАША ШИНА. Продажа шин! ';
$this->registerMetaTag(['name'=> 'keywords','content' =>'шины, автошины, зимние шины, купить шины, грузовые шины, летние шины, литые диски, автомобильные диски , шины диски, магазин шины, шины 13, шины 14, шины 15, шины 16']);
$this->registerMetaTag(['name'=> 'description','content'=>'Интернет-магазин  Vashashina реализует летние и зимние шины: 13, 14 ,15, 16 и до 22. Грузовые шины R17,5 и R22,5 . У нас Вы всегда можете купить автомобильные шины и резину по самым низким ценам в Украине']);

?>
    <div class="main">
    <div class="offer">
      <h1 class="h-line orange"><span>МЫ ВАМ ПРЕДЛАГАЕМ</span></h1>
      <div class="container">
        <div class="row">
          <div class="col-sm-6 text-center-xs">
            <div class="img text-center-xs">
                <?=Html::img(['/images/bez_posrednikov.png']);?>
                </div>
            <div class="text">
              <h3 class="color-silver">
                  <?php echo Html::a('РАБОТУ БЕЗ ПОСРЕДНИКОВ',['/site/pages/o-nas'],['class'=>'color-silver']);?></h3>
              <p>У нас собственные складские площадя, с популярными производителями шин, мы работаем напрямую, что позволяет удерживать минимальные цены при продаже летний или зимней резины.</p>
            </div>
          </div>
          <div class="col-sm-6 text-center-xs">
            <div class="img text-center-xs">
                  <?=Html::img(['/images/dostavka.png']);?>
                </div>
            <div class="text">
              <h3 class="blue">
                   <?php echo Html::a('ДОСТАВКУ ПО ВСЕЙ УКРАИНЕ',['/site/pages/dostavka'],['class'=>'blue']);?>
                  </h3>
              <p>Мы осуществляем доставку шин и дисков по всей Украине. Купить шины в городах Харьков, Киев, Донецк, Одесса, Луганск, Запорожье, Днепропетровск и по всей Украине. Резина, шины, с бесплатной доставкой и без скрытых комиссий.</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 text-center-xs">
            <div class="img text-center-xs">
                    <?=Html::img(['/images/oplata.png']);?>
              
            </div>
            <div class="text">
              <h3 class="blue">
                    <?php echo Html::a('УДОБНЫЕ СПОСОБЫ ОПЛАТЫ',['/site/pages/oplata'],['class'=>'blue']);?>
                 </h3>
              <p>Вы можете оплатить покупку несколькими удобными способами: непосредственно при доставке колес и шин наличными, через банк, с использованием банковских систем Privat 24, и OTP Direct..</p>
            </div>
          </div>
          <div class="col-sm-6 text-center-xs">
            <div class="img text-center-xs">
                    <?=Html::img(['/images/novinki.png']);?>
            </div>
            <div class="text">
              <h3 class="color-silver">
                   <?php echo Html::a('НАЛИЧИЕ НОВИНОК СЕЗОНА',['/site/pages/novinki-v-mire-shin'],['class'=>'color-silver']);?>
                  </h3>
              <p>У нас Вы можете купить летние или зимние шины последнего поколения непосредственно после их появления, а не на следующий сезон.</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 text-center-xs">
            <div class="img text-center-xs">
                    <?=Html::img(['/images/sezoni.png']);?>
            </div>
            <div class="text">
              <h3 class="color-silver">
                   <?php echo Html::a('БОЛЬШОЙ АССОРТИМЕНТ ЛЕТНИХ И ЗИМНИХ ШИН В ДНЕПРОПЕТРОВСКЕ',['/site/pages/assortiment-sin'],['class'=>'color-silver']);?>
                  </h3>
              <p>В нашем Интернет-магазине шин и дисков Вы найдете не только новинки, но и модели прошлых сезонов на замену, также специализированные внедорожные автошины SUV</p>
            </div>
          </div>
          <div class="col-sm-6 text-center-xs">
            <div class="img text-center-xs">
                <?=Html::img(['/images/services.png']);?>    
              
            </div>
            <div class="text">
              <h3 class="blue">
                   <?php echo Html::a('СОПУТСТВУЮЩИЙ СЕРВИС',['/site/pages/soputstvuusij-servis-vasa-sina'],['class'=>'blue']);?>
                  </h3>
              <p>
                У нас действует собственный шиномонтаж – легковой, работает услуга сезонногохранения шин. Таким образом, Вы можете не просто купить у нас шины, но и получить комплексную услугу по «переобувке» и обслуживанию Вашего авто, а
                также по хранению сезонных комплектов шин. При смене зимних колес на летние вы можете оставить комплект зимней резины с дисками, или без, у нас на сезонном хранении.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
      
    <div class="news container">
        <!-- Short News widget -->
          <?php echo \frontend\widgets\shortNews\ShortNews::widget();?>
       <!-- end of Short News widget -->
    
             <!-- Short Articles widget -->
          <?php echo \frontend\widgets\shortArticles\ShortArticles::widget();?>
       <!-- end of Short Articles widget -->
    </div>
        
    <?php /* echo ListView::widget([
         'dataProvider' => $dataProvider,
    'itemView' => '/shiny/_tireView',
    'layout'=>'{items}{pager}',
    ]);
     * 
     */
