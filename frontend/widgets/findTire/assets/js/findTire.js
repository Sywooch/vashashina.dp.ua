tirePriceSlider = $('#ex').slider({
	id:'tirePriceSlider',
	width:'300px',
	}).on('slideStop',function(e){
	
	//	$('#minPriceTire').empty();
	//	$('#maxPriceTire').val(0);
		$('#minPriceTire').val(e.value[0]);
		$('#maxPriceTire').val(e.value[1]);
                 sendAjaxTire(getFormDataTire());
});

$('#minPriceTire,#maxPriceTire').change(function(){
	var minPrice = parseInt($('#minPriceTire').val());
	var maxPrice = parseInt($('#maxPriceTire').val())
	tirePriceSlider.slider('setValue',[minPrice,maxPrice]);
});

// кликаем на тип автомобиля
$('#carType > li > a').click(function(){
    var list = $('#carType > li > a');
    var a = $(this);
    var input = $('#carTypeInput');
    
    list.removeClass('active');
    a.addClass('active');
    input.val(a.text());
});

// кликаем на сезон
$('.seasonIcon').click(function(){
    var list = $('.seasonIcon');
    var a = $(this);
    var input = $('#seasonInput');
    
    if (a.hasClass('active')){
    input.val('');
    list.removeClass('active');
    } else {
        list.removeClass('active');
    a.addClass('active');
    input.val(a.attr('id'));
    }
   
});

$('.seasonIcon,#carType > li > a').on('click',function(){
  sendAjaxTire(getFormDataTire());
});

$('#tire-find-form select, #tire-find-form input').not('input#ex').on('change',function(){
    sendAjaxTire(getFormDataTire());
});

//
function getFormDataTire(){
    var data = $('#tire-find-form').serializeArray();
    return data;
  //  console.log(data);
}/**/

function sendAjaxTire(data){
     $.ajax({
   type: "POST",
   url: baseUrl+"/shiny/find?onlyCount=true",
   data: data,
   success: processJsonTire,
        dataType: 'html',
   ajaxStart:function(){
        $("div.ajax-overlay").show();
   },
   ajaxStop:function(){
        $("div.ajax-overlay").hide();
   }
  
});
    
}/**/

function processJsonTire(data){
    var form = $('#tire-find-form');
    form.find('div.find-box > span.count').text(data);
    form.find('div.find-box').css('display','inline-block');
    var url = window.location.href;
 
    if (data !=0 && url.indexOf('shiny/find') !=-1 ){
        
         form.submit();   
    }
 
    
  //  console.log(data)
}/**/

$(document).ajaxStart(function(){
   $("div.ajax-overlay").show();
 }).ajaxStop(function(){
   $("div.ajax-overlay").hide();
 });

