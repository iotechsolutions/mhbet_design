<?php
session_start(); //Start the session
if (!isset($_SESSION["UserName"])) { //If session not registered
    header("location:Login/login.php"); // Redirect to login.php page
} else //Continue to current page
    header('Content-Type: text/html; charset=utf-8');
include 'side-menu.php';
include_once('../php/Account.php');
//Call the Info class
$accountObj = new Account();

//Update Info
if (isset($_POST['Reset'])) {
    $password = $_POST["password"];
	$accountObj->resetPassword($password);
}
?>
<!-- MAIN -->
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="panel panel-headline col-md-10">
                <div class="row">
                    <div class="col-md-6 pa-5">
                        <div class="panel-heading">
                            <h3 class="panel-title">Reset Password</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <form method="post" enctype="multipart/form-data" action="reset-password.php">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        <div class="navbar-btn-right">
                            <button class="btn btn-success" type="submit" name="Reset">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>
</div>
</div>
<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->
<!-- END WRAPPER -->
<!-- Javascript -->
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/scripts/klorofil-common.js"></script>

<div class="clearfix"></div>
<footer>
    <div class="container-fluid">
        <p class="copyright">&copy; 2023 <a href="https://www.iotechet.com/" target="_blank">IO Tech Solutions</a>. All
            Rights Reserved.</p>
    </div>
</footer>
</div>
</body>

</html>