<?php
/*
 * Created on 23-Sep-2016
 *Created By Moloy
 * Accept By Passager API calling
 */
 include_once('../config/config.php');
 include_once('../config/database.php');
 include_once('../config/function.php');
 $responseData					=	array();
 $requestData					=	array(
 										'oppurtunityId'			=>	$_REQUEST['optID'],
 										'distanceOppurAvail'	=>	'',
 										'availabilityId'		=>	$_REQUEST['avlID']
 									);
 $sql							=	"SELECT Time,`tbl_oppurtunity`.`OppurtunityID`,`tbl_oppurtunity`.`TravelDistance`,`tbl_availability`.`AvailabilityID`" .
			 						"FROM `tbl_oppurtunity`" .
			 						"JOIN `tbl_opportunity_state` ON `tbl_oppurtunity`.`OppurtunityID`=`tbl_opportunity_state`.`OppurtunityID`" .
			 						"JOIN `tbl_availability` ON `tbl_opportunity_state`.`DriverID`=`tbl_availability`.`UserID`" .
			 						"WHERE `tbl_oppurtunity`.`Status`='created' " .
			 						"AND `tbl_oppurtunity`.`UserID`='".$_SESSION['USERID']."'" .
			 						"AND `tbl_oppurtunity`.`Time` LIKE '%".date('Y-m-d')."%'" .
			 						"AND `tbl_opportunity_state`.`status`='DIRECT_ACCEPT'" .
			 						"AND `tbl_oppurtunity`.`OppurtunityID`='".$_REQUEST['optID']."'" .
			 						"AND `tbl_availability`.`AvailabilityID`='".trim($_REQUEST['avlID'])."'";
if ($result = $conn->query($sql)or die($conn->error)) {
    while ($obj = $result->fetch_object()) {
    	$requestData['distanceOppurAvail']	=	$obj->TravelDistance/1000;
    	$requestData['availabilityId']		=	$obj->AvailabilityID;
    }
    //* free result set */
    $result->close();
   $contents					=	 get_web_page($config['api_url'].'createContract',$requestData,'GET');
   echo $contents['content'];
}else{
	echo '';
}
 
?>
