<?php //header("Content-type: text/xml");
$file = $company."XmlProm.xml";
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");;
    header("Content-Disposition: attachment;filename=$file");
    header("Content-Transfer-Encoding: binary ");?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>

<shop date="<?php echo date('Y-m-d H:i');?>">
<name><?=$name;?></name>
<company><?=$company;?></company>
<url><?=$url;?></url>
<currencies>
    <?php if($currencies !== null && $currencies > 0):?>
      <?php foreach ($currencies as $key => $currency) :?>
    <?php if ($currency):?>
<currency id="<?php echo $key;?>" rate="<?php echo $currency;?>"/>
<?php endif;?>
<?php endforeach;?>

<?php endif;?>
<currency id="UAH" rate="1"/>
</currencies>
<catalog>
    <?php if ($categories !== null && count($categories)> 0) :?>
    <?php foreach ($categories as $category) :?>
<category id="<?php echo (($url !=='vashashina.dp.ua')?10000:0) + $category->id;?>" portal_id="801222" 
	portal_url="http://prom.ua/Avtomobilnye-shiny">
    <?php echo mb_convert_case($category->title, MB_CASE_TITLE);?>
</category>
<?php endforeach;?>
<?php endif;?>
</catalog>
<items>
    <?php foreach ($items as $item):?>
<item id="<?php echo (($url !=='vashashina.dp.ua')?"vs_":''). $item->id;?>">
<name><?php echo htmlspecialchars(trim($item->title));?></name>
<url><?php echo str_replace('/localhost',"",$host) . str_replace('backend/web/',"",$item->tireModel->url);?></url>
<priceuah><?php echo $item->price;?></priceuah>
<currencyId>UAH</currencyId>
<categoryId><?php echo  (($url !=='vashashina.dp.ua')?10000:0) + $item->tireModel->car_type;?></categoryId>
<image>
<?php echo str_replace('/localhost',"",$host) . str_replace('backend/web/',"",$item->tireModel->imageUrl);?>
</image>
<vendor><?php echo $item->tireModel->brand->title;?></vendor>
<param name="Ширина"><?php echo $item->width;?></param>
<param name="Профиль"><?php echo $item->profile;?></param>
<param name="Диаметр"><?php echo $item->diameter;?></param>
<param name="Сезон"><?php echo $item->tireModel->tireSeason->singular;?></param>
<param name="Тип авто"><?php echo $item->tireModel->carType->title;?></param>
<param name="Шип"><?php echo $item->ship;?></param>
<param name="Индекс Скорости"><?php echo $item->max_speed;?></param>
<param name="Индекс Нагрузки"><?php echo $item->max_load;?></param>
<param name="Страна-производитель"/>
<param name="Год выпуска"/>
<description>
     <![CDATA[
    <?php echo (isset($item->tireModel->long_desc))? $item->tireModel->long_desc :'';?>
    ]]>
</description>
<available><?php echo ($item->quantity>0)?'Склад':'Под заказ';?></available> 

</item>
    <?php endforeach;?>
</items>
</shop>
