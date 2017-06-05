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

switch (trim($_REQUEST['payMethod'])) {
	case "cod": $isCod='Y';
		# code...
		break;

	case "cc": $isCod='CC';
		# code...
		break;	

	case "paid": $isCod='PAID';
		# code...
		break;		
	
}



 $payMethod						=	trim($_REQUEST['payMethod']);




 $addrId						=	trim($_REQUEST['addrID']);
 $requestData					=	array(
 										'travelDistance'		=>	$_REQUEST['dist'],
 										'UserID'				=>	$_SESSION['USERID'],
 										'fromLocation'			=>	$_SESSION['BRANCHNAME'],
 										'toLocation'			=>	$_REQUEST['toloc'],
 										'carType'				=>	4,
 										'startLatitude'			=>	$_REQUEST['slat'],
 										'startLongitude'		=>	$_REQUEST['slng'],
 										'endLatitude'			=>	$_REQUEST['elat'],
 										'endLongitude'			=>	$_REQUEST['elng'],
 										'address'				=>	$_REQUEST['addr'],
 										'phoneNo'				=>	' 91'.$_REQUEST['phone'],
 										'name'					=>	$_REQUEST['name'],
 										'amount'				=>	$_REQUEST['amount'],
 										'referencecode'			=>	$_REQUEST['transacCode'],
 										'deliverytype'			=>	'D',
 										'cod'					=>	$isCod
 									);
 $addrChkSql					=	"SELECT count(id) counter FROM `tbl_dlv_customer_contact` " .
 									"WHERE phone='91".$_REQUEST['phone']."' " .
 									"AND address='".$_REQUEST['addr']."' AND name='".$_REQUEST['name']."'";	
 $result 						= 	$conn->query($addrChkSql);
 $addrCounter					=	0;	
if($result){
	while ($obj 				= 	$result->fetch_object()) {		
		$addrCounter			=	$obj->counter;
	}
	//* free result set */
	$result->close();
}


if($addrCounter==0){
	if(is_numeric($addrId) && $addrId>0){
		$conn->query(" UPDATE `tbl_dlv_customer_contact`SET phone='91".$_REQUEST['phone']."',address='".$_REQUEST['addr']."',gaddress='".$_REQUEST['toloc']."',name='".$_REQUEST['name']."' WHERE id='".$addrId."'");	
	}else{
		 $conn->query("INSERT INTO `tbl_dlv_customer_contact` SET phone='91".$_REQUEST['phone']."',address='".$_REQUEST['addr']."',gaddress='".$_REQUEST['toloc']."',name='".$_REQUEST['name']."'");	
	}
	
}else{
	if(is_numeric($addrId) && $addrId>0){
		$conn->query(" UPDATE `tbl_dlv_customer_contact`SET phone='91".$_REQUEST['phone']."',address='".$_REQUEST['addr']."',gaddress='".$_REQUEST['toloc']."',name='".$_REQUEST['name']."' WHERE id='".$addrId."'");	
	}
}
$conn->close();
 $contents						=	 get_web_page($config['api_url'].'broadcastToDriver',$requestData,'GET');
 if($contents['content']!=""){
 	//print_r($contents['content']); echo "--------------------------------";
 	get_web_page($config['api_url'].'updateUserState?state=FREE&userId='.$_SESSION['USERID'],array(),'GET');
 }
 echo $contents['content'];
?>
