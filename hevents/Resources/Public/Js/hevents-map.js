hevents.extend({
	map: {
		datas: [],
		bounds: new google.maps.LatLngBounds (),
		
		each: function(callback){
			var length = this.datas.length,i=0;
			for ( ; i < length; ) {
				if ( callback.call( this.datas[i], i, this.datas[i++] ) === false ) {
					break;
				}
			}
		},
		
		newMarker: function(lat, lng, options){
			options.position = new google.maps.LatLng(lat,lng);
			this.bounds.extend(options.position);
			return new google.maps.Marker(options);
		},
		
		newInfoWindow: function(cont, width){
			return new google.maps.InfoWindow({
				content: cont,
				maxWidth: width
			});
		},
		
		newItem: function(id, map, lat, lng, icon, title, cont, width){
			
			var markerOptions = {
				map: map,
				title: title
			}
			if(icon!='') markerOptions.icon = icon;
			
			this.datas[id] = {};
			this.datas[id].marker = this.newMarker(lat, lng, markerOptions);
			this.datas[id].window = this.newInfoWindow(cont, width);
			google.maps.event.addListener(this.datas[id].marker, 'click', function() { 
				hevents.map.each(function(index,object){
					object.window.close();
				}); 
				hevents.map.datas[id].window.open(map, hevents.map.datas[id].marker); 
			});
		}
	}
});