<?php
/*
 * Created on 24-Sep-2016
 *
 * Created By Moloy
 * Ajax Page to get In transit data
 * 
 * 
 */
 include_once('../config/config.php');
 include_once('../config/database.php');
 $responseData['incoming']	=	array();
 $responseData['transit']	=	array();
 $transitionSql				=	"SELECT `tbl_userdetails`.`FirstName`,`tbl_userdetails`.`LastName`,`tbl_contract`.`carno`,`tbl_oppurtunity`.`ToLocation` `endlocation`," .
								"`tbl_contract`.`ContractID`,`tbl_contract`.`starttime`,`tbl_contract`.`endtime`,`tbl_availability`.`Location_lat`,`tbl_availability`.`Location_lon`," .
								"`tbl_oppurtunity`.`EndLocation_lat`,`tbl_oppurtunity`.`EndLocation_lon`,`tbl_user`.`MSISDN` `phone`" .
								"FROM `tbl_contract`" .
								"JOIN `tbl_oppurtunity`	ON `tbl_contract`.`oppurtunityid`=`tbl_oppurtunity`.`oppurtunityid`" .
								"JOIN `tbl_availability` ON `tbl_contract`.`AvailabilityID`=`tbl_availability`.`AvailabilityID`" .
								"JOIN `tbl_userdetails` ON `tbl_availability`.`UserID`=`tbl_userdetails`.`UserId`" .
								"JOIN `tbl_user` ON `tbl_user`.`UserId`=`tbl_userdetails`.`UserId`" .
								"WHERE `tbl_contract`.`status`='started'" .
								"AND `tbl_contract`.`cartypeid`='9'" .
								"AND tbl_oppurtunity.userid='".$_SESSION['USERID']."'" .
 								"AND `tbl_oppurtunity`.`Time`>= '".date('Y-m-d')." 00:00:01'" .
 								"AND `tbl_oppurtunity`.`Time`<= '".date('Y-m-d')." 23:59:59'";
 if ($resTransition = $conn->query($transitionSql)or die($conn->error)) {
    while ($objTransit = $resTransition->fetch_object()) {
    	$responseData['transit'][]=	array(
    									'driver'		=>	$objTransit->FirstName." ".$objTransit->LastName,
    									'driver_lat'	=>	$objTransit->Location_lat,
    									'driver_lng'	=>	$objTransit->Location_lon,
    									'dest_lat'		=>	$objTransit->EndLocation_lat,
    									'dest_lng'		=>	$objTransit->EndLocation_lon,
    									'dest'			=>	$objTransit->endlocation,
    									'car'			=>	$objTransit->carno,
    									'phone'			=>	"+".$objTransit->phone
    								);
    }
    //* free result set */
    $resTransition->close();
}else{
	$responseData['transit']	=	array();	
}

$incomingSql				=	"SELECT `tbl_userdetails`.`FirstName`,`tbl_userdetails`.`LastName`,`tbl_contract`.`carno`,`tbl_oppurtunity`.`ToLocation` `endlocation`," .
								"`tbl_contract`.`ContractID`,`tbl_contract`.`starttime`,`tbl_contract`.`endtime`,`tbl_availability`.`Location_lat`,`tbl_availability`.`Location_lon`," .
								"`tbl_oppurtunity`.`EndLocation_lat`,`tbl_oppurtunity`.`EndLocation_lon`,`tbl_user`.`MSISDN` `phone`" .
								"FROM `tbl_contract`" .
								"JOIN `tbl_oppurtunity`	ON `tbl_contract`.`oppurtunityid`=`tbl_oppurtunity`.`oppurtunityid`" .
								"JOIN `tbl_availability` ON `tbl_contract`.`AvailabilityID`=`tbl_availability`.`AvailabilityID`" .
								"JOIN `tbl_userdetails` ON `tbl_availability`.`UserID`=`tbl_userdetails`.`UserId`" .
								"JOIN `tbl_user` ON `tbl_user`.`UserId`=`tbl_userdetails`.`UserId`" .
								"WHERE `tbl_contract`.`status`='create'" .
								"AND `tbl_contract`.`cartypeid`='9'" .
								"AND tbl_oppurtunity.userid='".$_SESSION['USERID']."'" .
 								"AND `tbl_oppurtunity`.`Time`>= '".date('Y-m-d')." 00:00:01'" .
 								"AND `tbl_oppurtunity`.`Time`<= '".date('Y-m-d')." 23:59:59'";
 if ($resIncoming = $conn->query($incomingSql)or die($conn->error)) {
    while ($objIncoming = $resIncoming->fetch_object()) {
    	$responseData['incoming'][]=	array(
    									'driver'		=>	$objIncoming->FirstName." ".$objIncoming->LastName,
    									'driver_lat'	=>	$objIncoming->Location_lat,
    									'driver_lng'	=>	$objIncoming->Location_lon,
    									'dest_lat'		=>	$objIncoming->EndLocation_lat,
    									'dest_lng'		=>	$objIncoming->EndLocation_lon,
    									'dest'			=>	$objIncoming->endlocation,
    									'car'			=>	$objIncoming->carno
    								);
    }
    //* free result set */
    $resIncoming->close();
}else{
	$responseData['incoming']	=	array();	
}
echo json_encode($responseData);
?>
