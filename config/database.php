<?php
/*
 * Created on 19-Sep-2016
 *
 *  Created By Moloy
 * Data base Configuration File
 */
 $config['db_host']					=	"localhost";
 $config['db_userName']				=	"root";
 $config['db_password']				=	"#6M!08L)25C%";
 $config['db_name']					=	"db_tygrapp";
 $config['db_port']					=	3306;
 
 
 // Create connection 
 $conn = new mysqli($config['db_host'], $config['db_userName'], $config['db_password'],$config['db_name'],$config['db_port']);

// Check connection
if ($conn->connect_error) {
        die('Connect Error (' . $conn->connect_errno . ') '
            . $mysqli->connect_error);
}
?>
