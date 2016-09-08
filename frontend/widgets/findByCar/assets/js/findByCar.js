$(document).ready(function(){
   
$('#vendor').on('change',function(){
    var vendor = $(this).find('option:selected').val();
    $('#carModel,#carMod,#carYear').find('option').not(':first-child').remove();

     $.ajax({
   type: "POST",
   url: baseUrl+"/site/podbor-po-avto?type=model",
   data: {'vendor':vendor},
   success: function(data){
   //    var item = $.parseJSON(data);
       var cars = data.cars
    $('#carModel').replaceWith(cars)
     var carModels =  $('#carModel');
 
    carModels.parents('div.dropdown').replaceWith(carModels)
    carModels.easyDropDown();
   $('#carModel').on('change',changeCarModel);
   },
        dataType: 'json'
  
});
   
});

function changeCarModel(){
 var vendor = $('#vendor').find('option:selected').val();
    var carModel = $(this).find('option:selected').val();
    $('#carMod,#carYear').find('option').not(':first-child').remove();

     $.ajax({
   type: "POST",
   url: baseUrl+"/site/podbor-po-avto?type=mod",
   data: {'carModel':carModel,'vendor':vendor},
   success: function(data){
   //    var item = $.parseJSON(data);
       var carsMod = data.carsMod
   $('#carMod').replaceWith(carsMod);
   var carModific = $('#carMod');
   carModific.parents('div.dropdown').replaceWith(carModific)
    carModific.easyDropDown();
   $('#carMod').on('change',changeCarMod);
   },
        dataType: 'json'
  
});
}

function changeCarMod(){
 var vendor = $('#vendor').find('option:selected').val();
    var carModel = $('#carModel').find('option:selected').val();
    var carMod = $(this).find('option:selected').val();
    $('#carYear').find('option').not(':first-child').remove();

     $.ajax({
   type: "POST",
   url: baseUrl+"/site/podbor-po-avto?type=year",
   data: {'carModel':carModel,'vendor':vendor,'carMod':carMod},
   success: function(data){
   //    var item = $.parseJSON(data);
       var carsYear = data.carsYear
   $('#carYear').replaceWith(carsYear);
   var carYears = $('#carYear');
    carYears.parents('div.dropdown').replaceWith(carYears)
    carYears.easyDropDown();
   },
        dataType: 'json'
  
});
}

$('#carModel').on('change',changeCarModel);

$('#carFindButton').click(function(e){
    e.preventDefault();
    var vendor = $('#vendor').find('option:selected').val();
    var carModel = $('#carModel').find('option:selected').val();
    var carMod = $('#carMod').find('option:selected').val();
     var carYear = $('#carYear').find('option:selected').val();
     if (!vendor){
         alert ('Вы не указали Марку, Модель, Модификацию и Год выпуска автомобиля!');
     } else if (!carModel){
         alert ('Вы не указали Модель, Модификацию и Год выпуска автомобиля!');
     } else if (!carMod){
         alert ('Вы не указали Модификацию и Год выпуска автомобиля!');
     } else if (!carYear){
         alert ('Вы не указали Год выпуска автомобиля!');
     } else {
         $(this).parents('form').submit();
     }
//    console.log(e);
});

});