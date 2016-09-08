
  
  $(document).ready(function(){
 
    // добавляем кнопку для фильтра
    addFilterButton();
             // убираем применения фильтрм по изменению или нажатию кнопки
  $(document).off('change.yiiGridView keydown.yiiGridView');
   
});

      // убираем применения фильтрм по изменению или нажатию кнопки
  $(document).off('change.yiiGridView keydown.yiiGridView');

 $('body').on('click','#filterSubmit', function() {
        $('#tire-grid').yiiGridView('applyFilter');

          // return false;
        });

$(document).on('pjax:timeout', function(event) {
  // Prevent default timeout redirection behavior
  event.preventDefault()
});

$('#tires').on('pjax:end', function (event, xhr, textStatus, errorThrown, options) {
   // добавляем кнопку для фильтра
    addFilterButton();
    // убираем применения фильтрм по изменению или нажатию кнопки
       $(document).off('change.yiiGridView keydown.yiiGridView');
  
});

	$('#importButton').click(function(){
	$('#import').toggle();
	return false;
    });//	
    	$('#exportButton').click(function(){
	$('#export').toggle();
	return false;
    });//
    $('#exportData button').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
//    var positions = $('#tire-grid').find('[name^=\"selection\"]');
    var keys = $('#tire-grid').yiiGridView('getSelectedRows');
    $.each(keys,function(id,key){
    form.append('<input type=\"hidden\" name=\"positions[]\" value=\"'+key+'\"/>')
    });
   // var input = '<input type=\"hidden\"' name=\"positions[]\" value=\"\"/>
  //  form.append(positions);
   form.submit();
});

$('body').on('change','select[name="TireSearch[brandTitle]"]',function(e){
    var brand_id = $(this).find('option:selected').val();
  //  console.log(brand_id);
       $.ajax({
      url: baseUrl+'/tire-manufacturer/get-brand-models',
      data: {id:brand_id},
      dataType: 'html',
      success:function(data){
       if (data.length > 0){
    $('select[name="TireSearch[tireModel]"]').replaceWith(data);       
       }
              }  
   });
});

    function addFilterButton(){
  var filterButton ='<button type=\"button\" name=\"fltBtn\" class=\"btn btn-primary btn-small\" id=\"filterSubmit\">Фильтр</button>';
 $('table tr.filters td:last-child').html(filterButton);
}