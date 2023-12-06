<?php
session_start(); //Start the session
if (!isset($_SESSION["UserName"])) { //If session not registered
    header("location:Login/login.php"); // Redirect to login.php page
} else //Continue to current page
    header('Content-Type: text/html; charset=utf-8');
include 'side-menu.php';
include_once('../php/Values.php');
//Call the Info class
$valuesObj = new Values();
$values_form = $valuesObj->viewValues();
//Save Info
if (isset($_POST['Save'])) {
    $name = isset($_POST["Name"]) ? $_POST["Name"] : "";
    $description = $_POST["Description"];
    $valuesObj->addValues($name, $description);
}
//Update Info
if (isset($_POST['Update'])) {
    $id = $_POST["idUpdate"];
    $name = $_POST["nameUpdate"];
    $description = $_POST["descriptionUpdate"];
    $valuesObj->updateValues($id, $name, $description);
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
                            <h3 class="panel-title">Values</h3>
                        </div>
                    </div>
                    <div class="col-md-6 pa-5">
                        <div class="panel-heading">
                            <div class=" navbar-btn-right">
                                <a class="btn btn-success update-pro" href="#add" data-toggle="modal" name="Set" title="Edit about section" onclick="openAdd()"><i class="fa fa-plus"></i> <span>Add Values</span></a>
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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($values_form as $index => $values) { ?>
                                        <tr>
                                            <td><?php echo ++$index; ?></td>
                                            <td><?php echo $values['name'] ?></td>
                                            <td><?php echo $values['description']; ?></td>
                                            <td> <a  href="#update" data-toggle="modal" name="Set" data-id=<?php echo $values['id']; ?> data-name=<?php echo $values['name']; ?> data-description=<?php echo $values['description']; ?> class="modal-trigger" title="show" style="margin-left:auto; " onclick="openUpdate()"><i class="fa fa-edit" style="color: black"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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
                            <h3 class="panel-title">Add Values</h3>
                        </div>
                        <div class="panel-body">
                            <form method="post" enctype="multipart/form-data" action="values.php">
                                <label>Title</label>
                                <input type="text" class="form-control" placeholder="Title" name="Name"> <br>
                                <label>Description</label>
                                <textarea class="form-control" placeholder="textarea" rows="4" name="Description"> </textarea><br>

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
                            <h3 class="panel-title">Update Values</h3>
                        </div>
                        <div class="panel-body">
                            <form method="post" enctype="multipart/form-data" action="values.php">
                                <input type="text" class="form-control" id="id" placeholder="id" name="idUpdate"> <br>
                                <label>Title</label>
                                <input type="text" class="form-control" id="title" placeholder="Title" name="nameUpdate"> <br>
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