<?php //header("Content-type: text/xml");
$file = "TourlandiaPromXml.xml";
 	header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");;
    header("Content-Disposition: attachment;filename=$file");
    header("Content-Transfer-Encoding: binary ");?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>
<shop>
<currency code="USD" rate="26" />
<catalog>
	<?php foreach ($categories as $category):?>
	<category id ="<?php echo $category->id;?>"
	portal_id="<?php echo $category->promCats[0]->prom_id?>" 
	portal_url="<?php echo $category->promCats[0]->url?>">
	<?php echo $category->title;?>
	</category>
	<?php endforeach;?>
</catalog>
	<items>
    <?php foreach ($items as $item): ?>
    <?php if (count($item->combinations)>0):?>
      <?php foreach ($item->combinations as $comb): ?>
    <item id="<?php echo $item->id.'-'.$comb->id; ?>">
  
    <categoryId><?php echo $item->category_id; ?></categoryId>
    <vendorCode><?php echo $comb->sku ?></vendorCode>
    <vendor><?php echo htmlspecialchars(Manufacturers::model()->findByPk($item->manufacturer_id)->title) ;?></vendor>
    <name><?php echo htmlspecialchars(trim($item->title)).' '.$comb->color->title.' '.$comb->size->title; ?></name>
    <description>
   <![CDATA[
    <?php echo (isset($item->longdesc))? $item->longdesc :'';?>
    ]]>
    </description>
    <image><?php $imageUrl =  ProductImage::model()->findByPk(ProductColors::getproductColorImage($comb->color->id, $item->id))->imageUrl;
   if ($imageUrl)
    	echo (YII_DEBUG?'http:/':'http://'.$_SERVER['HTTP_HOST']).$imageUrl;
    else
    echo (YII_DEBUG?'http:/':'http://'.$_SERVER['HTTP_HOST']).$item->imageUrl;?></image>
    <priceuah><?php echo $comb->price?></priceuah>
  
     <priceusd></priceusd>
    <available><?php echo ($comb->quantity>0)?'Склад':'Под заказ';?></available>
   
    <?php if ($comb->color->title):?>
    <param name="Цвет"><?php echo $comb->color->title;?></param>
    <?php endif;?>
        <?php if ($comb->size->title):?>
    <param name="Размер"><?php echo $comb->size->title;?></param>
      <?php endif;?>
    </item>
      <?php endforeach; // combinations?>
    <?php else :?>  
    
    <item id="<?php echo $item->id; ?>" selling_type="r">   
    <categoryId><?php echo $item->category_id ?></categoryId>
    <vendorCode><?php echo $item->sku ?></vendorCode>
    <vendor><?php echo htmlspecialchars(Manufacturers::model()->findByPk($item->manufacturer_id)->title) ;?></vendor>
    <name><?php echo htmlspecialchars(trim($item->title)); ?></name>
    <description>    
    <![CDATA[
    <?php echo (isset($item->longdesc))? $item->longdesc :'';?>
    ]]>
    </description>
        <?php if ($this->manyImages && count($item->images)>0):?>
        <?php $count = 1; foreach ($item->images as $img):?>
        <?php if ($count > 10) break; ?>
          <image><?php echo (YII_DEBUG?'http:/':'http://'.$_SERVER['HTTP_HOST']).$img->getImageUrl();?></image>
  
        <?php $count++; endforeach;?>
        <?php else:?>
    <image><?php echo (YII_DEBUG?'http:/':'http://'.$_SERVER['HTTP_HOST']).$item->getImageUrl();?></image>
    <?php endif;?>
       <priceuah><?php echo $item->price?></priceuah>
    <priceusd></priceusd>
    <available><?php echo ($item->quantity>0)?'Склад':'Под заказ';?></available>  
    </item>
      <?php endif;?>
   
    
    <?php endforeach; //items?>
    </items>
</shop>