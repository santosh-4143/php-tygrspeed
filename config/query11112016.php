<?php
/*
 * Created on 26-Sep-2016
 *
 * Created By Moloy
 * Page for query
 */
 function loginUserDetails($conn){
 	$responseData							=	array();	
 	$sql 									= 	"SELECT `tbl_dlv_company_branch`.`user_id`,`tbl_dlv_company_branch`.`latitude`,`tbl_dlv_company_branch`.`longitude`," .
												"`tbl_dlv_company_branch`.`branch_name`,`tbl_dlv_company`.`company_name`,`tbl_dlv_company`.`logo_path`," .
												"`tbl_dlv_company_branch`.`branch_address` " .
												"FROM `tbl_dlv_branch_user` " .
												"JOIN `tbl_dlv_company_branch` ON `tbl_dlv_branch_user`.`branch_id`=`tbl_dlv_company_branch`.`id`" .
												"JOIN `tbl_dlv_company` ON `tbl_dlv_company_branch`.`company_id`=`tbl_dlv_company`.`id`" .
												"WHERE `tbl_dlv_branch_user`.`id` = '".trim($_SESSION['LOGINID'])."' " .
												"AND `tbl_dlv_branch_user`.`status`='1'";
	$result 								= 	$conn->query($sql);
	if($result){
		while ($obj 						= 	$result->fetch_object()) {
			foreach($obj as $k=>$v){
				$responseData[trim($k)]		=	trim($v);		
			}
		}
		//* free result set */
		$result->close();
	}	
	//$conn->close();
	return $responseData;
 }
?>
