<?php 
	include_once('./config/config.php');
	include_once('./config/function.php');
	include_once('./config/database.php');
	
	if(isset($_POST['loginb'])){
		if(trim($_POST['username'])!="" && trim($_POST['password'])!=""){
			$sql 	= 	"SELECT `tbl_dlv_company_branch`.`user_id`,`tbl_dlv_company_branch`.`latitude`,`tbl_dlv_company_branch`.`longitude`," .
							"`tbl_dlv_company_branch`.`branch_name`,`tbl_dlv_company`.`company_name`,`tbl_dlv_branch_user`.`id` " .
						"FROM `tbl_dlv_branch_user` " .
						"JOIN `tbl_dlv_company_branch` ON `tbl_dlv_branch_user`.`branch_id`=`tbl_dlv_company_branch`.`id`" .
						"JOIN `tbl_dlv_company` ON `tbl_dlv_company_branch`.`company_id`=`tbl_dlv_company`.`id`" .
						"WHERE `username` = '".trim($_POST['username'])."' " .
							"AND BINARY `password`='".trim($_POST['password'])."'" .
							"AND `tbl_dlv_branch_user`.`status`='1'";
			$result = 	$conn->query($sql);
			if($result){
				while ($obj = $result->fetch_object()) {
       				$_SESSION['USERID']		=	$obj->user_id;
       				$_SESSION['LOGINID']	=	$obj->id;
       				$_SESSION['USERNAME']	=	trim($_POST['username']);
       				$_SESSION['BRANCHNAME']	=	$obj->company_name.", ".$obj->branch_name;
       				$_SESSION['LAT']		=	trim($obj->latitude);
       				$_SESSION['LNG']		=	trim($obj->longitude);
    			}
    			//* free result set */
    			$result->close();
			}
			if(!isset($_SESSION['USERID']) || trim($_SESSION['USERID'])==""){
					$errMsg					=	"You have entered wrong credentials.";
			}
			$conn->close();
		}else{
			$errMsg							=	"Please enter username or password.";
		}
	}
	if(isset($_SESSION['USERID']) && trim($_SESSION['USERID'])!=""){
		redirect($config['base_url'].'home.php');	
	}
?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Welcome to Tygr Speed</title>
    <link rel="stylesheet" href="<?php echo $config['base_url']; ?>css/reset.css">
    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
	<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="<?php echo $config['base_url']; ?>css/style.css">
  </head>

  <body>
<!-- Form Mixin-->
<!-- Input Mixin-->
<!-- Button Mixin-->
<!-- Pen Title-->
<div class="pen-title">
<div class="row text-center pad-top ">
            <div class="col-md-12 text-center">
            <img src="img/tygr_speed.png" class="img-responsive center-block" style="height:100px;">
            </div>
        </div>
 <!-- Form Module-->
<div class="module form-module">
  <div class="">
  </div>
  <div class="form">                      
    <h2>Login to your account</h2>
    <?php if(isset($errMsg)){?><span style="color:red;"><?php echo $errMsg;?></span><?php } ?>
    <form action="" method="post">
      <input type="text" placeholder="Username" name="username" required/>
      <input type="password" placeholder="Password" name="password" required/>
      <input type="submit" name="loginb" value="Login"/>
    </form>
  </div>

  </body>
</html>
