<?php
/*
 * Created on 21-Sep-2016
 *
 * Created By Moloy
 * ajax page to fetch driver location
 */
 include_once('../config/config.php');
 //include_once('../config/database.php');
 include_once('../config/function.php');
 $responseData					=	array();	
 $contents						=	 get_web_page($config['api_url'].'findDriverForDelivery?latitude='.$_REQUEST['lat'].'&longitude='.$_REQUEST['lng'].'&cartype=4',array(),'GET');
 if(empty($contents)){
 	
 }else{
	 $decomContents				=	json_decode($contents['content']);
	 if($decomContents->success==true && isset($decomContents->drivers)){
	 	if(count($decomContents->drivers)==1){
	 		$responseData[]		=	array(
										'lat'			=>	$decomContents->drivers->latitude,
										'lng'			=>	$decomContents->drivers->longitude,
										'car'			=>	$decomContents->drivers->carNo,
										'name'			=>	$decomContents->drivers->driverName,
										'phone'			=>	$decomContents->drivers->driverPhoneNumber
									);
	 	}else{
		 	for($i=0;$i<count($decomContents->drivers);$i++){
		 		$responseData[]	=	array(
										'lat'			=>	$decomContents->drivers[$i]->latitude,
										'lng'			=>	$decomContents->drivers[$i]->longitude,
										'car'			=>	$decomContents->drivers[$i]->carNo,
										'name'			=>	$decomContents->drivers[$i]->driverName,
										'phone'			=>	$decomContents->drivers[$i]->driverPhoneNumber
									);
		 	}
	 	}
	 }else{
	 	$responseData			=	array();	
	 }	
	 
 }
 echo json_encode($responseData);
?>
