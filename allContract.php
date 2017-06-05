<?php
/*
 * Created on 27-Sep-2016
 *
 * Created By Moloy
 * Page to displat all contract
 * 
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
    <title>All Contract - Tygr Speed</title>
    <!-- ----------------------------added by satragni--------------------------------- -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <!-- ------------------------------------------------------------------------- -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>    
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
        
<script type="text/javascript" language="javascript"  src="js/moment-with-locales.js"></script>
<script type="text/javascript" language="javascript"  src="js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript"  src="js/bootstrap-datetimepicker.js"></script>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="css/bootstrap-datetimepicker.css" type="text/css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(function () {
$('#datetimepicker1').datetimepicker({
format: 'YYYY-MM-DD HH:mm'
});
});
</script>
<script type="text/javascript">
$(function () {
$('#datetimepicker2').datetimepicker({
format: 'YYYY-MM-DD HH:mm'
});
});
</script>
        
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
					    <li style="border-right:1px solid #000;" >&nbsp;
						    <div class="dropdown">
		  						<span class="glyphicon glyphicon-list"  data-toggle="dropdown" class="border-right: 1px solid #000; width: 105%;"> <a href="javascript:void(0)">Analytics</a>
		  						<span class="caret"></span></span>
									  <ul class="dropdown-menu">
										    <li><a href="allContract.php" >Completed Trips</a></li>
										    <li><a href="allMissedContract.php">Missed Trips</a></li>
									  </ul>
							</div>
						</li>
					    <li class="glyphicon glyphicon-off"><a href="logout.php" >&nbsp;Logout</a></li>
	  				</ul>
  				</div>
  			</div>
		</div>
		<div class="col-md-12 row">
<h3>Completed Contracts</h3>
          <form id="Form1" action="" method="get">
              <div class="col-md-3 text_input_padding">
              <div class="form-group">
              <div>Start Date</div> 
              <div class='input-group date' id='datetimepicker1'>
              <input type='text' name="fromdate" class="form-control"  value="<?php echo (isset($_REQUEST['fromdate']))?$_REQUEST['fromdate']:'';?>" placeholder="From (YYYY-MM-DD) HH:MM"/>
              <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
              </span>
              </div>
              </div>
              </div>
              
              <div class="col-md-3 text_input_padding ">
              <div class="form-group">
              <div>End Date</div>
              <div class='input-group date' id='datetimepicker2'>
              <input type='text' name="todate" class="form-control" value="<?php echo (isset($_REQUEST['todate']))?$_REQUEST['todate']:'';?>" placeholder="To (YYYY-MM-DD) HH:MM"/>
              <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
              </span>
              </div>
              </div>
              </div>
             
              <div class="col-md-2">
              <br />
              <button type="submit" class="btn btn-primary">
                Show
              </button>
              </div>  
          </form>  
		</div>
	</div>
    
   <div class="row">
   <div class="col-md-12">
  <div class="panel-body table-responsive">
  			<table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="90%" style="font-size: 13px;">
        <thead>
            <tr>
              <th>Contractid</th>
              <th>Date</th>   
     			<th>Location</th>
              <th>Driver Name</th>
              <th>Total Ride Time</th>
              <th>Distance Estimate</th>
              <th>Actual Distance</th>
              <th>Amount</th>
              <!--<th>Minutes Estimate</th>-->
            </tr>
        </thead>
 

<?php


if(isset($_REQUEST['fromdate']) && trim($_REQUEST['fromdate'])!="" && isset($_REQUEST['todate']) && trim($_REQUEST['todate'])!=""){  
 $query 						=		" SELECT`contractid`,`tbl_contract`.`oppurtunityid` `oppurtunityid`,`tbl_contract`.`availabilityid`,`distanceoppuravail`," .
   										"`tbl_contract`.`traveldistance` `traveldistance`,`userfeedbk`,`driverfeedbk`,`StartLocation_lat`,`StartLocation_lon`," .
   										"`FromLocation`,`Time`,`tbl_contract`.`endlocation` `actualendlocation`," .
   										"`tbl_contract`.`kmcalculated`,`tbl_contract`.`farecalculated`,`tbl_contract`.`mincalculated`," .
   										"`tbl_contract`.`status`,`tbl_contract`.`starttime`,`tbl_contract`.`endtime`," .
   										" `tbl_dlv_orders`.`phone` `phoneNo`,`tbl_dlv_orders`.`name`,`tbl_dlv_orders`.`address`,`tbl_dlv_orders`.`gaddress` `ToLocation`,".
  										" `dest_lat` `EndLocation_lat`,`dest_lng` `EndLocation_lon`,`distance`,`tbl_dlv_orders`.`payment_mode` `cod`," .
  										" `tbl_dlv_orders`.`amount`, `tbl_dlv_orders`.`transaction_code` `referencecode`,`driver`.`FirstName`,`driver`.`LastName`".
   										" FROM `tbl_contract`" .
   										" JOIN `tbl_oppurtunity` ON	`tbl_oppurtunity`.`oppurtunityid` = `tbl_contract`.`oppurtunityid`" .
   										" JOIN `tbl_dlv_orders` ON `tbl_oppurtunity`.`oppurtunityid` = `tbl_dlv_orders`.`opportunity_id`".
   										" JOIN `tbl_user` ON  `tbl_oppurtunity`.`userid` = `tbl_user`.`userid`" .
   										" JOIN `tbl_availability` ON `tbl_availability`.`availabilityid`=`tbl_contract`.`availabilityid`".
                      					" JOIN `tbl_userdetails` AS driver ON `tbl_availability`.`UserID`=driver.UserID".
   										" WHERE `tbl_contract`.`status`='completed'" .
   										" AND `tbl_contract`.`cartypeid`='9'" .
   										" AND `tbl_oppurtunity`.`deliverytype`='D'" .
   										" AND `tbl_oppurtunity`.`UserID` ='".trim($_SESSION['USERID'])."'" .
   										" AND `tbl_contract`.`starttime` >= '".date('Y-m-d h:i:s',strtotime($_REQUEST['fromdate']))."' " .
   										" AND tbl_contract.endtime <= '".date('Y-m-d h:i:s',strtotime($_REQUEST['todate']))."'".
   										"ORDER BY Time DESC"; 
  

$res=$conn->query($query);

 $i=0;
 while($user_list=$res->fetch_assoc()){

 $starttime=$user_list['starttime'];
  $endtime=$user_list['endtime'];
  //echo $starttime."  ======  ".$endtime;
    $to_time = strtotime($endtime);
  $from_time = strtotime($starttime);
  $incomStr			=	"";
  if(trim($user_list['starttime'])!="" && trim($user_list['Time'])!=""){
  	$incomTimDiff	=	round(abs($to_time - strtotime(trim($user_list['Time']))) / (60),0);
  	$incomTimHr		=	(int)($incomTimDiff/60);
  	$incomTimMin	=	(int)($incomTimDiff%60);
  	if($incomTimHr>0){
  		$incomStr	=	$incomTimHr." hr".$incomTimMin." Min";
  	}else{
  		$incomStr	=	$incomTimMin." Min";
  	}
  }else{
  	$incomStr		=	"N/A";
  }
  $journeytime=round(abs($to_time - $from_time) / (60),0);
  $journeyHour=(int)($journeytime/60);
  $journeyMin=$journeytime%60;
  $journeyStr="";
  if($journeyHour>0){
  $journeyStr=$journeyHour."H"." ".$journeyMin."M";
  }else{
  $journeyStr=$journeyMin."M";
  }
   $dis=$user_list['traveldistance'];
   $distance=$dis/1000;
   $dis='km';
   $traveldistance=round($distance, 2);
   $totaltraveldistance=$traveldistance." ".$dis;

   $kmcal=$user_list['kmcalculated'];
  $kmcalculated=round($kmcal, 2);
  $actualdistance=$kmcalculated." ".$dis;

  $farecalculated=$user_list['farecalculated'];
  $min='min';
  $mincal=$user_list['mincalculated'];
  $mincalculated=$mincal." ".$min;

  
  
$i++;

?>
          <tbody>

          <tr>
          <td><?php echo "<strong>Contract ID:</strong>".$user_list['contractid']."<br/>"."<strong>Transactional ID:</strong>".$user_list['referencecode'];?></td>
          <td><?php echo date('jSM,y',strtotime($user_list['Time']));?></td>
          <td>
            <p><strong style="font-weight:bold;">Start From:</strong><?php echo $user_list['FromLocation'];?></p>
            <p><strong style="font-weight:bold;">End to:</strong><?php echo $user_list['ToLocation'];?><br /></p>
            <p>
            	<strong style="font-weight:bold;">Customer Details:</strong>
            	Name: <?php echo $user_list['name'];?> Ph: <?php echo "+".trim($user_list['phoneNo']);?><br>
            	Address :<?php echo $user_list['address'];?> 
            </p> 
            
          </td>
          
          <td>
          <?php echo $user_list['FirstName'].' '.$user_list['LastName'];?>
          <p> <!--Driver:
          <?php
          /*$pass_star_number=$user_list['driverfeedbk'];
          for($x=1;$x<=$pass_star_number;$x++) {
          echo '<img src="img/star.png" />';
          }*/?></p>-->
          </td>
         
          
          <td><?php echo $journeyStr; echo '<br />Incoming Time:'.$incomStr;?></td>
          <td><?php echo $totaltraveldistance;?></td>
           <td>
          <?php
              $status = $user_list['status'];
              switch ($status) {
              case "completed":
              echo $actualdistance;
              break;
              default:
              echo "N/A";
              }
              ?>
          </td>
          <td>
           <?php
              // $status = $user_list['status'];
              // switch ($status) {
              // case "completed":
              // echo '<img src="img/rupee.png" />'." ".$farecalculated;
              // break;
              // default:
              // echo "N/A";
              // }
              ?>
              <?php if($user_list['amount']>0){
              		echo "<strong>Amount: &#8377;</strong>".$user_list['amount'];
              	}
                switch (trim($user_list['cod'])) {
                  case "Y": echo"<br/><strong>Mode of Payment:</strong> COD";
                    # code...
                    break;

                  case "CC": echo"<br/><strong>Mode of Payment:</strong> CREDIT/DEBIT CARD";
                    # code...
                    break;  

                  case "PAID": echo"<br/><strong>Mode of Payment:</strong> ALREADY PAID";;
                    # code...
                    break;}


              ?>
          </td>
         <!-- <td>
          <?php
              $status = $user_list['status'];
              switch ($status) {
              case "completed":
              echo $mincalculated;
              break;
              default:
              echo "N/A";
              }
              ?>
          </td>-->
           
          </tr>
                </tbody>
          <?php  }
          ?>


<?php } ?>
</table>  
</div>
 </div>
	</div>
 

  
</div>
  
  
    
     
  </body>
  </html>

