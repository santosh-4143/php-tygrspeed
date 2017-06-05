<?php
/*
 * Created on 22-Sep-2016
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 include_once('../config/config.php');
 //include_once('../config/database.php');
 include_once('../config/function.php');
 $responseData					=	array();
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
 										'phoneNo'				=>	' 91'.$_REQUEST['phone']
 									);	
 $contents						=	 get_web_page($config['api_url'].'broadcastToDriver',$requestData,'GET');
 if($contents['content']!=""){
 	get_web_page($config['api_url'].'updateUserState?state=FREE&userId='.$_SESSION['USERID'],array(),'GET');
 }
 echo $contents['content'];
?>
