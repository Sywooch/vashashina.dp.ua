<?php //header("Content-type: text/xml");
$file = "TourlandiaHotlineXml.xml";
 	header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");;
    header("Content-Disposition: attachment;filename=$file");
    header("Content-Transfer-Encoding: binary ");?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>
<price>
	<date><?php echo date("Y-m-d H:i:s"); ?></date>
	<firmName>TourLandia.com.ua</firmName>
	<firmId>24351</firmId>
	<rate></rate>
	<categories>
	<?php foreach ($categories as $category):?>
	<category>
	<id><?php echo $category->id;?></id>
	<name><?php echo $category->title;?></name>
	</category>
	<?php endforeach;?>
	</categories>
	<items>
    <?php foreach ($items as $item): ?>
        <item>
    <id><?php echo $item->id; ?></id>
    <categoryId><?php echo $item->category_id ?></categoryId>
    <code><?php echo $item->sku ?></code>
    <vendor><?php echo htmlspecialchars(Manufacturers::model()->findByPk($item->manufacturer_id)->title) ;?></vendor>
    <name><?php echo htmlspecialchars($item->title); ?></name>
    <description>
    <![CDATA[
    <?php echo (isset($item->longdesc))? $item->longdesc :'';?>
    ]]>
    </description>
    <url><?php echo (YII_DEBUG?'http:/':'http://'.$_SERVER['HTTP_HOST']).htmlspecialchars($item->getUrl()); ?></url>
          <?php if ($this->manyImages && count($item->images)>0):?>
        <?php $count = 1; foreach ($item->images as $img):?>
        <?php if ($count > 10) break; ?>
          <image><?php echo (YII_DEBUG?'http:/':'http://'.$_SERVER['HTTP_HOST']).$img->getImageUrl();?></image>
  
        <?php $count++; endforeach;?>
        <?php else:?>
    <image><?php echo (YII_DEBUG?'http:/':'http://'.$_SERVER['HTTP_HOST']).$item->getImageUrl();?></image>
    <?php endif;?>
    <priceRUAH><?php echo $item->price?></priceRUAH>
    <oldprice></oldprice>
    <priceRUSD></priceRUSD>
    <stock><?php echo ($item->quantity>0)?'Склад':'Под заказ';?></stock>
    <guarantee></guarantee>
    
    </item>
    <?php if (count($item->combinations)>0):?>
      <?php foreach ($item->combinations as $comb): ?>
    <item>
    <id><?php echo $item->id.'-'.$comb->id; ?></id>
    <group_id><?php echo $item->id; ?></group_id>
    <categoryId><?php echo $item->category_id ?></categoryId>
    <code><?php echo $item->sku ?></code>
    <vendor><?php echo htmlspecialchars(Manufacturers::model()->findByPk($item->manufacturer_id)->title) ;?></vendor>
    <name><?php echo trim(htmlspecialchars($item->title).' '.$comb->color->title.' '.$comb->size->title); ?></name>
    <description>
	 <![CDATA[
    <?php echo (isset($item->longdesc))? $item->longdesc :'';?>
    ]]>
	</description>
    <url><?php echo (YII_DEBUG?'http:/':'http://'.$_SERVER['HTTP_HOST']).htmlspecialchars($item->getUrl()); ?></url>
    <image><?php $imageUrl =  ProductImage::model()->findByPk(ProductColors::getproductColorImage($comb->color->id, $item->id))->imageUrl;
   if ($imageUrl)
    	echo (YII_DEBUG?'http:/':'http://'.$_SERVER['HTTP_HOST']).$imageUrl;
    else
    echo (YII_DEBUG?'http:/':'http://'.$_SERVER['HTTP_HOST']).$item->imageUrl;?></image>
    <priceRUAH><?php echo $comb->price?></priceRUAH>
    <oldprice></oldprice>
    <priceRUSD></priceRUSD>
    <stock><?php echo ($comb->quantity>0)?'Склад':'Под заказ';?></stock>
    <guarantee></guarantee>
    <?php if ($comb->color->title):?>
    <param name="Цвет"><?php echo $comb->color->title;?></param>
    <?php endif;?>
        <?php if ($comb->size->title):?>
    <param name="Размер"><?php echo $comb->size->title;?></param>
    <?php endif;?>  
    </item>
     <?php endforeach; // combinations?>
      <?php endif;?>
    <?php endforeach; //items?>
    </items>
</price>


