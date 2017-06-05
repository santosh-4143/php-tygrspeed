$(document).on('click', '#addDtlTab input', function(e){
	if($(this).is(':checked')){
		$('#addDtlTab input').not($(this)).removeAttr('checked');
		$('#addrid').val($(this).val());
		$('#name').val($.trim($(this).parent().siblings().eq(0).html()));
		$('#address').val($.trim($(this).parent().siblings().eq(1).find('p').html()));
		$('#dropLoc').val($.trim($(this).parent().siblings().eq(1).find('span').html()));
		$('#dlat').val($(this).attr('dlat'));
		$('#dlng').val($(this).attr('dlng'));

	}else{
		$('#addrid,#dlat,#dlng').val(0);
		$('#name,#address').val('');
	}
});
$(document).on('click', '.createCon', function(e){
	var a = $(this);
	var rd	=	$(this).attr('href').split('|||');
	e.preventDefault();
	$.ajax({
		url:baseUrl+'ajax/createContract.php',
		data:'optID='+rd[0]+'&avlID='+rd[1],
		async:false,
		success:function(response){
			if($.trim(response)!=""){   
				$('.'+a.parent().parent().attr('class')).remove();					
				//a.parent().parent().remove();
			}
		}
	});
});
setInterval(function(){ 	 
	 $.ajax({
		 url:baseUrl+'ajax/showOpenRequest.php',
		 data:'',
		 success:function(response){
			 $('#openReq tbody').html(response);
		 }
	 });
	$.ajax({
		url:baseUrl+'ajax/allStatePage.php',
		data:'',
		success:function(response){
			var responseData = JSON.parse(response);	
			$('#incomingReq tbody').html(responseData.incoming);
			$('#transitReq tbody').html(responseData.transit);
			$('#completeReq tbody').html(responseData.complete);
			$('#freeDriver tbody').html(responseData.freedriver);
			$('#openOpportunity tbody').html(responseData.pendingrequest);
		}
	});	 
}, 30000);
$(document).ready(function(){
	$.ajax({
		url:baseUrl+'ajax/showOpenRequest.php',
		data:'',
		success:function(response){
			$('#openReq tbody').html(response);
		}
	});
	$.ajax({
		url:baseUrl+'ajax/allStatePage.php',
		data:'',
		success:function(response){
			var responseData = JSON.parse(response);
			
			$('#incomingReq tbody').html(responseData.incoming);
			$('#transitReq tbody').html(responseData.transit);
			$('#completeReq tbody').html(responseData.complete);
			$('#freeDriver tbody').html(responseData.freedriver);
			$('#openOpportunity tbody').html(responseData.pendingrequest);
		}
	});
	$('#BookNow1').click(function(e){
		var dataExists		=	0;
		var tempObj			=	new Array();
		var tObj;
		var i				=	0;
		var counter			=	0;
		var geoCodeError	=	0;
		if($.trim($('#phone').val())!=""){
			$(this).html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...');
			if($.trim($('#phone').val())==""){
				if(counter==0){
					modalOpen('myModal','Please enter 10 digit mobile number.');
				}
				counter++;
			}else{
					if(isNaN($('#phone').val()) || $('#phone').val().length!=10){
						if(counter==0){
						modalOpen('myModal','Please enter 10 digit mobile number.');
						}
					counter++;			
				}
			}
			if($.trim($('#name').val())==""){
				if(counter==0){
					if(counter==0){
						modalOpen('myModal','Please enter customer name.');
					}
				}
				counter++;
			}
			if($.trim($('#address').val())==""){
				if(counter==0){
					modalOpen('myModal','Please enter customer\'s proper address.');
				}
				counter++;
			}
			if($.trim($('#dropLoc').val())==""){
				if(counter==0){
					modalOpen('myModal','Please enter delivery location.');
				}
				counter++;
			}

			if($('.payMethod:checked').length==0){
				if(counter==0){
					modalOpen('myModal','Please Choose the Mode of Payment');
				}
				counter++;
			}

			if($('.payMethod').is(':checked')){
    			if($.trim($('#amount').val())==""){
    				if(counter==0){
    					modalOpen('myModal','Please enter amount.');
    				}
    				counter++;
    			}else if($.trim($('#amount').val())==0 && $.trim($('.payMethod:checked').val())!="paid"){
    				if(counter==0){
    					modalOpen('myModal','Amount should be in greater than 0.');
    				}
    				counter++;
    			}
			}else{
				$('#amount').val(0.00);
			}
			if(counter==0){
				geocoder.geocode({'address': $.trim(document.getElementById('address').value)}, function(results, status) {
					if($('#dlat').val()>0 && $('#dlng').val()>0){			    		  
							var dist = distance(currLat,currLng,$('#dlat').val(),$('#dlng').val(),'K')*1000;
							tObj							=	{
			    													phone:$.trim($('#phone').val()),
			    													name:$.trim($('#name').val()),
			    													amount:$.trim($('#amount').val()),
			    													transacCode:$.trim($('#transacCode').val()),
			    													address:$.trim($('#address').val()),
			    													dropLoc:$.trim($('#dropLoc').val()),
			    													payMethod:$.trim($('.payMethod:checked').val()),
			    													addrID:$('#addrid').val(),
			    													dist:dist,
			    													elat:$('#dlat').val(),
			    													elng:$('#dlng').val(),
			    													slat:currLat,
						    										slng:currLng
		    													}
		    				tempObj[i]						=	tObj;
		    				i++;
		    				dataExists++;
					}else if (status === 'OK') {				    		  
						var dist = distance(currLat,currLng,results[0].geometry.location.lat(),results[0].geometry.location.lng(),'K')*1000;
						tObj							=	{
		    													phone:$.trim($('#phone').val()),
		    													name:$.trim($('#name').val()),
		    													amount:$.trim($('#amount').val()),
		    													transacCode:$.trim($('#transacCode').val()),
		    													address:$.trim($('#address').val()),
		    													dropLoc:$.trim($('#dropLoc').val()),
		    													payMethod:$.trim($('.payMethod:checked').val()),
		    													addrID:$('#addrid').val(),
		    													dist:dist,
		    													elat:results[0].geometry.location.lat(),
		    													elng:results[0].geometry.location.lng(),
		    													slat:currLat,
					    										slng:currLng
	    													}
	    				tempObj[i]						=	tObj;
	    				i++;
	    				dataExists++;
					} else {
						geoCodeError++;
						modalOpen('myModal','Geocode was not successful for the following reason: ' + status);
				    }
	    			if($('#addOrderTab tbody tr').length>1){
	    				$('#addOrderTab tbody tr').each(function( index ) {
	    					tObj						=	{
		    													phone:$.trim($(this).find('td').eq(0).html()),
		    													name:$.trim($(this).find('td').eq(1).find('p').eq(0).html()),
		    													amount:$.trim($(this).find('td').eq(1).find('p').eq(1).html()),
		    													transacCode:$.trim($(this).find('td').eq(1).find('p').eq(2).html()),
		    													address:$.trim($(this).find('td').eq(2).find('p').eq(0).html()),
		    													dropLoc:$.trim($(this).find('td').eq(2).find('p').eq(1).html()),
		    													payMethod:$.trim($(this).find('td').eq(2).find('p').eq(2).html()),
		    													dist:$.trim($(this).find('td').eq(2).find('p').eq(0).attr('dist')),
		    													addrID:$.trim($(this).find('td').eq(2).find('p').eq(0).attr('id')),
		    													elat:$.trim($(this).find('td').eq(2).find('p').eq(1).attr('lat')),
		    													elng:$.trim($(this).find('td').eq(2).find('p').eq(1).attr('lng')),
		    													slat:currLat,
					    										slng:currLng
		    												}
							tempObj[i]					=	tObj;
							i++;
							dataExists++;
						});
					}else{
						if($('#addOrderTab tbody tr').length==1){
							if($('#addOrderTab tbody tr').eq(0).find('td').length==1){
								$('#addOrderTab tbody tr').remove();
							}else{						
								if($('#addOrderTab tbody tr').eq(0).find('td').length>1){
									$('#addOrderTab tbody tr').each(function( index ) {
										tObj			=	{
					    										phone:$.trim($(this).find('td').eq(0).html()),
					    										name:$.trim($(this).find('td').eq(1).find('p').eq(0).html()),
					    										amount:$.trim($(this).find('td').eq(1).find('p').eq(1).html()),
					    										transacCode:$.trim($(this).find('td').eq(1).find('p').eq(2).html()),
					    										address:$.trim($(this).find('td').eq(2).find('p').eq(0).html()),
					    										dropLoc:$.trim($(this).find('td').eq(2).find('p').eq(1).html()),
					    										payMethod:$.trim($(this).find('td').eq(2).find('p').eq(2).html()),
					    										dist:$.trim($(this).find('td').eq(2).find('p').eq(0).attr('dist')),
					    										addrID:$.trim($(this).find('td').eq(2).find('p').eq(0).attr('id')),
		    													elat:$.trim($(this).find('td').eq(2).find('p').eq(1).attr('lat')),
		    													elng:$.trim($(this).find('td').eq(2).find('p').eq(1).attr('lng')),
					    										slat:currLat,
					    										slng:currLng
					    									}
		    							tempObj[i]		=	tObj;
		    							i++;
		    							dataExists++;
		    						});
									//alert(JSON.stringify(tempObj));
		    					}
							}
						}		
					}
	    			
					if(dataExists>0){
						$.ajax({
							url:baseUrl+'ajax/broadcastMultipleLoc.php',
							async:false,
							data:JSON.stringify(tempObj),
							method:'POST',
							success:function(data){
								//alert(data);
								if (geoCodeError==0) {
									$('#name,#phone,#address,#dropLoc,#transacCode').val('').removeAttr('readonly');
									$('#addrid,#dlat,#dlng').val(0);
									$('#amount').val('0.00');
									$('#addDtlTab').parent().slideUp().find('tbody').html('');
									$('.payMethod').removeAttr('checked');
								}
								$('#BookNow1').html('Send Order');
								$('#addOrderTab tbody tr').remove();
							}
						});
					}		    			
			    });	
			}else{
				$('#BookNow1').html('Send Order');
			}
		}else{
			$('#BookNow1').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...');
			if($('#addOrderTab tbody tr').length>1){
				$('#addOrderTab tbody tr').each(function( index ) {
					tObj						=	{
    													phone:$.trim($(this).find('td').eq(0).html()),
    													name:$.trim($(this).find('td').eq(1).find('p').eq(0).html()),
    													amount:$.trim($(this).find('td').eq(1).find('p').eq(1).html()),
    													transacCode:$.trim($(this).find('td').eq(1).find('p').eq(2).html()),
    													address:$.trim($(this).find('td').eq(2).find('p').eq(0).html()),
    													dropLoc:$.trim($(this).find('td').eq(2).find('p').eq(1).html()),
    													payMethod:$.trim($(this).find('td').eq(2).find('p').eq(2).html()),
    													dist:$.trim($(this).find('td').eq(2).find('p').eq(0).attr('dist')),
    													addrID:$.trim($(this).find('td').eq(2).find('p').eq(0).attr('id')),
    													elat:$.trim($(this).find('td').eq(2).find('p').eq(1).attr('lat')),
    													elng:$.trim($(this).find('td').eq(2).find('p').eq(1).attr('lng')),
    													slat:currLat,
			    										slng:currLng
    												}
					tempObj[i]					=	tObj;
					i++;
					dataExists++;
				});
			}else{
				if($('#addOrderTab tbody tr').length==1){
					if($('#addOrderTab tbody tr').eq(0).find('td').length==1){
						$('#addOrderTab tbody tr').remove();
					}else{						
						if($('#addOrderTab tbody tr').eq(0).find('td').length>1){
							$('#addOrderTab tbody tr').each(function( index ) {
								tObj			=	{
			    										phone:$.trim($(this).find('td').eq(0).html()),
			    										name:$.trim($(this).find('td').eq(1).find('p').eq(0).html()),
			    										amount:$.trim($(this).find('td').eq(1).find('p').eq(1).html()),
			    										transacCode:$.trim($(this).find('td').eq(1).find('p').eq(2).html()),
			    										address:$.trim($(this).find('td').eq(2).find('p').eq(0).html()),
			    										dropLoc:$.trim($(this).find('td').eq(2).find('p').eq(1).html()),
			    										payMethod:$.trim($(this).find('td').eq(2).find('p').eq(2).html()),
			    										dist:$.trim($(this).find('td').eq(2).find('p').eq(0).attr('dist')),
			    										addrID:$.trim($(this).find('td').eq(2).find('p').eq(0).attr('id')),
    													elat:$.trim($(this).find('td').eq(2).find('p').eq(1).attr('lat')),
    													elng:$.trim($(this).find('td').eq(2).find('p').eq(1).attr('lng')),
			    										slat:currLat,
			    										slng:currLng
			    									}
    							tempObj[i]		=	tObj;
    							i++;
    							dataExists++;
    						});
    					}
					}
				}		
			}
			if(dataExists>0){
				$.ajax({
					url:baseUrl+'ajax/broadcastMultipleLoc.php',
					data:JSON.stringify(tempObj),
					method:'POST',
					success:function(data){
						//alert(data);
						$('#name,#phone,#address,#dropLoc,#transacCode').val('').removeAttr('readonly');
						$('#addrid').val('0');
						$('#amount').val('0.00');
						$('#addDtlTab').parent().slideUp().find('tbody').html('');
						$('.payMethod').removeAttr('checked');
						$('#addOrderTab tbody tr').remove();
						$('#BookNow1').html('Send Order');
					}
				});
				//alert(JSON.stringify(tempObj));
			}else{
				$('#BookNow1').html('Send Order');
			}
		}		
	});
	$('#phone').keyup(function(){
		if($.trim($(this).val()).length==10){
			$.ajax({
				url:baseUrl+"ajax/customerContact.php?action=getAddrByPh&phone="+$.trim($(this).val()),
				success:function(data){
					$('#addDtlTab tbody').html(data);
					$('#addDtlTab').parent().slideDown();
				}
			});
		}else{
			$('#addDtlTab').parent().slideUp();
		}
	});
    $( "#phone" ).autocomplete({
			source: baseUrl+"ajax/customerContact.php?action=getPhone",
		select: function( event, ui ) {
			$.ajax({
				url:baseUrl+"ajax/customerContact.php?action=getAddrByPh&phone="+$.trim(ui.item.value),
				success:function(data){
					$('#addDtlTab tbody').html(data);
					$('#addDtlTab').parent().slideDown();
				}
			});
		}
	});
	$('.payMethod').click(function(e){
		if($(this).is(':checked')){
			$('.payMethod').not($(this)).removeAttr('checked');
			if($(this).val()=="cod" || $(this).val()=="cc"){
				$('#codVal').slideDown();
				$('#amount').focus();	
			}
			// else if($(this).val()=="paid"){
			// 	$('#codVal').slideUp();
			// 	$('#amount').val('N/A');
			// }
			else{
				$('#amount').val('0.00');
				$('#codVal').slideUp();
			}    				
		}else{
			$('#amount').val('0.00');
			$('#codVal').slideUp();
		}
	});
	$('#addOrder').click(function(e){
		var counter	=	0;
		if($.trim($('#phone').val())==""){
			if(counter==0){
				modalOpen('myModal','Please enter 10 digit mobile number.');
			}
			counter++;
		}else{
				if(isNaN($('#phone').val()) || $('#phone').val().length!=10){
					if(counter==0){
					modalOpen('myModal','Please enter 10 digit mobile number.');
					}
				counter++;			
			}
		}
		if($.trim($('#name').val())==""){
			if(counter==0){
				if(counter==0){
					modalOpen('myModal','Please enter customer name.');
				}
			}
			counter++;
		}
		if($.trim($('#address').val())==""){
			if(counter==0){
				modalOpen('myModal','Please enter customer\'s proper address.');
			}
			counter++;
		}
		if($.trim($('#dropLoc').val())==""){
			if(counter==0){
				modalOpen('myModal','Please enter delivery location.');
			}
			counter++;
		}

		if($('.payMethod:checked').length==0){
			if(counter==0){
				modalOpen('myModal','Please Choose the Mode of Payment');
			}
			counter++;
		}

		if($('.payMethod').is(':checked')){
			if($.trim($('#amount').val())==""){
				if(counter==0){
					modalOpen('myModal','Please enter amount.');
				}
				counter++;
			}else if($.trim($('#amount').val())==0 && $.trim($('.payMethod:checked').val())!="paid"){
				if(counter==0){
					modalOpen('myModal','Amount should be in greater than 0.');
				}
				counter++;
			}
		}else{
			$('#amount').val(0.00);
		}
		if(counter==0){
			var tempHtml	=	"";
			if($('#dlat').val()>0 && $('#dlng').val()>0){
				var dist = distance(currLat,currLng,$('#dlat').val(),$('#dlng').val(),'K')*1000;
				tempHtml		+=	'<tr>';
				tempHtml		+=	'<td>'+$.trim($('#phone').val())+'</td>';
				tempHtml		+=	'<td><p>'+$.trim($('#name').val())+'</p><p style="display:none;">'+$.trim($('#amount').val())+'</p><p style="display:none;">'+$.trim($('#transacCode').val())+'</p></td>';
				tempHtml		+=	'<td><p id="'+$('#addrid').val()+'" dist="'+dist+'">'+$.trim($('#address').val())+'</p><p lat="'+$('#dlat').val()+'" lng="'+$('#dlng').val()+'">'+$.trim($('#dropLoc').val())+'</p><p style="display:none;">'+$('.payMethod:checked').val()+'</p></td>';
				tempHtml		+=	'</tr>';				    		  
				 
				if($('#addOrderTab tbody tr').length>1){
					$('#addOrderTab tbody').append(tempHtml); 				
				}else{
					if($('#addOrderTab tbody tr').length==0){
						$('#addOrderTab tbody').html(tempHtml);
					}else{
						if($('#addOrderTab tbody tr').eq(0).find('td').length==1){
							$('#addOrderTab tbody tr').remove();
							$('#addOrderTab tbody').html(tempHtml);
						}else{
							$('#addOrderTab tbody').append(tempHtml);
						}
					}
				}
				$('#name,#phone,#address,#dropLoc,#transacCode').val('').removeAttr('readonly');
				$('#addrid,#dlat,#dlng').val('0');
				$('#amount').val('0.00');
				$('#addDtlTab').parent().slideUp().find('tbody').html('');
				$('.payMethod').removeAttr('checked');
			}else{
				geocoder.geocode({'address': $.trim(document.getElementById('address').value)}, function(results, status) {
			      if (status === 'OK') {				    		  
		    		  var dist = distance(currLat,currLng,results[0].geometry.location.lat(),results[0].geometry.location.lng(),'K')*1000;
		    		  tempHtml		+=	'<tr>';
					  tempHtml		+=	'<td>'+$.trim($('#phone').val())+'</td>';
	    			  tempHtml		+=	'<td><p>'+$.trim($('#name').val())+'</p><p style="display:none;">'+$.trim($('#amount').val())+'</p><p style="display:none;">'+$.trim($('#transacCode').val())+'</p></td>';
	    		      tempHtml		+=	'<td><p id="'+$('#addrid').val()+'" dist="'+dist+'">'+$.trim($('#address').val())+'</p><p lat="'+results[0].geometry.location.lat()+'" lng="'+results[0].geometry.location.lng()+'">'+$.trim($('#dropLoc').val())+'</p><p style="display:none;">'+$('.payMethod:checked').val()+'</p></td>';
	    			  tempHtml		+=	'</tr>';				    		  
			    	  
			    	  if($('#addOrderTab tbody tr').length>1){
	    				   $('#addOrderTab tbody').append(tempHtml); 				
		    			}else{
		    				if($('#addOrderTab tbody tr').length==0){
		    					$('#addOrderTab tbody').html(tempHtml);
		    				}else{
		    					if($('#addOrderTab tbody tr').eq(0).find('td').length==1){
		    						$('#addOrderTab tbody tr').remove();
		    						$('#addOrderTab tbody').html(tempHtml);
		    					}else{
		    						 $('#addOrderTab tbody').append(tempHtml);
		    					}
		    				}
		    			}
		    			$('#name,#phone,#address,#dropLoc,#transacCode').val('').removeAttr('readonly');
		    			$('#addrid,#dlat,#dlng').val('0');
						$('#amount').val('0.00');
						$('#addDtlTab').parent().slideUp().find('tbody').html('');
						$('.payMethod').removeAttr('checked');
			      } else {
			        alert('Geocode was not successful for the following reason: ' + status);
			      }
			    });
			}
		}
	});
});
function modalOpen(ModalID='myModal',content){
	jQuery.noConflict(); 
	$('#'+ModalID+' p').html(content);
	$("#"+ModalID).modal('show');
}
function initAutocomplete(){
	autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('dropLoc')),
        {types: ['geocode']});
	google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        //alert(place.geometry.location.lat());
        //alert(place.geometry.location.lng());
        $('#dlat').val(place.geometry.location.lat());
        $('#dlng').val(place.geometry.location.lng());
    });
	geocoder = new google.maps.Geocoder();
}

function distance(lat1, lon1, lat2, lon2, unit) {
	var radlat1 = Math.PI * lat1/180
	var radlat2 = Math.PI * lat2/180
	var theta = lon1-lon2
	var radtheta = Math.PI * theta/180
	var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
	dist = Math.acos(dist);
	dist = dist * 180/Math.PI;
	dist = dist * 60 * 1.1515;
	if (unit=="K") { dist = dist * 1.609344 }
	if (unit=="N") { dist = dist * 0.8684 }
	return dist
}
function fillInAddress() {
  	// Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
	//alert(place);
}    	