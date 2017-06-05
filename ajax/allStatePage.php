<?php
/*
 * Created on 23-Sep-2016
 *
 * Created By Moloy
 * ajax Page for showing all transition and completed state.
 */
 include_once('../config/config.php');
 include_once('../config/database.php');
 include_once('../config/function.php');
 
$responseData				=	array();
$responseData['freedriver']	=	"";
$contents						=	 get_web_page($config['api_url'].'findDriverForDelivery?latitude='.$_SESSION['LAT'].'&longitude='.$_SESSION['LNG'].'&cartype=4',array(),'GET');
 if(empty($contents)){
 	$responseData['freedriver']	.=	"<tr><td colspan=\"3\">No result found.</td></tr>";
 }else{
	 $decomContents				=	json_decode($contents['content']);
	 if($decomContents->success==true && isset($decomContents->drivers)){
	 	if(count($decomContents->drivers)==1){
			$responseData['freedriver']		.=	"<tr><td>".$decomContents->drivers->driverName."</td><td>".$decomContents->drivers->carNo."</td><td>".$decomContents->drivers->driverPhoneNumber."</td></tr>";
	 	}else{
		 	for($i=0;$i<count($decomContents->drivers);$i++){
				$responseData['freedriver']		.=	"<tr><td>".$decomContents->drivers[$i]->driverName."</td><td>".$decomContents->drivers[$i]->carNo."</td><td>".$decomContents->drivers[$i]->driverPhoneNumber."</td></tr>";
		 	}
	 	}
	 }else{
	 	$responseData['freedriver']	.=	"<tr><td colspan=\"3\">No result found.</td></tr>";	
	 }	
	 
 }
$responseData['pendingrequest']	=	"";
$pendingrequestSql				=	"SELECT `tbl_oppurtunity`.`OppurtunityID`,`tbl_oppurtunity`.`Time`,`tbl_oppurtunity`.`FromLocation`,`tbl_oppurtunity`.`ToLocation`" .
								"FROM `tbl_oppurtunity`" .
								"LEFT JOIN `tbl_opportunity_state` ON `tbl_oppurtunity`.`OppurtunityID`=`tbl_opportunity_state`.`OppurtunityID`" .
								"WHERE `tbl_oppurtunity`.`Status`='created'" .
								"AND tbl_opportunity_state.status IS NULL " .
								"AND tbl_oppurtunity.userid='".$_SESSION['USERID']."'" .
 								"AND `tbl_oppurtunity`.`Time`>= '".date('Y-m-d')." 00:00:01'" .
 								"AND `tbl_oppurtunity`.`Time`<= '".date('Y-m-d')." 23:59:59'";
 if ($resPendingRequest = $conn->query($pendingrequestSql)or die($conn->error)) {
    while ($objPendingRequest = $resPendingRequest->fetch_object()) {
    	$responseData['pendingrequest']	.=	"<tr>" .
    									"<td>".$objPendingRequest->OppurtunityID."</td>" .
    									"<td>".$objPendingRequest->ToLocation."</td>" .
    									"<td>".date('d/m/Y g:i a',strtotime($objPendingRequest->Time))."</td>" .
    									"</tr>";
    }
    //* free result set */
    $resPendingRequest->close();
}else{
	$responseData['pendingrequest']	=	"<tr><td>No Result Found</td></tr>";	
}

$responseData['incoming']	=	"";
$incomingSql				=	"SELECT `tbl_userdetails`.`FirstName`,`tbl_userdetails`.`LastName`,`tbl_contract`.`carno`, `tbl_oppurtunity`.`ToLocation` `endlocation`," .
								"`tbl_contract`.`ContractID`,`tbl_contract`.`starttime`,`tbl_contract`.`endtime`,`tbl_oppurtunity`.`Time`" .
								"FROM `tbl_contract`" .
								"JOIN `tbl_oppurtunity`	ON `tbl_contract`.`oppurtunityid`=`tbl_oppurtunity`.`oppurtunityid`" .
								"JOIN `tbl_availability` ON `tbl_contract`.`AvailabilityID`=`tbl_availability`.`AvailabilityID`" .
								"JOIN `tbl_userdetails` ON `tbl_availability`.`UserID`=`tbl_userdetails`.`UserId`" .
								"WHERE `tbl_contract`.`status`='create'" .
								"AND `tbl_contract`.`cartypeid`='9'" .
								"AND tbl_oppurtunity.userid='".$_SESSION['USERID']."'" .
 								"AND `tbl_oppurtunity`.`Time`>= '".date('Y-m-d')." 00:00:01'" .
 								"AND `tbl_oppurtunity`.`Time`<= '".date('Y-m-d')." 23:59:59'";
 if ($resIncoming = $conn->query($incomingSql)or die($conn->error)) {
    while ($objIncoming = $resIncoming->fetch_object()) {
    	$responseData['incoming']	.=	"<tr>" .
    									"<td>".$objIncoming->FirstName." ".$objIncoming->LastName."</td>" .
    									"<td>".$objIncoming->carno."</td>" .
    									"<td>".$objIncoming->endlocation."</td>" .
    									"<td>".date('d/m/Y g:i a',strtotime($objIncoming->Time))."</td>" .
    									"</tr>";
    }
    //* free result set */
    $resIncoming->close();
}else{
	$responseData['incoming']	=	"<tr><td>No Result Found</td></tr>";	
}


// Code For Transition Table

$responseData['transit']	=	"";
//$responseData['transit']	=	"<tr><td>No Transit Result</td></tr>";

$transitionSql				=	"SELECT `tbl_userdetails`.`FirstName`,`tbl_userdetails`.`LastName`,`tbl_contract`.`carno`,`tbl_oppurtunity`.`ToLocation` `endlocation`," .
								"`tbl_contract`.`ContractID`,`tbl_contract`.`starttime`,`tbl_contract`.`endtime`" .
								"FROM `tbl_contract`" .
								"JOIN `tbl_oppurtunity`	ON `tbl_contract`.`oppurtunityid`=`tbl_oppurtunity`.`oppurtunityid`" .
								"JOIN `tbl_availability` ON `tbl_contract`.`AvailabilityID`=`tbl_availability`.`AvailabilityID`" .
								"JOIN `tbl_userdetails` ON `tbl_availability`.`UserID`=`tbl_userdetails`.`UserId`" .
								"WHERE `tbl_contract`.`status`='started'" .
								"AND `tbl_contract`.`cartypeid`='9'" .
								"AND tbl_oppurtunity.userid='".$_SESSION['USERID']."'" .
 								"AND `tbl_oppurtunity`.`Time`>= '".date('Y-m-d')." 00:00:01'" .
 								"AND `tbl_oppurtunity`.`Time`<= '".date('Y-m-d')." 23:59:59'";
 if ($resTransition = $conn->query($transitionSql)or die($conn->error)) {
    while ($objTransit = $resTransition->fetch_object()) {
    	$responseData['transit']	.=	"<tr>" .
    									"<td>".$objTransit->FirstName." ".$objTransit->LastName."</td>" .
    									"<td>".$objTransit->carno."</td>" .
    									"<td>".$objTransit->endlocation."</td>" .
    									"<td>".date('d/m/Y g:i a',strtotime($objTransit->starttime)) .
    									"</tr>";
    }
    //* free result set */
    $resTransition->close();
}else{
	$responseData['incoming']	=	"<tr><td>No Result Found</td></tr>";	
}

// Code For complete contract 
$responseData['complete']	=	"";
$completeSql			=	"SELECT `tbl_userdetails`.`FirstName`,`tbl_userdetails`.`LastName`,`tbl_contract`.`carno`,`tbl_oppurtunity`.`ToLocation` `endlocation`," .
								"`tbl_contract`.`ContractID`,`tbl_contract`.`starttime`,`tbl_contract`.`endtime`" .
 							"FROM `tbl_contract`" .
 							"JOIN `tbl_oppurtunity`	ON `tbl_contract`.`oppurtunityid`=`tbl_oppurtunity`.`oppurtunityid`" .
 							"JOIN `tbl_availability` ON `tbl_contract`.`AvailabilityID`=`tbl_availability`.`AvailabilityID`" .
 							"JOIN `tbl_userdetails` ON `tbl_availability`.`UserID`=`tbl_userdetails`.`UserId`" .
 							"WHERE `tbl_contract`.`status`='completed'" .
 							"AND `tbl_contract`.`cartypeid`='9'" .
 							"AND tbl_oppurtunity.userid='".$_SESSION['USERID']."'" .
 							"AND `tbl_oppurtunity`.`Time`>= '".date('Y-m-d')." 00:00:01'" .
 							"AND `tbl_oppurtunity`.`Time`<= '".date('Y-m-d')." 23:59:59'";
 if ($resultComplete = $conn->query($completeSql)or die($conn->error)) {
    while ($objComplete = $resultComplete->fetch_object()) {
    	$responseData['complete']	.=	"<tr>" .
    									"<td>".$objComplete->FirstName." ".$objComplete->LastName."</td>" .
    									"<td>".$objComplete->carno."</td>" .
    									"<td>".$objComplete->endlocation."</td>" .
    									"<td>".date('d/m/Y g:i a',strtotime($objComplete->starttime))." - ".date('d/m/Y g:i a',strtotime($objComplete->endtime))."</td>" .
    									"</tr>";
    }
    //* free result set */
    $resultComplete->close();
}
$conn->close();
echo json_encode($responseData);
?>
