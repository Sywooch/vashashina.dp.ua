diskPriceSlider = $('#ex2').slider({
	id:'diskPriceSlider',
	width:'300px',
	}).on('slideStop',function(e){
	
	//	$('#minPriceTire').empty();
	//	$('#maxPriceTire').val(0);
		$('#minPriceDisk').val(e.value[0]);
		$('#maxPriceDisk').val(e.value[1]);
                   sendAjaxDisk(getFormDataDisk());
});

$('#minPriceDisk,#maxPriceDisk').change(function(){
	var minPrice = parseInt($('#minPriceDisk').val());
	var maxPrice = parseInt($('#maxPriceDisk').val())
	diskPriceSlider.slider('setValue',[minPrice,maxPrice]);
});

// кликаем на тип диска
$('#diskType > li > a').click(function(){
    var list = $('#diskType > li > a');
    var a = $(this);
    var input = $('#diskTypeInput');
    
    list.removeClass('active');
    a.addClass('active');
    input.val(a.text());
});

$('#diskType > li > a').on('click',function(){
     sendAjaxDisk(getFormDataDisk());
});

$('#disk-find-form select, #disk-find-form input').not('input#ex2').on('change',function(){
    sendAjaxDisk(getFormDataDisk());
});

//
function getFormDataDisk(){
    var data = $('#disk-find-form').serializeArray();
    return data;
  //  console.log(data);
}/**/

function sendAjaxDisk(data){
     $.ajax({
   type: "POST",
   url: baseUrl+"/diski/find?onlyCount=true",
   data: data,
   success: processJsonDisk,
        dataType: 'html'
  
});
    
}/**/

function processJsonDisk(data){
    var form = $('#disk-find-form');
    form.find('div.find-box > span.count').text(data);
    form.find('div.find-box').css('display','inline-block');
    var url = window.location.href;
 
    if (data !=0 && url.indexOf('diski/find') !=-1 ){
         form.submit();   
    }
  
}/**/