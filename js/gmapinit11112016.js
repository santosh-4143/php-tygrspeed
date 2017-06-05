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
	infoWindow = new google.maps.InfoWindow({map: map});
	bounds = new google.maps.LatLngBounds();
	geocoder = new google.maps.Geocoder();
	searchBox();
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
				console.log('No Location find by html5');			
			});
		} else {
	        //alert('Cant fetch geo location');
			console.log('Browser Does not support html5');
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
  infoWindow.setPosition(pos);
  infoWindow.setContent('Your Current Location. lat='+currLat+' and Lng='+currLng);
  map.setCenter(pos);
 
  
	$.ajax({
		url: base_url+'ajax/findDriverLocation.php',
		data:'lat='+currLat+'&lng='+currLng,
		async:false,
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
function searchBox(){
	
	// Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	
	
	
	
	// Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

   


    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
    	if(confirm("Send out the order?")==true){
    		var places = searchBox.getPlaces();
    		//console.log("places "+places.name);
    		if (places.length == 0) {
    			alert("Enter Valid Delivery Destination!");
    			return;
    		}
    		//console.log(places.toSource());
    		geocodeAddress(document.getElementById('pac-input').value);

    		// For each place, get the icon, name and location.
    		

    	 /*	searchBox.getPlaces().forEach(function(place) {
    			if (!place.geometry) {
    				console.log("Returned place contains no geometry");
    				return;
    			}        
    			var random=Math.floor(Math.random()*10);
    			if (random>=8){random=random-2;}
    			// Create a marker for each place.
		        var marker =new google.maps.Marker({
		          map: map,
		          title: place.name,
		          animation:google.maps.Animation.BOUNCE,
		          position: place.geometry.location
		        });
		       // alert(Object.keys(place.geometry.location).map(k => place.geometry.location[k]).toSource());
		       // alert(place.geometry.location());
		      
		        if (place.geometry.viewport) {
		          // Only geocodes have viewport.
		        	bounds.union(place.geometry.viewport);
		        	return;
		        } else {
		        	bounds.extend(place.geometry.location);
		        	return;
		        }
    		});
    		map.fitBounds(bounds);*/

    	}//end of if(confirm...)

    });
}
function geocodeAddress(address) {
    geocoder.geocode({'address': address}, function(results, status) {
      if (status === 'OK') {
       /* map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
          map: map,
          icon: {
         	 path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
         	 strokeColor: '#008000',
         	 scale: 5
          },
          position: results[0].geometry.location
        });*/
        //alert('lat'+results[0].geometry.location.lat()+'........'+results[0].geometry.location.lng());
    	  var fullAddress	=	document.getElementById('pac-input1').value;
    	  var phone	=	document.getElementById('pac-input2').value;
    	  if($.trim(fullAddress)!="" && $.trim(phone)!=""){
    		  if($.trim(phone).length==10 && !isNaN(phone)){
    			  //alert(fullAddress+phone);
	    		  var dist = distance(currLat,currLng,results[0].geometry.location.lat(),results[0].geometry.location.lng(),'K')*1000;
	    		  var response= broadcadToDriver(dist,currLat,currLng,results[0].geometry.location.lat(),results[0].geometry.location.lng(),address,fullAddress,phone);
	    		  var rd = JSON.parse(response);
	    		  $('pac-input').val('');
	    		  $('pac-input1').val('');
	    		  $('pac-input2').val('');
    		  }else{
    			  alert('Phone number should be in 10 digit number.');
    		  }
    	  }else{
    		  alert('Please enter customer mailing address and phone number.');  
    	  }        
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }
function distance(lat1, lon1, lat2, lon2, unit) {
	var radlat1 = Math.PI * lat1/180
	var radlat2 = Math.PI * lat2/180
	var theta = lon1-lon2
	var radtheta = Math.PI * theta/180
	var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
	dist = Math.acos(dist)
	dist = dist * 180/Math.PI
	dist = dist * 60 * 1.1515
	if (unit=="K") { dist = dist * 1.609344 }
	if (unit=="N") { dist = dist * 0.8684 }
	return dist
}
function broadcadToDriver(dist,currLat,currLng,toLat,toLng,toLoc,fullAddress,Phone){
	var response='';
	$.ajax({
		url:'ajax/broadcastToDriver.php',
		async:false,
		data:'dist='+dist+'&toloc='+toLoc+'&slat='+currLat+'&slng='+currLng+'&elat='+toLat+'&elng='+toLng+'&addr='+fullAddress+'&phone='+Phone,
		success:function(data){
			response = data;
		}
	});
	return response;
}
function findTripDetails(){
	$.ajax({
		url:'ajax/findTripDetails.php',
		data:'',
		success:function(response){
			
			
			if($.trim(response)!=""){
			var randomColor = "#"+((1<<24)*Math.random()|0).toString(16);
			console.log(randomColor);
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