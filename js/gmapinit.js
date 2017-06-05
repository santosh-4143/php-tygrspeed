function initMap() {    
	//alert('Google Maps API version: ' + google.maps.version);
	if($.trim(currLat)!="" && $.trim(currLng)!=""){
		var myLatlng = new google.maps.LatLng($.trim(currLat),$.trim(currLng));
	}else{
		var myLatlng = new google.maps.LatLng(22.5768942,88.4345064);
	}
	
	var mapOptions = {
	  zoom: 13,
	  center: myLatlng,
	  mapTypeId:'roadmap'
	}
	map = new google.maps.Map(document.getElementById("map"), mapOptions);
	//infoWindow = new google.maps.InfoWindow({map: map});
	bounds = new google.maps.LatLngBounds();
	geocoder = new google.maps.Geocoder();
	findDriverLocation();	
	findTripDetails();
	findRequestLocation();
}
function findRequestLocation(){
	$.ajax({
		url: base_url+'ajax/findRequestLocation.php',
		data:'',
		success:function(data){
			if($.trim(data)!=""){
				var rData	=	JSON.parse(data);
				$(rData.pendingrequest).each(function(i,item){
					addMarkerCircle(item.lat, item.lng, '<b>Opportunity ID:</b>'+item.id+'<br><b>Destination:</b>'+item.loc,'#800080');
				});
			}
		}
	});
}

function findDriverLocation(){
	//alert(currLat+'-------------------------'+currLng);
	if($.trim(currLat)=="" && $.trim(currLng)==""){
		if (navigator.geolocation) {
		      navigator.geolocation.getCurrentPosition(function(position) {
		       /* var pos = {
		          lat: position.coords.latitude,
		          lng: position.coords.longitude
		        };
	
	
		        infoWindow.setPosition(pos);
		        infoWindow.setContent('Your Current Location. lat='+position.coords.latitude+' and Lng='+position.coords.longitude);
		        map.setCenter(pos);*/
		        if(currLat=="")
		        currLat = position.coords.latitude;
		        if(currLng=="")
		        currLng = position.coords.longitude;
			},function(){
				//alert('No Location');
				//console.log('No Location find by html5');			
			});
		} else {
	        //alert('Cant fetch geo location');
			//console.log('Browser Does not support html5');
	    }
	}
	var pos = new google.maps.LatLng($.trim(currLat),$.trim(currLng));
	var icon = new google.maps.MarkerImage(logImg,
			 new google.maps.Size(50, 50), new google.maps.Point(0, 0),
			 new google.maps.Point(0, 0));
	 bounds.extend(pos);
	   var marker = new google.maps.Marker({
	   position: pos,
	   icon:icon,
	   map: map
	   });
  //infoWindow.setPosition(pos);
  //infoWindow.setContent('Your Current Location. lat='+currLat+' and Lng='+currLng);
  map.setCenter(pos);
 
  
	$.ajax({
		url: base_url+'ajax/findDriverLocation.php',
		data:'lat='+currLat+'&lng='+currLng,
		success:function(data){
			//alert(data);
			//console.log(data);
			if($.trim(data)!=""){
				var freeDriverData	=	JSON.parse(data);
				$(freeDriverData).each(function(i,item){
					//alert(item.toSource());
					
					addMarker(item.lat, item.lng, '<b>Driver:</b>'+item.name+'<br><b>Car:</b>'+item.car+'<br><b>Phone:</b>+'+item.phone);
				});
				//alert(freeDriverData[0].lat);
			}
		}
	});
}
function addMarker(lat, lng, info) {
	 /* var icon = new google.maps.MarkerImage("http://115.124.98.156/tygradmin/tygr_cars/byke_black.png",
	 new google.maps.Size(100, 100), new google.maps.Point(0, 0),
	 new google.maps.Point(0, 0));*/ 
	 
	   var pt = new google.maps.LatLng(lat, lng);
	   bounds.extend(pt);
	   var marker = new google.maps.Marker({
	   position: pt,
	   icon:{
	        path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
	              strokeColor: '#4169E1',
	              scale: 5
	          },
	   map: map
	   });
	   var popup = new google.maps.InfoWindow({
	   content: info,
	   maxWidth: 300,
	   height:200,
	   });
	   google.maps.event.addListener(marker, "click", function() {
	   if (currentPopup != null) {
	   currentPopup.close();
	   currentPopup = null;
	   }
	   popup.open(map, marker);
	   currentPopup = popup;
	   });
	   google.maps.event.addListener(popup, "closeclick", function() {
	  
	   });
	 }
function addMarkerCircle(lat, lng, info,rdcolor) {
	 /* var icon = new google.maps.MarkerImage("http://115.124.98.156/tygradmin/tygr_cars/byke_black.png",
	 new google.maps.Size(100, 100), new google.maps.Point(0, 0),
	 new google.maps.Point(0, 0));*/ 
	 
	   var pt = new google.maps.LatLng(lat, lng);
	   bounds.extend(pt);
	   var marker = new google.maps.Marker({
	   position: pt,
	   icon:{
	        path: google.maps.SymbolPath.CIRCLE,
	              strokeColor: rdcolor,
	              scale: 10
	          },
	   map: map
	   });
	   var popup = new google.maps.InfoWindow({
	   content: info,
	   maxWidth: 300,
	   height:200,
	   });
	   google.maps.event.addListener(marker, "click", function() {
	   if (currentPopup != null) {
	   currentPopup.close();
	   currentPopup = null;
	   }
	   popup.open(map, marker);
	   currentPopup = popup;
	   });
	   google.maps.event.addListener(popup, "closeclick", function() {
	  
	   });
	 }
function addMarkerArrow(lat, lng, info,rdcolor) {
	 /* var icon = new google.maps.MarkerImage("http://115.124.98.156/tygradmin/tygr_cars/byke_black.png",
	 new google.maps.Size(100, 100), new google.maps.Point(0, 0),
	 new google.maps.Point(0, 0));*/ 
	 
	   var pt = new google.maps.LatLng(lat, lng);
	   bounds.extend(pt);
	   var marker = new google.maps.Marker({
	   position: pt,
	   icon:{
	        path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
	              strokeColor: rdcolor,
	              scale: 5
	          },
	   map: map
	   });
	   var popup = new google.maps.InfoWindow({
	   content: info,
	   maxWidth: 300,
	   height:200,
	   });
	   google.maps.event.addListener(marker, "click", function() {
	   if (currentPopup != null) {
	   currentPopup.close();
	   currentPopup = null;
	   }
	   popup.open(map, marker);
	   currentPopup = popup;
	   });
	   google.maps.event.addListener(popup, "closeclick", function() {
	  
	   });
	 }

function findTripDetails(){
	$.ajax({
		url:'ajax/findTripDetails.php',
		data:'',
		success:function(response){
			
			
			if($.trim(response)!=""){
			var randomColor = "#"+((1<<24)*Math.random()|0).toString(16);
			//console.log(randomColor);
			var responseData = JSON.parse(response);
			if(responseData.transit.length>0){
				for(var i=0;i<responseData.transit.length;i++){
					randomColor = "#"+((1<<24)*Math.random()|0).toString(16);
					 addMarkerCircle(responseData.transit[i].dest_lat, responseData.transit[i].dest_lng, "<strong>Destination:</strong>"+responseData.transit[i].dest,randomColor);
					 addMarkerArrow(responseData.transit[i].driver_lat, responseData.transit[i].driver_lng, '<strong>Driver:</strong>'+responseData.transit[i].driver+'<br><strong>Car:</strong>'+responseData.transit[i].car+'<br> <strong>Phone:</strong>'+responseData.transit[i].phone,randomColor);
				}
			}
			if(responseData.incoming.length>0){
				for(var i=0;i<responseData.incoming.length;i++){
					randomColor = "#ffc04c";
					addMarkerCircle(responseData.incoming[i].dest_lat, responseData.incoming[i].dest_lng, "<strong>Destination:</strong>"+responseData.incoming[i].dest,'#008000');
					addMarkerArrow(responseData.incoming[i].driver_lat, responseData.incoming[i].driver_lng, '<strong>Driver:</strong>'+responseData.incoming[i].driver+'<br><strong>Car:</strong>'+responseData.incoming[i].car+'<br> <strong>Phone:</strong>'+responseData.incoming[i].phone,'#008000');
				}
			}
			
			}
		}
	});
}
