<?php
session_start(); //Start the session
if (!isset($_SESSION["UserName"])) { //If session not registered
    header("location:Login/login.php"); // Redirect to login.php page
}
include 'side-menu.php';
include_once('../php/Info.php');
//Call the Info class
$infoObj = new Info();
$accept = $infoObj->viewInfo();
$aboutInfo = isset($accept[1]) ? $accept[1] : "";
$missionInfo = isset($accept[2]) ? $accept[2] : "";
$visionInfo = isset($accept[3]) ? $accept[3] : "";
//Update Info
if (isset($_POST['Update'])) {
    $about = isset($_POST["About"]) ? $_POST["About"]: "";
    $mission = $_POST["Mission"];
    $vision = $_POST["Vision"];
    $infoObj->updateInfo($about, $mission, $vision);
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
                            <h3 class="panel-title">About Page Description</h3>
                        </div>
                    </div>
                    <div class="col-md-6 pa-5">
                        <div class="panel-heading">
                            <div class=" navbar-btn-right">
                                <a class="btn btn-success update-pro" href="#add" data-toggle="modal" name="Set" title="Edit about section" onclick="openAdd()"><i class="fa fa-edit"></i> <span>Edit
                                        About Section</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-headline col-md-10">
                    <div class="panel-body">

                        <h3 class="panel-title"><b>About</b></h3>

                        <?php
                        if (isset($aboutInfo[0])) {
                            echo "<p>{$aboutInfo[0]}</p>";
                        }
                        ?>
                    </div>
                </div>
                <div class="panel panel-headline col-md-10">
                    <div class="panel-body">

                        <h3 class="panel-title"><b>Mission</b></h3>

                        <?php
                        if (isset($missionInfo[0])) {
                            echo "<p>{$missionInfo[0]}</p>";
                        }
                        ?>
                    </div>
                </div>

                <div class="panel panel-headline col-md-10">
                    <div class="panel-body">

                        <h3 class="panel-title"><b>Vision</b></h3>

                        <?php
                        if (isset($visionInfo[0])) {
                            echo "<p>{$visionInfo[0]}</p>";
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal" id="add" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Edit About Section</h3>
                        </div>
                        <div class="panel-body">
                            <form method="post" enctype="multipart/form-data" action="about.php">
                                <label>About</label>
                                <textarea class="form-control" placeholder="textarea" rows="4" name="About"> <?php
                                                                                                                echo $aboutInfo[0];
                                                                                                                ?></textarea><br>
                                 <label>Mission</label>
                                 <textarea class="form-control" placeholder="textarea" rows="4" name="Mission"> <?php
                                                                                                                echo $missionInfo[0];
                                                                                                                ?></textarea><br>

                                <label>Vision</label>        
                                <textarea class="form-control" placeholder="textarea" rows="4" name="Vision"> <?php
                                                                                                                echo $visionInfo[0];
                                                                                                                ?></textarea><br>
                                <div class="navbar-btn-right">
                                    <button class="btn btn-success" type="submit" name="Update">Save</button>
                                    <button class="btn btn-danger" onclick="closeAdd()">Cancel</button>
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
<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN -->
<!-- END WRAPPER -->
<!-- Javascript -->
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/scripts/klorofil-common.js"></script>
<script>
    function openAdd() {
        alert("bye");
        var add = document.getElementById("add");
        add.style.display = "block";
    }

    function openModal() {
        var modal = document.getElementById("modal");
        modal.style.display = "block";
    }

    function closeAdd() {
        var modal = document.getElementById("add");
        add.style.display = "none";
    }
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