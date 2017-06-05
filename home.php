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
  	  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  	
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
		.unit { position: absolute; display: block; left: 19px; top: 7px; z-index: 9; }	 
		.ui-autocomplete {
		    position: absolute;
		    top: 100%;
		    left: 0;
		    z-index: 1000;
		    float: left;
		    display: none;
		    min-width: 160px;   
		    padding: 4px 0;
		    margin: 0 0 10px 25px;
		    list-style: none;
		    background-color: #ffffff;
		    border-color: #ccc;
		    border-color: rgba(0, 0, 0, 0.2);
		    border-style: solid;
		    border-width: 1px;
		    -webkit-border-radius: 5px;
		    -moz-border-radius: 5px;
		    border-radius: 5px;
		    -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
		    -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
		    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
		    -webkit-background-clip: padding-box;
		    -moz-background-clip: padding;
		    background-clip: padding-box;
		    *border-right-width: 2px;
		    *border-bottom-width: 2px;
		}
		.ui-menu-item > a.ui-corner-all {
		    display: block;
		    padding: 3px 15px;
		    clear: both;
		    font-weight: normal;
		    line-height: 18px;
		    color: #555555;
		    white-space: nowrap;
		    text-decoration: none;
		}
		.ui-state-hover, .ui-state-active {
		    color: #ffffff;
		    text-decoration: none;
		    background-color: #0088cc;
		    border-radius: 0px;
		    -webkit-border-radius: 0px;
		    -moz-border-radius: 0px;
		    background-image: none;
		}    
		.glyphicon-refresh-animate {
		    -animation: spin .7s infinite linear;
		    -webkit-animation: spin2 .7s infinite linear;
		}
		
		@-webkit-keyframes spin2 {
		    from { -webkit-transform: rotate(0deg);}
		    to { -webkit-transform: rotate(360deg);}
		}
		
		@keyframes spin {
		    from { transform: scale(1) rotate(0deg);}
		    to { transform: scale(1) rotate(360deg);}
		}
  	</style>
  	
  </head>
  <body>
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Job Validation</h4>
        </div>
        <div class="modal-body">
          <p></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
	<div class="container-fluid">
  		 <div class="row page-header" style="background:#F0EDE5;margin-top:0px;padding-top:0px;">
  			<div class="col-md-8">
  				<ul class="list-inline">
				    <li>
				    	<a title="<?php echo $_SESSION['BRANCHNAME'];?>" href="home.php" rel="home">
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
					    <li>&nbsp;
						    <div class="dropdown">
		  						<span class="glyphicon glyphicon-list"  data-toggle="dropdown" class="border-right: 1px solid #000; width: 105%;"> <a href="javascript:void(0)">Analytics</a>
		  						<span class="caret"></span></span>
									  <ul class="dropdown-menu">
										    <li><a href="allContract.php" >Completed Trips</a></li>
										    <li><a href="allMissedContract.php">Missed Trips</a></li>
									  </ul>
							</div>
						</li>
					    <!-- the dropdown menu goes here dropdown-menu-->
					    <li class="glyphicon glyphicon-off"><a href="logout.php" >&nbsp;Logout</a></li>
	  				</ul>
  				</div>
  			</div>
		</div>
		<div class="row">
			<div class="col-md-4" >
				<div class="panel panel-default">
				  	<div class="panel-heading"><h4 class="panel-title">Job entry form</h4></div>
				    <div class="panel-body table-responsive">
					    <form class="form-horizontal">
						    <div class="form-group">						    	
								<div class="col-sm-12">
									<div class="input-group">
										<div class="input-group-addon">+91</div>
										<input type="phone" class="form-control" id="phone" maxlength="10" placeholder="Enter customer 10 digit Phone Number.">
									</div>
								</div>
							</div>
							<div class="panel-body table-responsive" style="display:none;">
						    	<table id="addDtlTab" class="table .table-hover">
							       <thead>
							       	<tr><th>#</th><th>Name</th><th>Address</th></tr>
							       	</thead>
							       	<tbody>
							       		<tr><td colspan='3'>No Address Found</td></tr>
							       	</tbody>
							   </table>
						    </div>
							<div class="form-group">
								<div class="col-sm-12">
									<input type="text" class="form-control" id="name" placeholder="Enter Customer Name.">
								</div>
							</div>	    
							<div class="form-group">
								<div class="col-sm-12">
									 <textarea class="form-control" rows="2" name="address" id="address"  placeholder="Enter customer address."></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<input type="text" class="form-control" id="dropLoc" name="gaddress" placeholder="Enter Delivery Location.">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="checkbox"><label class="checkbox-inline"><input type="checkbox" value="cod"  class="payMethod" >COD</label></div>
									<div class="checkbox"><label class="checkbox-inline"><input type="checkbox" value="cc"   class="payMethod" >CC</label></div>
									<div class="checkbox"><label class="checkbox-inline"><input type="checkbox" value="paid" class="payMethod" >ALREADY PAID</label></div>

								</div>
							</div>
							<div class="form-group" id="codVal" style="display:none;">
								<div class="col-sm-12">
									<div class="input-group">
										<div class="input-group-addon">&#8377;</div>
										<input type="text" class="form-control" id="amount" placeholder="Enter amount to be collected." value="0.00">									
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<input type="text" class="form-control" id="transacCode" placeholder="Enter transaction code.">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12 text-right">
									<input type="hidden"  name="addrid" id="addrid" value="0" />
									<input type="hidden"  name="dlat" id="dlat" value="" />
									<input type="hidden"  name="dlng" id="dlng" value="" />
									<button type="button" class="btn btn-primary" id="BookNow1">Send Order</button>
									<button type="button" class="btn btn-primary" id="addOrder"><span class="glyphicon glyphicon-plus"></span> Add Order</button>
								</div>
							</div>
						</form>
				    </div>			    
				    <div class="panel-body table-responsive" style="">
				    	<table id="addOrderTab" class="table .table-hover">
					       <thead>
					       	<tr><th>Phone</th><th>Name</th><th>Address</th></tr>
					       	</thead>
					       	<tbody>
					       		<tr><td colspan='3'>No Record</td></tr>
					       	</tbody>
					   </table>
				    </div>
				    
				    
				    
				 </div> 
			</div>
			<div class="col-md-4 embed-responsive embed-responsive-16by9">
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
					    		<li>In-transit trips drivers and locations are in random color.</li>
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
				  	<div class="panel-heading"><h4 class="panel-title">Incoming Driver</h4></div>
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
				  	<div class="panel-heading"><h4 class="panel-title">In transit</h4></div>
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
	var geocoder, autocomplete,currLat='<?php echo $_SESSION['LAT'];?>',currLng='<?php echo $_SESSION['LNG'];?>';
	baseUrl	=	'<?php echo $config['base_url']; ?>';
    </script>
    <script type="text/javascript" src="<?php echo $config['base_url']; ?>js/custom.js"   ></script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=<?php echo $config['gmap_api_key'];?>&libraries=places&callback=initAutocomplete">
    </script>
    
  </body>
</html>