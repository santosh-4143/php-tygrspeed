<?php
/*
 * Created on 01-Oct-2016
 *
 * Created By Moloy
 * Ajax Page to show the location 
 */
 include_once('../config/config.php');
 include_once('../config/database.php');
 include_once('../config/function.php');
 
$responseData				=	array();
$responseData['pendingrequest']	=	"";
$pendingrequestSql				=	"SELECT `tbl_oppurtunity`.`OppurtunityID`,`tbl_oppurtunity`.`Time`,`tbl_oppurtunity`.`FromLocation`,`tbl_oppurtunity`.`ToLocation`," .
									"`tbl_oppurtunity`.`EndLocation_lat`,`tbl_oppurtunity`.`EndLocation_lon`" .
								"FROM `tbl_oppurtunity`" .
								"LEFT JOIN `tbl_opportunity_state` ON `tbl_oppurtunity`.`OppurtunityID`=`tbl_opportunity_state`.`OppurtunityID`" .
								"WHERE `tbl_oppurtunity`.`Status`='created'" .
								"AND (tbl_opportunity_state.status IS NULL OR `tbl_opportunity_state`.`status`='DIRECT_ACCEPT')" .
								"AND tbl_oppurtunity.userid='".$_SESSION['USERID']."'" .
 								"AND `tbl_oppurtunity`.`Time`>= '".date('Y-m-d')." 00:00:01'" .
 								"AND `tbl_oppurtunity`.`Time`<= '".date('Y-m-d')." 23:59:59'" .
 								" GROUP BY `tbl_oppurtunity`.`OppurtunityID`";
 if ($resPendingRequest = $conn->query($pendingrequestSql)or die($conn->error)) {
    while ($objPendingRequest = $resPendingRequest->fetch_object()) {
    	$responseData['pendingrequest'][]	=	array(
    												'id'	=>	$objPendingRequest->OppurtunityID,
    												'loc'	=>	$objPendingRequest->ToLocation,
    												'lat'	=>	$objPendingRequest->EndLocation_lat,
    												'lng'	=>	$objPendingRequest->EndLocation_lon
    											);
    }
    //* free result set */
    $resPendingRequest->close();
}else{
	$responseData['pendingrequest']	=	array();	
}
$conn->close();
//echo '<pre>';
//print_r($responseData);
echo json_encode($responseData);
?>
