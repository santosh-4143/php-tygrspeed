<?php
/*
 * Created on 20-Sep-2016
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
		  						<button class="glyphicon glyphicon-list" type="button" data-toggle="dropdown">Analytics
		  						<span class="caret"></span></button>
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
<h3>Missed Contracts</h3>
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
              <th>Opportunity ID</th>
              <th>Date</th>   
     			    <th>Customer Details</th>
              <th>Amount</th>
              <th>Status</th>
              
              
              <!--<th>Minutes Estimate</th>-->
            </tr>
        </thead>
 

<?php


if(isset($_REQUEST['fromdate']) && trim($_REQUEST['fromdate'])!="" && isset($_REQUEST['todate']) && trim($_REQUEST['todate'])!=""){  
$query              ="SELECT `tbl_oppurtunity`.`OppurtunityID`,`tbl_oppurtunity`.`referencecode`,`tbl_oppurtunity`.`Time`,`tbl_oppurtunity`.`name`,`tbl_oppurtunity`.`phoneno`,`tbl_oppurtunity`.`address`,`tbl_oppurtunity`.`amount`,`tbl_oppurtunity`.`cod`,`tbl_oppurtunity`.`Status`".
                      "From `tbl_oppurtunity`".
                      "JOIN `tbl_user` ON `tbl_oppurtunity`.`userid` = `tbl_user`.`userid`".
                      "Where NOT EXISTS(SELECT * FROM `tbl_contract` WHERE `tbl_oppurtunity`.`OppurtunityID`=`tbl_contract`.`OppurtunityID` AND `tbl_contract`.`cartypeid`='9')".
                      "AND `tbl_oppurtunity`.`deliverytype`='D'".
                      "AND `tbl_oppurtunity`.`UserID` ='".trim($_SESSION['USERID'])."'".
                      "AND `tbl_oppurtunity`.`Time` >= '".date('Y-m-d h:i:s',strtotime($_REQUEST['fromdate']))."'".
                      "AND `tbl_oppurtunity`.`Time` <= '".date('Y-m-d h:i:s',strtotime($_REQUEST['todate']))."'";

/*
cancelled_by_driver in tbl_contract 

$query              ="SELECT `tbl_oppurtunity`.`OppurtunityID`,`tbl_oppurtunity`.`referencecode`,`tbl_oppurtunity`.`Time`,`tbl_oppurtunity`.`name`,`tbl_oppurtunity`.`phoneno`,`tbl_oppurtunity`.`address`,`tbl_oppurtunity`.`amount`,`tbl_oppurtunity`.`cod`
                      From `tbl_oppurtunity`".
                      "JOIN `tbl_user` ON `tbl_oppurtunity`.`userid` = `tbl_user`.`userid`".
                      "Where NOT EXISTS(SELECT * FROM `tbl_contract` WHERE `tbl_oppurtunity`.`OppurtunityID`=`tbl_contract`.`OppurtunityID` AND `tbl_contract`.`cartypeid`='9')".
                      "AND `tbl_oppurtunity`.`deliverytype`='D'".
                      "AND `tbl_oppurtunity`.`UserID` ='".trim($_SESSION['USERID'])."'".
                      "AND `tbl_oppurtunity`.`Time` >= '".date('Y-m-d h:i:s',strtotime($_REQUEST['fromdate']))."'"
                      "AND `tbl_oppurtunity`.`Time` <= '".date('Y-m-d h:i:s',strtotime($_REQUEST['todate']))."'";

new query 
SELECT * FROM tbl_oppurtunity JOIN `tbl_user` ON `tbl_oppurtunity`.`userid` = `tbl_user`.`userid` Where NOT EXISTS(SELECT * FROM tbl_contract WHERE tbl_oppurtunity.OppurtunityID=tbl_contract.OppurtunityID AND tbl_contract.cartypeid='9') AND `tbl_oppurtunity`.`deliverytype`='D'AND `tbl_oppurtunity`.`UserID` ='u_mxUROGCv'AND `tbl_oppurtunity`.`Time` >= '2016-11-01 11:11:00' AND tbl_oppurtunity.Time <= '2016-11-30 11:11:00'



SELECT tbl_oppurtunity.OppurtunityID,tbl_oppurtunity.referencecode,tbl_oppurtunity.Time,tbl_oppurtunity.name,tbl_oppurtunity.phoneno,tbl_oppurtunity.address,tbl_oppurtunity.amount,tbl_oppurtunity.cod FROM tbl_oppurtunity JOIN `tbl_user` ON `tbl_oppurtunity`.`userid` = `tbl_user`.`userid` Where NOT EXISTS(SELECT * FROM tbl_contract WHERE tbl_oppurtunity.OppurtunityID=tbl_contract.OppurtunityID AND tbl_contract.cartypeid='9') AND `tbl_oppurtunity`.`deliverytype`='D'AND `tbl_oppurtunity`.`UserID` ='u_mxUROGCv'AND `tbl_oppurtunity`.`Time` >= '2016-11-01 11:11:00' AND tbl_oppurtunity.Time <= '2016-11-30 11:11:00'


*/




$res=$conn->query($query);
 $i=0;

 // print_r( $user_list=$res->fetch_assoc());
 // exit;
 while($user_list=$res->fetch_assoc()){
  
$i++;

?>
          <tbody>

          <tr>
          <td><?php echo "Opportunity ID:".$user_list['OppurtunityID']."<br/> Transactional ID:".$user_list['referencecode'];?></td>
          <td><?php echo date('jSM,y',strtotime($user_list['Time']));?></td>
          <td>
            	<strong style="font-weight:bold;">Customer Details:</strong>
            	Name: <?php echo $user_list['name'];?> Ph: <?php echo "<br/>".trim($user_list['phoneno']);?><br>
            	Address :<?php echo $user_list['address'];?><br> 
            </p> 
            
          </td>          
          <td>
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
          <td>
              <?php if(trim($user_list['Status'])=='created'){
                  echo "Pending";
                }
              ?>
          </td>
         
           
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
