<?php
/*
 * Created on 25-Sep-2016
 *
 * Created By Moloy
 * Page for session destroy and redirect to login page
 */
 include_once('./config/config.php');
 include_once('./config/function.php');
 if(isset($_SESSION) && !empty($_SESSION)){
 	session_destroy();
 	redirect($config['base_url']);
 }else{
 	redirect($config['base_url']);
 }
?>
