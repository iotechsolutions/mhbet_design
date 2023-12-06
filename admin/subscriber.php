<?php
session_start(); //Start the session
if (!isset($_SESSION["UserName"])) { //If session not registered
    header("location:Login/login.php"); // Redirect to login.php page
} else //Continue to current page
    header('Content-Type: text/html; charset=utf-8');
include 'side-menu.php';
include_once('../php/Subscription.php');
include_once("../php/Config.php");
$subscribeObj = new Subscription();
$subscribe_form = $subscribeObj->viewSubscription();
$mailObj = new EmailConfig();
$mail = $mailObj->getEmailConfig();
if (isset($_POST['SendAll'])) {
    foreach ($subscribe_form as $index => $subscribe) {
        $emailToCC = $subscribe['Email'];
        $mail->addCC($emailToCC);
    }
    $mail->Subject = $_POST['subject'];
    $mail->IsHTML(true);
    $mail->Body = $_POST['message'];
    if ($mail->send()) {
        echo "<script>alert('Email Sent Successfully!');</script>";
    } else {
        echo "<script>alert('Email Not Sent! Check your connection.');</script>";
    }
}
if (isset($_POST['Send'])) {
    $mail->addCC($_POST['email']); // Add the email address to the CC list
    $mail->Subject = $_POST['subject'];
    $mail->IsHTML(true);
    $mail->Body = $_POST['message'];
    if ($mail->send()) {
        echo "<script>alert('Email Sent Successfully!');</script>";
    } else {
        echo "<script>alert('Email Not Sent! Check your connection.');</script>";
    }
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
                            <h4 class="panel-title">Subscribers</h4>
                            <!-- <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p> -->
                        </div>
                    </div>
                    <div class="col-md-6 pa-5">
                        <div class="panel-heading">
                            <div class=" navbar-btn-right">
                                <a class="btn btn-success update-pro" href="#email" data-toggle="modal" name="Set"
                                    title="Email All" onclick="openEmail()"><i class="fa fa-envelope"></i> <span>Email
                                        All</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <h4></h4>
                    <div class="panel">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($subscribe_form as $index => $subscribe) { ?>
                                    <tr>
                                        <td><?php echo ++$index; ?></td>
                                        <td><?php echo $subscribe['Email']; ?></td>
                                        <td>
                                            <a class="btn btn-success modal-trigger" name="Set"
                                                data-email="<?php echo $subscribe['Email']; ?>"
                                                onclick="openEmailOne()"><i class="fa fa-envelope"></i> Email</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal" id="email" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Email All</h3>
                                    </div>
                                    <div class="panel-body">
                                        <form method="post" enctype="multipart/form-data" action="subscriber.php">
                                            <input type="text" class="form-control" placeholder="Subject" name="subject"
                                                required><br>
                                            <textarea class="form-control" placeholder="textarea" rows="4"
                                                name="message"></textarea><br>
                                            <div class="navbar-btn-right">
                                                <button class="btn btn-success" type="submit"
                                                    name="SendAll">Send</button>
                                                <button class="btn btn-danger" onclick="closeEmail()">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal end -->
                    <div class="modal" id="emailOne" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Email</h3>
                                    </div>
                                    <div class="panel-body">
                                        <form method="post" enctype="multipart/form-data" action="subscriber.php">
                                            <input type="text" class="form-control" id="emailToSend" placeholder="Email"
                                                name="email" required readonly><br>
                                            <input type="text" class="form-control" placeholder="Subject" name="subject"
                                                required><br>
                                            <textarea class="form-control" placeholder="textarea" rows="4"
                                                name="message"></textarea><br>
                                            <div class="navbar-btn-right">
                                                <button class="btn btn-success" type="submit" name="Send">Send</button>
                                                <button class="btn btn-danger" onclick="closeEmailOne()">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END WRAPPER -->
<!-- Javascript -->
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/scripts/klorofil-common.js"></script>
<script>
function openEmail() {
    var email = document.getElementById("email");
    email.style.display = "block";
}

function closeEmail() {
    var email = document.getElementById("email");
    email.style.display = "none";
}

function openEmailOne() {
    var email = document.getElementById("emailOne");
    email.style.display = "block";
}

function closeEmailOne() {
    var email = document.getElementById("emailOne");
    email.style.display = "none";
}
$(document).on("click", ".modal-trigger", function() {
    $("#emailToSend").val($(this).data('email'));
});
</script>
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