<?php
/*
 * Created on 23-Sep-2016
 *
 * Created By Moloy
 * ajax Page to show all open request for today
 */
 include_once('../config/config.php');
 include_once('../config/database.php');
 $responseData		=	"";
 $sql				=	"SELECT Time,`tbl_oppurtunity`.`OppurtunityID`,ToLocation,`tbl_driverdetails`.`CarNo`,`tbl_userdetails`.`FirstName`,`tbl_userdetails`.`LastName`,`tbl_availability`.`AvailabilityID`" .
 						"FROM `tbl_oppurtunity`" .
 						"JOIN `tbl_opportunity_state` ON `tbl_oppurtunity`.`OppurtunityID`=`tbl_opportunity_state`.`OppurtunityID`" .
 						"JOIN `tbl_availability` ON `tbl_opportunity_state`.`DriverID`=`tbl_availability`.`UserID`" .
 						"JOIN `tbl_driverdetails` ON `tbl_availability`.`UserID`=`tbl_driverdetails`.`UserId`" .
 						"JOIN `tbl_userdetails` ON `tbl_driverdetails`.`UserId`=`tbl_userdetails`.`UserId`" .
 						"WHERE `tbl_oppurtunity`.`Status`='created' " .
 						"AND `tbl_oppurtunity`.`UserID`='".$_SESSION['USERID']."'" .
 						"AND `tbl_oppurtunity`.`Time` LIKE '%".date('Y-m-d')."%'" .
 						"AND `tbl_opportunity_state`.`status`='DIRECT_ACCEPT'";

if ($result = $conn->query($sql)or die($conn->error)) {

    /* fetch object array */
    //echo '<pre>';
    while ($obj = $result->fetch_object()) {
     //   print_r($obj);
       $responseData		.=	"<tr class=\"".$obj->OppurtunityID."\"><td>".$obj->FirstName." ".$obj->LastName."</td><td>".$obj->CarNo."</td><td>".$obj->ToLocation."</td><td><a href=\"".$obj->OppurtunityID."|||".$obj->AvailabilityID."\" class=\"createCon\">Confirm</a></td></tr>";
    }
    //* free result set */
    $result->close();
}
if(trim($responseData)==""){
	$responseData			=	"<tr><td colspan=\"4\">No result Found</td></tr>";
}
echo $responseData; 
?>
