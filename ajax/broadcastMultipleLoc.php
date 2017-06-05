<?php
/*
 * Created on 22-Sep-2016
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 include_once('../config/config.php');
 include_once('../config/database.php');
 include_once('../config/function.php');
 $responseData					=	array();
 $isCod;
 $delstoreIDs					=	"";

 $requestData					=	json_decode(file_get_contents("php://input"));
 if(!empty($requestData)){
 	for($i=0;$i<count($requestData);$i++){
 		switch (trim($requestData[$i]->payMethod)) {
			case "cod": $isCod='Y';
				break;
			case "cc": $isCod='CC';
				break;	
			case "paid": $isCod='PAID';
				break;		
		}
		$payMethod				=	trim($requestData[$i]->payMethod);
 		$addrId					=	trim($requestData[$i]->addrID);
 		$addrChkSql				=	"SELECT count(id) counter FROM `tbl_dlv_customer_contact` " .
 									"WHERE phone='91".trim($requestData[$i]->phone)."' " .
 									"AND address='".trim($requestData[$i]->address)."' AND name='".trim($requestData[$i]->name)."'";	
 		$result 				= 	$conn->query($addrChkSql);
 		$addrCounter			=	0;	
		if($result){
			while ($obj 				= 	$result->fetch_object()) {		
				$addrCounter			=	$obj->counter;
			}
			$result->close();
		}
		if($addrCounter==0){
			if(is_numeric($addrId) && $addrId>0){
				$uquery			=	"UPDATE `tbl_dlv_customer_contact`" .
									" SET phone='91".trim($requestData[$i]->phone)."'," .
									" address='".trim($requestData[$i]->address)."'," .
									" gaddress='".trim($requestData[$i]->dropLoc)."'," .
									" name='".trim($requestData[$i]->name)."', " .
									" glat='".trim($requestData[$i]->elat)."', " .
									" glng='".trim($requestData[$i]->elng)."' " .
									" WHERE id='".$addrId."'";
				
				$conn->query($uquery) or die($conn->error);	
			}else{
				$insSql			=	"INSERT INTO `tbl_dlv_customer_contact` " .
									" SET phone='91".trim($requestData[$i]->phone)."'," .
									" address='".trim($requestData[$i]->address)."'," .
									" gaddress='".trim($requestData[$i]->dropLoc)."'," .
									" name='".trim($requestData[$i]->name)."', " .
									" glat='".trim($requestData[$i]->elat)."', " .
									" glng='".trim($requestData[$i]->elng)."' ";
		 		$conn->query($insSql) or die($conn->error);	
			}
		}else{
			if(is_numeric($addrId) && $addrId>0){
				$uquery			=	"UPDATE `tbl_dlv_customer_contact`" .
									" SET phone='91".trim($requestData[$i]->phone)."'," .
									" address='".trim($requestData[$i]->address)."'," .
									" gaddress='".trim($requestData[$i]->dropLoc)."'," .
									" name='".trim($requestData[$i]->name)."', " .
									" glat='".trim($requestData[$i]->elat)."', " .
									" glng='".trim($requestData[$i]->elng)."' " .
									" WHERE id='".$addrId."'";
				
				$conn->query($uquery) or die($conn->error);	
			}
		}
		$delSql					=	"INSERT INTO `tbl_dlv_orders` SET " .
									" `phone`='".trim($requestData[$i]->phone)."'," .
									" `name`='".trim($requestData[$i]->name)."'," .
									" `address`='".trim($requestData[$i]->address)."'," .
									" `gaddress`='".trim($requestData[$i]->dropLoc)."'," .
									" `source_lat`='".trim($requestData[$i]->slat)."'," .
									" `source_lng`='".trim($requestData[$i]->slng)."'," .
									" `dest_lat`='".trim($requestData[$i]->elat)."'," .
									" `dest_lng`='".trim($requestData[$i]->elng)."'," .
									" `distance`='".trim($requestData[$i]->dist)."'," .
									" `payment_mode`='".trim($requestData[$i]->payMethod)."',".
									" `amount`='".trim($requestData[$i]->amount)."',".
									" `transaction_code`='".trim($requestData[$i]->transacCode)."'," .
									" `is_delivered`='0'";
		$conn->query($delSql)or die($conn->error);
 		$delstoreIDs				.=	$conn->insert_id.",";
 		if($i==0){
 			$apiRequestData			=	array(
 										'travelDistance'		=>	trim($requestData[$i]->dist),
 										'UserID'				=>	$_SESSION['USERID'],
 										'fromLocation'			=>	$_SESSION['BRANCHNAME'],
 										'toLocation'			=>	trim($requestData[$i]->dropLoc),
 										'carType'				=>	4,
 										'startLatitude'			=>	trim($requestData[$i]->slat),
 										'startLongitude'		=>	trim($requestData[$i]->slng),
 										'endLatitude'			=>	trim($requestData[$i]->elat),
 										'endLongitude'			=>	trim($requestData[$i]->elng),
 										'address'				=>	trim($requestData[$i]->address),
 										'phoneNo'				=>	' 91'.trim($requestData[$i]->phone),
 										'name'					=>	trim($requestData[$i]->name),
 										'amount'				=>	trim($requestData[$i]->amount),
 										'referencecode'			=>	trim($requestData[$i]->transacCode),
 										'deliverytype'			=>	'D',
 										'cod'					=>	$isCod
 									);
 		}
 	}
 }
if(isset($apiRequestData) && isset($delstoreIDs)){
	$contents						=	 get_web_page($config['api_url'].'broadcastToDriver',$apiRequestData,'GET');
	 if($contents['content']!=""){
	 	$apiResponseData			=	json_decode($contents['content']);			
	 	print_r($contents['content']); echo "--------------------------------";
	 	$uSql						=	"UPDATE `tbl_dlv_orders` SET `opportunity_id`='".$apiResponseData->oppurtunity->oppurtunityID."'" .
	 									" WHERE id IN (".rtrim($delstoreIDs,",").")";
	 	$conn->query($uSql);
	 	$conn->close();
	 	get_web_page($config['api_url'].'updateUserState?state=FREE&userId='.$_SESSION['USERID'],array(),'GET');
	 }
}
 echo $contents['content'];
?>
