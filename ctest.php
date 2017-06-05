<?php 
error_reporting(E_ALL);
set_time_limit(0);
$url = 'http://115.124.98.155:8090/TygrServices/services/getAllCarTypes';
//$url = 'http://www.titan.co.in:80/';
$ch = curl_init();
curl_setopt($ch, CURLOPT_TIMEOUT, 100);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_PORT, 8090);
//print_r($ch);
$data = curl_exec($ch);
echo curl_error($ch);
curl_close($ch);
echo $data;

echo exec('whoami',$output);
echo "jjjj==================================";
print_r($output);

function execInBackground($cmd) {
    if (substr(php_uname(), 0, 7) == "Windows"){
        pclose(popen("start /B ". $cmd, "r")); 
    }
    else {
        exec($cmd . " > /dev/null &");  
    }
} 
//echo http_response($url);
