<?php
include_once('../../php/Account.php');
//error_reporting(0);
session_start();
//Call the Account class
$accObj = new Account();
//First time logging in
if (isset($_SESSION['UserName'])) {
  $accObj->setUserName($_SESSION['UserName']);
  $uname = $_SESSION['UserName'];
}
//Forgot password
if (isset($_GET['key']) && isset($_GET['token'])) {
  $uname = $_GET['uname'];
  $email = $_GET['key'];
  $token = $_GET['token'];
  $expDate = $_GET['expdate'];
  $curDate = date("Y-m-d");
}
//Resetting the password
if (isset($_POST['Reset'])) {
  $newPassword = $_POST["NewPassword"];
  $confirmPassword = $_POST["ConfirmPassword"];
  if ($newPassword == $confirmPassword) {
    $accObj->setUserName($_POST["UserName"]);
    $accObj->setPassword($newPassword);
    $accObj->firstTimeLogin();
  } else {
    echo "<script>alert('Passwords Dont Match');
		document.location = '/resetPassword.php' </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Reset Password</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
  <?php
  //If the expire date is greater than current date the token of forgot password is valid.
  if ($expDate >= $curDate) { ?>
   	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<form class="login100-form validate-form flex-sb flex-w" action="ResetPassword.php" method="POST">
					<span class="login100-form-title p-b-32">
						Account Reset
					</span>
					<span class="txt1 p-b-11">
						Username
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Username is required">
						<input class="input100" type="text" name="UserName" >
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						New Password
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="NewPassword" >
						<span class="focus-input100"></span>
					</div>
                    <span class="txt1 p-b-11">
						Confirm Password
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="ConfirmPassword" >
						<span class="focus-input100"></span>
					</div>
					
				
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn" name="Reset">
							Reset
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="dropDownSelect1"></div>
<?php }
  //If the token expires then the user should create a new token
  else {
    echo "<p>This forget password link has been expired</p>";
  }
  ?>
	
	<!--===============================================================================================-->
		<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
		<script src="vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
		<script src="vendor/bootstrap/js/popper.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
		<script src="vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
		<script src="vendor/daterangepicker/moment.min.js"></script>
		<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
		<script src="vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
		<script src="js/main.js"></script>
</body>
</html>