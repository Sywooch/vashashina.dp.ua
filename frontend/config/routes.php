<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
return [
                '' => 'site/index',
                'login'=>'site/login',
                'logout'=>'site/logout',
                'register'=>'site/signup',
                '<page_alias:(contacts|dostavka|privacy|conditions|garantia|oplata|
				rasprodazha|predlozhenie-nedeli|avtoslovarik)>'=>'site/pages',
                'site/pages/<page_alias:>'=>'site/pages',
                'news'=>'site/news',
                'news/<news_alias:>'=>'site/news',
                'articles'=>'site/articles',
                'articles/<article_alias:>'=>'site/articles',
                'uslugi/<alias:>'=>'uslugi/view',
                '<controller:(Автошины|shiny)>/<tire_type:(Шины_для_легковых_автомобилей|'
                . 'Шины_для_внедорожников|'
                . 'Шины_для_грузовых_автомобилей|'
                . 'Летние_шины|Зимние_шины|Всесезонные_шины)>'=>'shiny/type-view',
                '<controller:(Автотовары|products)>/<category_alias:>'=>'products/category-view',
                '<controller:(Автотовары|products)>/<category_alias:>/<product_alias:>'=>'products/view',
		'<controller:(Автошины|shiny)>/<brand_alias:>/<model_alias:>'=>'shiny/view',
                '<controller:(diski)>/<brand_alias:>/<model_alias:>'=>'diski/view',
                '<controller:(Автошины|shiny)>/<brand_alias:>/<model_alias:>/<tire_id:\d+>'=>'shiny/view',
                '<controller:(Автошины|shiny)>/<brand_alias:>/<model_alias:>/<tire_id:\d+>/<tire_params:>/<model_params:>'=>'shiny/view',
                '<controller:(cart)>/<action>/<cat_id:>/<id:>'=>'cart/<action>',
           //     '<controller:>/<action:>'=>'<controller:>/<action:>',
		['route'=>'sitemap/index', 'pattern'=>'sitemap.xml', 'suffix'=>''],
            ];

