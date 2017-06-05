<?php
/*
 * Created on 30-Sep-2016
 *
 * Created By Moloy 
 * Home page of Tyger Speed
 */
 include_once('./config/config.php');
 include_once('./config/function.php');
 include_once('./config/database.php');
 loginCheck($config);
 include_once('./config/query.php');
 $dashBoardData				=	loginUserDetails($conn);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">    
	<meta name="viewport" content="width=device-width, initial-scale=1">  
	<title>Home Page - Tygrspeed</title>  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	  	<style>
  		html{
  			margin:0px;
  			padding:0px;
  		}
  		.branch_desc{
    		font-weight:bold;
        }
        .branch_desc span {
        	font-weight:normal;
        }
        .right-log-panel{
			float:right; 
			margin-right:20px;
			margin-top:5px;
		}
		.right-log-panel a {
			text-decoration:none;
			color:#695A37;
		}
		.right-log-panel a:hover{
			color:#90805C;
		}	     
  	</style>
  	
  </head>
  <body>
   
	<div class="container-fluid">
  		 <div class="row page-header" style="background:#F0EDE5;margin-top:0px;padding-top:0px;">
  			<div class="col-md-8">
  				<ul class="list-inline">
				    <li>
				    	<a title="<?php echo $_SESSION['BRANCHNAME'];?>" href="dashboard.php" rel="home">
        					<img src="<?php echo $config['base_url']; ?>img/tygr_speed.png" style="max-width:60px;float:left;">
         					<img src="<?php echo $config['base_url']; ?>uploads/<?php echo $dashBoardData['logo_path']; ?>" style="max-width:60px;float:left;">
    					</a>
    				</li>
				    <li  class="branch_desc">
				    	<span>Welcome <?php echo $_SESSION['USERNAME'];?>,<br><br></span>
    					<?php echo $_SESSION['BRANCHNAME'];?>
    					<p><?php echo $dashBoardData['branch_address']; ?></p>
    				</li>
  				</ul>
  			</div>
  			<div class="col-md-4">
  				<div class="row">
	  				<ul class="list-inline right-log-panel">
					    <li style="border-right:1px solid #000;" class="glyphicon glyphicon-home">&nbsp;<a href="home.php">Home</a></li>
					    <li style="border-right:1px solid #000;" class="glyphicon glyphicon-list">&nbsp;<a href="allContract.php" >Completed Trips</a></li>
					    <li class="glyphicon glyphicon-off"><a href="logout.php" >&nbsp;Logout</a></li>
	  				</ul>
  				</div>
  			</div>
		</div>
		<div class="row">
			<div class="col-md-8 embed-responsive embed-responsive-16by9">
				<iframe class="embed-responsive-item" src="<?php echo $config['base_url']; ?>gmap.php" id="gmp"></iframe>
			</div>
			<div class="col-md-4" style="max-height:900px; overflow:scroll;">			
				<div class="panel-group">
				<div class="panel panel-info">
				  	<div class="panel-heading" data-toggle="collapse" data-target="#collapse1" style="cursor:pointer;">
				  		<h4 class="panel-title">Map Legend</h4> [Click here to expand]
				  	</div>
				  	 <div id="collapse1" class="panel-collapse collapse">
					    <div class="panel-body" >
					    	<ul class="list-inline">
					    		<li><img src="<?php echo $config['base_url'];?>img/free_driver_16.png">Free Drivers</li>
					    		<li><img src="<?php echo $config['base_url'];?>img/incoming_driver_16.png">Incoming Drivers</li>
					    		<li><img src="<?php echo $config['base_url'];?>img/opportunity_16.png">Request Location</li>
					    		<li>Intransit trips drivers and locations are in random color.</li>
					    	</ul>
					    </div>
					  </div>
				  </div>
				  <div class="panel panel-default">
				  	<div class="panel-heading"><h4 class="panel-title">Free Drivers</h4></div>
				    <div class="panel-body table-responsive">
					    <table id="freeDriver" class="table">
	       					<thead>
	       						<tr><th>Driver</th><th>Car</th><th>Phone</th></tr>
	       					</thead>
	       					<tbody>
	       	
	       					</tbody>
	       				</table>
				    </div>
				  </div>
				  <div class="panel panel-default">
				  	<div class="panel-heading"><h4 class="panel-title">Opportunity yet to be Accepted</h4></div>
				    <div class="panel-body table-responsive">
				    	<table id="openOpportunity" class="table">
					       <thead>
					       	<tr><th>Opportunity ID</th><th>Destination</th><th>Time</th></tr>
					       	</thead>
					       	<tbody>
					       	
					       	</tbody>
					   </table>
				    </div>
				  </div>
				  <div class="panel panel-default">
				  	<div class="panel-heading"><h4 class="panel-title">Accepted By Driver</h4></div>
				    <div class="panel-body table-responsive">
				    	<table id="openReq" class="table">
					       <thead>
					       	<tr><th>Driver</th><th>Car</th><th>Deliver Location</th><th>Time</th></tr>
					       </thead>
					       	<tbody>       	
					       	</tbody>
					   </table>
				    </div>
				  </div>
				  <div class="panel panel-default">
				  	<div class="panel-heading"><h4 class="panel-title">Incoimg Driver</h4></div>
				    <div class="panel-body table-responsive">
				    	<table id="incomingReq" class="table">
					       <thead>
					       	<tr><th>Driver</th><th>Car</th><th>Deliver Location</th><th>Time</th></tr>
					       </thead>
					       <tbody>       	
					       </tbody>
					    </table>
					</div>
				  </div>
				  <div class="panel panel-default">
				  	<div class="panel-heading"><h4 class="panel-title">Intransit</h4></div>
				    <div class="panel-body table-responsive">
				    	<table class="table" id="transitReq">
				       	<thead>
				       		<tr><th>Driver</th><th>Car</th><th>Deliver Location</th><th>Time</th></tr>
				       	</thead>
				       	<tbody>       	
				       	</tbody>
				       </table>
					</div>
				  </div>
				  <div class="panel panel-default">
				  	<div class="panel-heading"><h4 class="panel-title">Completed Contract</h4></div>
				    <div class="panel-body table-responsive">
					    <table class="table" id="completeReq">
					       <thead>
					       	<tr><th>Driver</th><th>Car</th><th>Deliver Location</th><th>Time</th></tr>
					       	</thead>
					       	<tbody>       	
					       	</tbody>
					     </table>
					</div>
				  </div>
				</div>
			</div>
		</div>
	</div>
	<script>
    	$(document).ready(function(){
    		$.ajax({
    			url:'<?php echo $config['base_url']; ?>ajax/showOpenRequest.php',
    			data:'',
    			success:function(response){
    				$('#openReq tbody').html(response);
    				//alert(response);
    			}
    		});
    		$.ajax({
    			url:'<?php echo $config['base_url']; ?>ajax/allStatePage.php',
    			data:'',
    			success:function(response){
    				var responseData = JSON.parse(response);
    				
    				$('#incomingReq tbody').html(responseData.incoming);
    				$('#transitReq tbody').html(responseData.transit);
    				$('#completeReq tbody').html(responseData.complete);
    				$('#freeDriver tbody').html(responseData.freedriver);
    				$('#openOpportunity tbody').html(responseData.pendingrequest);
    				//alert(response);
    			}
    		});
    		//alert("#"+((1<<24)*Math.random()|0).toString(16));
    		setInterval(function(){ 
    			 $('#gmp').attr('src','<?php echo $config['base_url']; ?>gmap.php');
    			 
    			 $.ajax({
    			url:'<?php echo $config['base_url']; ?>ajax/showOpenRequest.php',
    			data:'',
    			success:function(response){
    				$('#openReq tbody').html(response);
    				//alert(response);
    			}
    		});
    		$.ajax({
    			url:'<?php echo $config['base_url']; ?>ajax/allStatePage.php',
    			data:'',
    			success:function(response){
    				var responseData = JSON.parse(response);
    				
    				$('#incomingReq tbody').html(responseData.incoming);
    				$('#transitReq tbody').html(responseData.transit);
    				$('#completeReq tbody').html(responseData.complete);
    				$('#freeDriver tbody').html(responseData.freedriver);
					$('#openOpportunity tbody').html(responseData.pendingrequest);
    				//alert(response);
    			}
    		});
    			 
    			 
    		}, 30000);
    	});
    	$(document).on('click', '.createCon', function(e){
    		var a = $(this);
    		var rd	=	$(this).attr('href').split('|||');
    		e.preventDefault();
    		$.ajax({
    			url:'<?php echo $config['base_url']; ?>ajax/createContract.php',
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
    </script>
  </body>
</html>