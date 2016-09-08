
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title;?></title>
<meta name="description" content="<?php if (isset($meta_d)):?> <?=$meta_d;?> <?php else:?> Интернет-магазин  Vashashina реализует летние и зимние шины: 13, 14 ,15, 16 и до 22. Грузовые шины R17,5 и R22,5 . У нас Вы всегда можете купить автомобильные шины и резину по самым низким ценам в Украине<?endif;?> " />
<meta name="keywords" content="<?php if (isset($meta_k)):?> <?=$meta_k;?> <?php else:?>шины, автошины, зимние шины, купить шины, грузовые шины, летние шины, литые диски, автомобильные диски , шины диски, магазин шины, шины 13, шины 14, шины 15, шины 16 <?endif;?>" />
<meta name="google-site-verification" content="IU_Q4dGh6HcZy3x4A1gefi2hbg9qXwjV-bdouH2pmFQ" />
<meta name='yandex-verification' content='7715a897c74dac3a' />

<link rel="stylesheet" type="text/less" media="screen" href="<?=base_url() ?>css/default.less"/>
<?php
$this->load->library('user_agent');

if ($this->agent->is_browser())
{
   if ($this->agent->is_browser('Internet Explorer')){
    switch ($this->agent->version()){
       
       case "6.0": ?>
       <link rel="stylesheet" type="text/less" media="screen" href="<?=base_url() ?>css/ie6.less"/>
     
    
       <?php break;
       
        case "7.0": ?>
       <link rel="stylesheet" type="text/less" media="screen" href="<?=base_url() ?>css/ie7.less"/>
       <?php break;
    }
   }

}

?>


<?=link_tag('favicon.ico', 'shortcut icon', 'image/ico');?>

<?php if(isset($scripts_css)){echo $scripts_css;}?>
<? echo $this->jquery->min();?>
<? echo $this->jquery->plugins(array('select-customizer'));?>
<? echo $this->jquery->comleacated_plugin('fancybox',array('fancybox-1.3.4.pack','easing-1.3.pack','mousewheel-3.0.6.pack'),array('fancybox-1.3.4'));?>



<?php if(isset($scripts)){echo $scripts;}?>
 
<?php if ($this->agent->is_browser())
{
   if ($this->agent->is_browser('Internet Explorer')){
    if ($this->agent->version() <= "9.0"){?>
 <script language="javascript" type="text/javascript" src="<?=base_url() ?>js/jquery.corner.js"></script>
   <script type="text/javascript">
	$(document).ready(function(){
	  $("#search_nav, #left_menu, #right_menu ").corner();
	});
	</script>
 <?php }} }?>

<?php //echo $this->javascript->script('add_to_cart');?>
<?php echo $this->javascript->script('less-1.1.5.min');?>

<script type="text/javascript">
//<![CDATA[
base_url ='<?=base_url();?>';
//]]>
function proseed(){
   
var avto_class = $('#avto_class').val();
var avto_width = $('#avto_width').val();
var avto_height = $('#avto_height').val();
var avto_diameter = $('#avto_diameter').val();
var avto_season = $('#avto_season').val();
var avto_brand = $('#avto_brand').val();
var avto_sort = $('#avto_sort').val();

 $.ajax({
   type: "POST",
   url: base_url+"shini/select",
   data: {"avto":avto_class,
         "width":avto_width,
         "profile":avto_height,
         "diameter": avto_diameter,
         "season": avto_season,
         "brand": avto_brand,
         'sort': avto_sort       
         },
   success: processHtml,
        dataType: 'html'
  
});
}
function processHtml(html) {
     $('div#content').empty();
    $('div#content').html(html);
}  

$("#loading img").ajaxStart(function(){
   $(this).show();
 }).ajaxStop(function(){
   $(this).hide();
 })

</script>

 <!--[if IE 6]>
<script src="<?=base_url();?>js/DD_belatedPNG.js"></script>
<script>
DD_belatedPNG.fix('.png_bg, .png_img,#searchbtn'); 
</script>
<![endif]-->

<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
</head>
<body>
<div id="wrapper">
<div id="header">
<div id="top_right_banner">
<?php echo Modules::run('banners/showBanners','top_right');?>
</div>
<div id="top_left_banner">
<a href="<?=base_url();?>contacts">
<img src="<?=base_url() ?>images/top_left_banner.png" class="png_img" />
</a>
</div>
</div>

<div id="navigation">
<?php echo modules::run('navigation/topmenu');?>
</div>
<div id="search">
 <?php echo modules::run('search');?>
</div>
<div class="clear"></div>
<div id="search_nav">
<?php echo modules::run('search/tires_search');?>
</div>
<div class="clear"></div>
<?php if(!$this->uri->segment(1)):?>
<div id="sidebar_right">
<?php echo modules::run('navigation/right_menu');?>
</div>
<div id="sidebar_left">
<?php echo modules::run('navigation/left_menu');?>
<?php echo modules::run('banners/showBanners','left_middle',0);?>
</div>
<div id="content">
	<?php echo $this->load->view($main);?>
    
</div>
<?php else:?>
<div id="sidebar_left">
<?php echo modules::run('navigation/left_menu');?>
<?php echo modules::run('banners/showBanners','left_middle',0);?>
</div>
<div id="content" style="width: 705px;">
	<?php echo $this->load->view($main);?>	
</div>
<?php endif;?>

<div class="clear"></div>
<?php if(!$this->uri->segment(1)):?>
	<?php echo modules::run('akcii/main_page');;?>	
 <?php endif;?>  
<div id="footer">
<?php echo $this->load->view('blocks/footer');?>
</div>
</div>

<!-- Yandex.Metrika informer -->
<div style="display:none;">
<a href="https://metrika.yandex.ru/stat/?id=10625119&amp;from=informer"
target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/10625119/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:10625119,lang:'ru'});return false}catch(e){}"/></a>
</div>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter10625119 = new Ya.Metrika({id:10625119,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<!-- /Yandex.Metrika counter -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-5395905-4', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
