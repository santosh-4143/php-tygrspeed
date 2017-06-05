<?php
/*
 * Created on 26-Sep-2016
 *
 * Created By Moloy
 * This is ajax page to perform miselinious operations.
 */
include_once('../config/config.php');
include_once('../config/database.php');
include_once('../config/function.php');
if(!loginCheckNoRedirection($config)){
	echo "Redirection required";
	exit;
}
include_once('../config/query.php');
$action 									=	$_REQUEST['action'];
switch($action){
	case "saveLocation":
					saveLocation($conn);
					break;
	default:
					defaultFunction();
					break;		
}
function defaultFunction(){
	echo "No Result Found";
	exit;
}

function saveLocation($conn){
	echo $sql		=	"UPDATE `tbl_dlv_company_branch` " .
					"JOIN `tbl_dlv_branch_user`" .
						"ON `tbl_dlv_company_branch`.`id`=`tbl_dlv_branch_user`.`branch_id`" .
					"SET `tbl_dlv_company_branch`.`latitude`='".$_REQUEST['lat']."'," .
							"`tbl_dlv_company_branch`.`longitude`='".$_REQUEST['lng']."'" .
					"WHERE `tbl_dlv_branch_user`.`id`='".trim($_SESSION['LOGINID'])."'";
	echo $conn->query($sql);
	echo "Updated";
}
?>
