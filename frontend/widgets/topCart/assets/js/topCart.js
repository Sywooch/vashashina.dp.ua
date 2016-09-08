$(document).ready(function() {
$('.show-cart').on('click', function () {
	$('#popCartItems').toggle();
})

$('#popCartItems .close-cart').on('click', function () {
	$('#popCartItems').css({
		'display': 'none'
	});
});

jQuery('#cartShow,a.toCart').click(function(e){
     e.preventDefault();
     jQuery.fancybox.showLoading() 
   action = jQuery(this).attr('href');

jQuery.ajax({
       type:'post',
       url: action,
       dataType:'html',
      // data: {},
       success:function (data){
        
           jQuery.fancybox(data,{'closeBtn':false});
       }
   }); 
});
 

});