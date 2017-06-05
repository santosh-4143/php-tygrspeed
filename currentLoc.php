<?php
/*
 * Created on 26-Sep-2016
 *
 * Created By Moloy 
 * Page to store current Location
 * 
 */
include_once('./config/config.php'); 
?>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
 	if (navigator.geolocation) {
		      navigator.geolocation.getCurrentPosition(function(position) {
		        alert('Your Current Loc:'+position.coords.latitude+' and '+position.coords.longitude);
		        if(confirm('Do you want to store this location for current Branch')==true){
		        	$.ajax({
		        		url:'<?php echo $config['base_url']; ?>ajax/miscAjax.php',
		        		data:'action=saveLocation&lat='+position.coords.latitude+'&lng='+position.coords.longitude,
		        		success:function(data){
		        			alert(data);
		        		}
		        	});
		        }
			},function(){
				alert('No Location');
				console.log('No Location find by html5');			
			});
		} else {
	        alert('Cant fetch geo location');
			console.log('Browser Does not support html5');
	    }
 </script>