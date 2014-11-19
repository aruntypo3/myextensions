// Google Map
$(document).ready( function(){
	function initialize() {
        var mapCanvas = document.getElementById('map_canvas');
        var myLatlng = new google.maps.LatLng( latitude, longitude );
        var mapOptions = {
          center: myLatlng,
          zoom: 7,
          mapTypeId: google.maps.MapTypeId.ROADMAP
    	}
	    var map = new google.maps.Map(mapCanvas, mapOptions);
	    var marker = new google.maps.Marker({
		     position: myLatlng,
		     map: map,
		     draggable: false
  		});
    }
    google.maps.event.addDomListener(window, 'resize', initialize);
    google.maps.event.addDomListener(window, 'load', initialize);	
});