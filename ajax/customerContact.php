<?php
/*
 * Created on Nov 10, 2016
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 include_once('../config/config.php');
 include_once('../config/database.php');
 include_once('../config/function.php');
 include_once('../config/query.php');
 	$_REQUEST['action']($conn);
 function getPhone($conn){
 	echo getCustomerPhoneByNo(trim($_REQUEST['term']),$conn);
 }
 function getAddrByPh($conn){
 	echo getAddressByPhone($conn,trim($_REQUEST['phone']));
 }
?>
