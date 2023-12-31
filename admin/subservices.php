<?php
session_start(); //Start the session
if (!isset($_SESSION["UserName"])) { //If session not registered
    header("location:Login/login.php"); // Redirect to login.php page
} else //Continue to current page
    header('Content-Type: text/html; charset=utf-8');
include 'side-menu.php';
include_once('../php/Service.php');
//Call the Info class
$serviceObj = new Service();
//Save Info
if (isset($_POST['Save'])) {
    $name = isset($_POST["Name"]) ? $_POST["Name"] : "";
    $description = $_POST["Description"];
    $serviceType = $_POST["Service"];
    $serviceObj->addSubService($name, $description, $serviceType);
}
//Update Info
if (isset($_POST['Update'])) {
    $id = $_POST["idUpdate"];
    $name = $_POST["nameUpdate"];
    $description = $_POST["descriptionUpdate"];
    $serviceUpdate = $_POST["serviceUpdate"];
    $serviceObj->updateSubService($id, $name, $description, $serviceUpdate);
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
                            <h4 class="panel-title">Security Service Management</h4>
                            <!-- <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p> -->
                        </div>
                    </div>
                    <div class="col-md-6 pa-5">
                        <div class="panel-heading">
                            <div class=" navbar-btn-right">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 pa-5">
                        <div class="panel-heading">
                            <div class=" navbar-btn-right">
                                <a class="btn btn-success update-pro" href="#add" data-toggle="modal" name="Set" title="Edit about section" onclick="openAdd()"><i class="fa fa-plus"></i> <span>Add Services</span></a>
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
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Service</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $subservices = $serviceObj->viewSubService();
                                    $services = $serviceObj->viewService();
                                    // Iterate through each product
                                    foreach ($subservices as $index => $subservice) { ?>
                                        <tr>
                                            <td><?php echo ++$index; ?></td>
                                            <td><?php echo $subservice['name']; ?></td>
                                            <td><?php echo $subservice['description']; ?></td>
                                            <td><?php echo $subservice['sname']; ?></td>
                                            <td> <a href="#update" data-toggle="modal" name="Set" data-id=<?php echo $subservice['id']; ?> data-name=<?php echo $subservice['name']; ?> data-service=<?php echo $subservice['sid']; ?> data-description=<?php echo $subservice['description']; ?> class="modal-trigger" title="show" style="margin-left:auto; " onclick="openUpdate()"><i class="fa fa-edit" style="color: black"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add Service</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" enctype="multipart/form-data" action="subservices.php">
                            <input type="text" class="form-control" placeholder="Name" name="Name" required><br>
                            <textarea class="form-control" name="Description" placeholder="Description" rows="4" required></textarea><br>
                            <select class="form-control" required name="Service">
                                <?php foreach ($services as $index => $service) { ?>
                                    <option value="<?php echo $service['id']; ?>" name="Service"><?php echo $service['name']; ?></option>
                                <?php } ?>
                            </select>
                            <div class="navbar-btn-right">
                                <button class="btn btn-success" type="submit" name="Save">Save</button>
                                <button class="btn btn-danger" onclick="closeAdd()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Update -->
    <div class="modal" id="update" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Update Service</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" enctype="multipart/form-data" action="subservices.php">
                            <input type="text" class="form-control" id="id" placeholder="id" name="idUpdate"> <br>
                            <label>Title</label>
                            <input type="text" class="form-control" id="title" placeholder="Title" name="nameUpdate"> <br>
                            <label>Main Service</label>
                            <select class="form-control" required id="serviceSelect" name="serviceUpdate">
                                <?php foreach ($services as $index => $service) { ?>
                                    <option value="<?php echo $service['id']; ?>" name="serviceUpdate"><?php echo $service['name']; ?></option>
                                <?php } ?>
                            </select>
                            <label>Description</label>
                            <textarea class="form-control" id="description" placeholder="textarea" rows="4" name="descriptionUpdate"> </textarea><br>

                            <div class="navbar-btn-right">
                                <button class="btn btn-success" type="submit" name="Update">Update</button>
                                <button class="btn btn-danger" onclick="closeAdd()">Cancel</button>
                            </div>
                        </form>
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
    function openAdd() {
        var add = document.getElementById("add");
        add.style.display = "block";
    }

    function openUpdate() {
        var update = document.getElementById("update");
        update.style.display = "block";
    }

    function closeAdd() {
        var add = document.getElementById("add");
        var update = document.getElementById("update");
        add.style.display = "none";
        update.style.display = "none";
    }
    $(document).on("click", ".modal-trigger", function() {
        $(".modal-content #id").val($(this).data('id'));
        $("#title").val($(this).data('name'));
        $("#description").val($(this).data('description'));
        var desiredServiceValue = $(this).data('service');
        // Set the selected option based on the desired value
        $("#serviceSelect").val(desiredServiceValue);
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
<!-- Mirrored from demo.thedevelovers.com/dashboard/klorofil-v2.0/panels.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 20 Jul 2021 18:57:03 GMT -->

</html>