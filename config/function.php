<?php
/*
 * Created on 20-Sep-2016
 *
 * Created By Moloy
 * Common page to define common functions
 */
 function get_web_page($url='',$param=array(),$method='GET') {  
	  $options 		= 	array(
					        CURLOPT_RETURNTRANSFER 		=> true,   // return web page
					        CURLOPT_HEADER        		=> false,  // don't return headers
					        CURLOPT_FOLLOWLOCATION 		=> true,   // follow redirects
					        CURLOPT_MAXREDIRS      		=> 10,     // stop after 10 redirects
					        CURLOPT_ENCODING       		=> "",     // handle compressed
					        CURLOPT_AUTOREFERER    		=> true,   // set referrer on redirect
					        CURLOPT_CONNECTTIMEOUT 		=> 120,    // time-out on connect
					        CURLOPT_TIMEOUT        		=> 120
					    ); 
	if(empty($param)){
		if($method=='POST'){
			$options[CURLOPT_POST]					=	true;
		}
	}else{
	  	$query		=	http_build_query($param);
	  	if($method=='GET'){
	  		$url  	.= 	"?".$query;
	  	}else{
	  		$options[CURLOPT_POST]					=	true;
	  		$options[CURLOPT_POSTFIELDS]				=	$query;
	  	}
	  }


    $ch = curl_init($url);
    curl_setopt_array($ch, $options);

    $returnArray['content']  = curl_exec($ch);
    $returnArray['headerInfo']=curl_getinfo($ch);

    curl_close($ch);

    return $returnArray;
}
function redirect($url=""){
	if(trim($url)!=""){
		header('Location:'.$url);
		echo '<script>window.location.href="'.$url.'";</script>';
		exit();
	}
}
function loginCheck($config){
	if(!isset($_SESSION['USERID']) || trim($_SESSION['USERID'])==""){
		redirect($config['base_url']);	
	}
}
function loginCheckNoRedirection($config){
	if(!isset($_SESSION['USERID']) || trim($_SESSION['USERID'])==""){
		return false;	
	}else{
		return true;
	}
}
?>
