<?php ?>
																				 
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript">
 var geocoder;
 var map;
 var address ="ул. Ленинградская 59 Днепропетровск  49000";
 function JM_GMstartup() {
   geocoder = new google.maps.Geocoder();
   var latlng = new google.maps.LatLng(-34.397, 150.644);
   var myOptions = {
      zoom: 12,
     center: latlng,
  mapTypeControl:  false,mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
     mapTypeId: google.maps.MapTypeId.ROADMAP
   };
   
    map = new google.maps.Map(document.getElementById("s5_map_canvas"), myOptions);
    if (geocoder) {
      geocoder.geocode( { 'address': address}, function(results, status) {
       if (status == google.maps.GeocoderStatus.OK) {
         if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
map.setCenter(results[0].geometry.location);
            var infowindow = new google.maps.InfoWindow(
                { content: '&lt;span class="s5_googlemapaddress" style="font-family:arial;font-size:11px;"&gt;'+address+' &lt;br/&gt;&lt;br/&gt;&lt;a href="http://maps.google.com/maps?saddr=&amp;daddr='+address+'" target ="_blank" style="padding:2px 5px 2px 5px;" class="button"&gt;Проложить маршрут&lt;\/a&gt;&lt;/span&gt;',
                  size: new google.maps.Size(150,50) }
				  );
				  
			var image = new google.maps.MarkerImage(' http://razrabotkakmd.com//modules/mod_S5MapIt/images/tack.png',
			  // This marker is 20 pixels wide by 32 pixels tall.
			  new google.maps.Size(48, 48),
			  // The origin for this image is 0,0.
			  new google.maps.Point(0,0),
			  // The anchor for this image is the base of the flagpole at 0,32.
			  new google.maps.Point(10, 40));
			  
			  
            var marker = new google.maps.Marker({
                position: results[0].geometry.location,
				icon: image,
                map: map, 
                title:address }); 
					
				google.maps.event.addListener(marker, 'click', function() { 
			
                infowindow.open(map,marker); 
			

				}); 
          } else { alert("No results found"); } 
        } else { alert("Geocode was not successful for the following reason: " + status);}  });   }  }       	    

	function jm_mapload() {JM_GMstartup();} 
	window.setTimeout(jm_mapload,100);
</script> 


<div id="s5_map_canvas" class="s5_mapdisplay" style="width:960px;height:300px"></div>