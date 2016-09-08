<?php

/*
echo SiteMenu::widget([
    'items' => [
        // Important: you need to specify url as 'controller/action',
        // not just as 'controller' even if default action is used.
        ['label' => 'Home', 'url' => ['site/index']],
        // 'Products' menu item will be selected as long as the route is 'product/index'
        ['label' => 'Products', 'url' => ['product/index'], 'items' => [
            ['label' => 'New Arrivals', 'url' => ['product/index', 'tag' => 'new']],
            ['label' => 'Most Popular', 'url' => ['product/index', 'tag' => 'popular']],
        ]],
        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
    ],
]);
 */

namespace app\components\widgets\sitemenu;

use yii\base\Widget;
use yii\widgets\Menu;
/**
 * Description of SiteMenu
 *
 * @author SParadox
 */
class SiteMenu extends Widget {

    public $items = []; //Меню

    public $bundle;     //Статическое имя класса bundleName::className()

    public function init() {
        parent::init();
    }
    
    public function run() {
        parent::run();
        $this->registerBundle();
        $menu = new Menu;
        $menu->options = ['class' => 'site-menu'];
        $menu->activateItems = false;
        $menu->firstItemCssClass = 'first';
        $menu->lastItemCssClass = 'last';
        $menu->items = $this->items;
        $menu->run();
    }
    
    /**
     * Регистрирует bundle
     */
    private function registerBundle()
    {
        //Если бандл был передан
        if(!empty($this->bundle)) {
            //то зарегистрируем его.
            $this->view->registerAssetBundle($this->bundle);
        } else {
            //А иначе зарегистрируем бандл по умолчанию
            $this->view->registerAssetBundle(SiteMenuAsset::className());
        } 
    }
}
