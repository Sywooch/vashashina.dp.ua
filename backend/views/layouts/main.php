<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$this->registerJs('
		$("li.showOverlay > a, a.showOverlay").click(function(){
		$("div.ajax-overlay").show();
		});
		')
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
            <script type="text/javascript">
//<![CDATA[
baseUrl ='<?=Yii::$app->request->baseUrl;?>';
suffix = '<?=Yii::$app->urlManager->suffix;?>';
//]]>
</script>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="ajax-overlay ajax-overlay-fixed" style="width: auto; height: auto; ">
<div id="ajax-loading">
</div>
</div>
    <div class="wrap">
        <?php
            NavBar::begin([
          //      'brandLabel' => 'ВашаШина',
          //      'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => yii::t('app', 'Home'), 'url' => ['/site/index']],
            	['label' => yii::t('app', 'Orders'), 'url' => ['/order/index']],
                ['label' => 'Шины', 'items'=>[
                    ['label'=>'Производители шин','url' => ['/tire-manufacturer/index']],  
                    ['label'=>'Модели шин', 'url' => ['/tire-model/index']],
                    ['label'=>'Шины', 'url' => ['/tire/index']],
                 //   ['label'=>'Профили шин', 'url' => ['/tire-profile/index']],  
                 //   ['label'=>'Ширина шин', 'url' => ['/tire-width/index']],
                 //   ['label'=>'Диаметр шин', 'url' => ['/tire-radius/index']],
                    ['label'=>'Макс. нагрузка шин', 'url' => ['/tire-max-load/index']],
                    ['label'=>'Макс. скорость шин', 'url' => ['/tire-max-speed/index']],
                ]],
                ['label' => 'Диски', 'items'=>[
                    ['label'=>'Производители дисков','url' => ['/disk-manufacturer/index']],  
                    ['label'=>'Модели дисков', 'url' => ['/disk-model/index']],
                    ['label'=>'Диски', 'url' => ['/disk/index']],
          //          ['label'=>'Профили шин', 'url' => ['/tire-profile/index']],  
            //        ['label'=>'Ширина шин', 'url' => ['/tire-width/index']],
              //      ['label'=>'Диаметр шин', 'url' => ['/tire-radius/index']],
                //    ['label'=>'Макс. нагрузка шин', 'url' => ['/tire-max-load/index']],
                  //  ['label'=>'Макс. скорость шин', 'url' => ['/tire-max-speed/index']],
                ]],
            	['label' => 'Товары/Услуги', 'items'=>[
                    ['label'=>'Товары','url' => ['/product/index']],
                    ['label'=>'Услуги', 'url' => ['/service/index']],
                    ['label'=>'Категории товаров', 'url' => ['/category/index']],
                    ['label'=>'Поставщики товаров', 'url' => ['/brand/index']],
                    ['label'=>'Параметры категории', 'url' => ['/cat-param/index']],
                    ['label'=>'Параметры товаров', 'url' => ['/product-param/index']],
            	            						
            				]],
            	['label' => 'Старницы/Новости', 'items'=>[
            		['label'=>'Новости','url' => ['/news/index']],
            		['label'=>'Страницы', 'url' => ['/page/index']],
                        ['label'=>'Статьи', 'url' => ['/article/index']],
   		 
            	]],
                ['label' => 'Разное', 'items'=>[
                    ['label' => 'Мета теги','url'=>['/meta-tag-template/index']],
                    ['label'=>'Настройки','url'=>['/settings/index']],
                    ['label' => 'Переводы','url'=>['/i18n']],
                       ['label' => 'Php Info','url'=>['/site/php-info']],
                  
                  ]],
                ['label' => 'Поставщики', 'items'=>[
                    ['label' => 'Импортирование','url'=>['suppliers/import']],
                    ['label' => 'TireTrader Шины','url'=>['suppliers/view',
                    		'supplier'=>'TireTrader','type'=>'Tires']],
                	['label' => 'TireTrader Диски','url'=>['suppliers/view',
                			'supplier'=>'TireTrader','type'=>'Disks']]
                  ]],
            	['label' => 'Пользователи', 'url' => ['/user/index']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; vashashina.dp.ua 2011 - <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
