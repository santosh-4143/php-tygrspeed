<?php
/*
 * Created on 22-Sep-2016
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 include_once('./config/config.php');
 include_once('./config/function.php');
 include_once('./config/database.php');
 loginCheck($config);
 include_once('./config/query.php');
 $dashBoardData				=	loginUserDetails($conn); 
?>
 <!DOCTYPE html>
<html >
  <head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="UTF-8">
    <title>Map - Tygr Speed</title>
  <link rel="stylesheet" href="<?php echo $config['base_url']; ?>css/reset.css">

    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
  <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

        <link rel="stylesheet" href="<?php echo $config['base_url']; ?>css/style.css">
                
        <style>
        	header{
        		height:100px;
        		background:#d3dce3 none repeat scroll 0 0;
        	}
        	header .branch_desc{
        		font-weight:bold;
        		margin-left:20px;
        		padding-top:20px;
        		float:left;
        	}
        	header .branch_desc span {
        		font-weight:normal;
        	}
        	table{
        		width:85%;
        		
        		margin: 100px auto; /* or margin: 0 auto 0 auto */
        	}
        	tr th{
        		text-align:center;
        		font-weight:bold;
        	}
        	tr{
        		line-height:20px;
        	}
        	tr:nth-child(even) {background: #c8ced2;}
        	tr:nth-child(even) td{
        		border-left: 2px solid #FFF;
        	}
			tr:nth-child(odd) {background: #FFF;}
			tr:nth-child(odd) td{
				border-left:1px solid #c8ced2;
			}
			.right-nav{
				text-align:center;
				border-top:5px solid #3C3B37;
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
			.tabhead th{
				background:#e1d0f1;
			}
        </style>
  </head>

  <body>
  <header>
  	<a title="<?php echo $_SESSION['BRANCHNAME'];?>" href="dashboard.php" rel="home" class="navbar-brand">
        <img src="<?php echo $config['base_url']; ?>img/tygr_speed.png" style="max-width:60px;float:left;">
         <img src="<?php echo $config['base_url']; ?>uploads/<?php echo $dashBoardData['logo_path']; ?>" style="max-width:60px;float:left;">
    </a>
    <div class="branch_desc">
    	<span>Welcome <?php echo $_SESSION['USERNAME'];?>,<br><br></span>
    	<?php echo $_SESSION['BRANCHNAME'];?>
    	<p><?php echo $dashBoardData['branch_address']; ?></p>
    </div>
    <div style="" class="right-log-panel"><a href="allContract.php" >Complete Trip</a> | <a href="logout.php" >Logout</a></div>
  </header
    <div class="right-nav">
       <iframe src="<?php echo $config['base_url']; ?>gmap.php" width="70%" style="float:left; height:900px;" id="gmp"></iframe> 
       <div style="float:left;width:30%; height:900px; overflow:scroll;">
       <table  border="1" style="width:80%;" id="freeDriver"  cellpadding="10">
       <thead>
       	<tr class="tabhead"><th colspan="4">Free Drivers</th></tr>
       	<tr><th>Driver</th><th>Car</th><th>Phone</th></tr>
       	</thead>
       	<tbody>
       	
       	</tbody>
       </table>
       
       
       <table  border="1" style="width:80%;" id="openOpportunity"  cellpadding="10">
       <thead>
       	<tr class="tabhead"><th colspan="4">Opportunity yet to be Accepted</th></tr>
       	<tr><th>Opportunity ID</th><th>Destination</th><th>Time</th></tr>
       	</thead>
       	<tbody>
       	
       	</tbody>
       </table>
       
       
       <table  border="1" style="width:80%;" id="openReq"  cellpadding="10">
       <thead>
       	<tr class="tabhead"><th colspan="4">Accepted By Driver</th></tr>
       	<tr><th>Driver</th><th>Car</th><th>Deliver Location</th><th>Action</th></tr>
       	</thead>
       	<tbody>
       	
       	</tbody>
       </table>
       
       <table  border="1" style="width:80%;" id="incomingReq">
       <thead>
       	<tr class="tabhead"><th colspan="4">Incoimg Driver</th></tr>
       	<tr><th>Driver</th><th>Car</th><th>Deliver Location</th><th>Time</th></tr>
       	</thead>
       	<tbody>       	
       	</tbody>
       </table>
       
       <table  border="1" style="width:80%;" id="transitReq">
       <thead>
       	<tr class="tabhead"><th colspan="4">Intransit</th></tr>
       	<tr><th>Driver</th><th>Car</th><th>Deliver Location</th><th>Time</th></tr>
       	</thead>
       	<tbody>       	
       	</tbody>
       </table>
       
       <table  border="1" style="width:80%;" id="completeReq">
       <thead>
       	<tr class="tabhead"><th colspan="4">Completed Contract</th></tr>
       	<tr><th>Driver</th><th>Car</th><th>Deliver Location</th><th>Time</th></tr>
       	</thead>
       	<tbody>       	
       	</tbody>
       </table>
       </div>
    </div>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
