<?php
error_reporting(0);
session_start(); //Start the session
if (!isset($_SESSION["UserName"])) { //If session not registered
    header("location:Login/login.php"); // Redirect to login.php page
} else //Continue to current page
    header('Content-Type: text/html; charset=utf-8');
include_once('../php/Project.php');
include 'side-menu.php';
$projectObj = new Project();
if (isset($_POST['Add']) || isset($_POST['Update'])) {
    $paths = [];
    $images = [];
    $pathOlds = [];
    if (($_FILES['data1']['name']) != null) {
        $path1 = str_replace(' ', '', $_FILES['data1']['name']);
        array_push($paths, $path1);
        $image1 = $_FILES['data1']["tmp_name"];
        array_push($images, $image1);
    } else {
        $path1 = "";
        array_push($paths, $path1);
        array_push($images, "");
    }
    $oldPath1 = $_POST["oldPath1"];
    if (($_FILES['data2']['name']) != null) {
        $path2 = str_replace(' ', '', $_FILES['data2']['name']);
        array_push($paths, $path2);
        $image2 = $_FILES['data2']["tmp_name"];
        array_push($images, $image2);
    } else {
        $path2 = "";
        array_push($paths, $path2);
        array_push($images, "");
    }
    $oldPath2 = $_POST["oldPath2"];
    if (($_FILES['data3']['name']) != null) {
        $path3 = str_replace(' ', '', $_FILES['data3']['name']);
        array_push($paths, $path3);
        $image3 = $_FILES['data3']["tmp_name"];
        array_push($images, $image3);
    } else {
        $path3 = "";
        array_push($paths, $path3);
        array_push($images, "");
    }
    $oldPath3 = $_POST["oldPath3"];
    $pathOlds = [$oldPath1, $oldPath2, $oldPath3];
}
if (isset($_POST['Add'])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $projectObj->addProject($name, $description, $paths, $images);
} else if (isset($_POST['Update'])) {
    echo $paths[0];
    $id = $_POST["idUpdate"];
    $name = $_POST["nameUpdate"];
    $description = $_POST["descriptionUpdate"];
    $projectObj->updateProject($id, $name, $description, $paths, $images, $pathOlds);
} else if (isset($_POST['Remove'])) {
    $id = $_POST["ID"];
    $projectObj->removeProject($id, $pathOlds);
}
?>
<style>
    .modal {
        overflow: scroll;
    }

    .box {
        /* color: #fff; */
        /* background: #2b3c4e; */
        font-family: 'Ubuntu', sans-serif;
        overflow: hidden;
        position: relative;
        transition: all 0.3s ease-in-out;
        border: 2px;
        height: 200px;
        padding: 10px;
        margin: 6px;
    }

    .box:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
    }

    .box img {
        width: 100%;
        height: auto;
        transition: all 0.3s ease;
    }

    .box:hover img {
        opacity: 0.6;
        filter: grayscale(100%);
    }

    .box .box-content {
        color: #fff;
        background: grey;
        text-align: right;
        width: 100%;
        padding: 15px 15px 15px 60px;
        transform: translateY(-50%) scaleY(0);
        position: absolute;
        top: 50%;
        right: 0;
        transition: all 0.3s ease-in-out;
    }

    .box:hover .box-content {
        transform: translateY(-50%) scaleY(1);
    }

    .box .title {
        font-size: 15px;
        font-weight: 500;
        letter-spacing: 1px;
        font-family: Georgia, 'Times New Roman', Times, serif;
        margin: 0 0 4px;
    }

    .box .post {
        font-size: 15px;
        font-style: italic;
        text-transform: capitalize;
        margin: 0 0 5px;
        display: block;
    }

    .box .icon {
        padding: 0;
        margin: 0;
        list-style: none;
        transform: translate(-100%, -50%);
        position: absolute;
        top: 50%;
        left: 0;
        transition: all 0.3s ease-in-out;
    }

    .box:hover .icon {
        transform: translate(0, -50%);
    }

    .box .icon li a {
        color: #222f3d;
        background: #fff;
        font-size: 20px;
        text-align: center;
        line-height: 40px;
        height: 40px;
        width: 40px;
        display: block;
        transition: all 0.3s ease;
    }

    .box .icon li a:hover {
        box-shadow: 0 0 5px #222f3d inset;
    }

    @media only screen and (max-width:990px) {
        .box {
            margin: 0 0 30px;
        }
    }
</style>
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="panel panel-headline">
                <div class="row">
                    <div class="col-md-6 pa-5">
                        <div class="panel-heading">
                            <h3 class="panel-title">Projects</h3>

                            <!-- <p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p> -->
                        </div>
                    </div>
                    <div class="col-md-6 pa-5">
                        <div class="panel-heading">
                            <div class=" navbar-btn-right">
                                <a class="btn btn-success" href="#add" data-toggle="modal" name="Set" title="Add Project" onclick="openAdd()" title="Upgrade to Pro"><i class="fa fa-plus"></i> <span>New Project</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                        $projects = $projectObj->viewProject();
                        if (count($projects) > 0) {
                            // Iterate through each project
                            foreach ($projects as $project) {
                                echo '<div class="col-md-4">';
                                echo '<div class="profile-header">';
                                echo '<div class="profile-main">';
                                echo '<img src=' . $project['Path1'] . ' alt="Avatar" style="width: -webkit-fill-available; height: -webkit-fill-available;">';
                                echo '<h3 class="name">' . $project['name'] . '</h3>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="profile-detail">';
                                echo '<div class="profile-info">';
                                echo '<h4 class="heading">' . $project['name'] . '</h4>';
                                echo '<p>' . $project['Description'] . '</p>';
                                echo '   <a  name="Set" data-id="' . $project['id'] . '" data-name="' . $project['name'] . '" data-description="' . $project['description'] . '" data-path1="' . $project['Path1'] . '" data-path2="' . $project['Path2'] . '" data-path3="' . $project['Path3'] .'" class="modal-trigger" title="show" style="margin-left:auto; " onclick="openEdit()"><i class="fa fa-edit" style="color: black"></i></a>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT -->
    <div class="modal" id="add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add Project</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" enctype="multipart/form-data" action="projects.php">
                            <input type="text" class="form-control" placeholder="Name" name="name" required><br>
                            <textarea class="form-control" name="description" placeholder="Description" rows="4" required></textarea><br>
                            <label style="font-weight:100"> Image 1 (Main) </label>
                            <input type="file" class="form-control" placeholder="Image 1" name="data1" required><br>
                            <label style="font-weight:100"> Image 2</label>
                            <input type="file" class="form-control" placeholder="Image 2" name="data2"><br>
                            <label style="font-weight:100"> Image 3 </label>
                            <input type="file" class="form-control" placeholder="Image 3" name="data3"><br>
                            <div class="navbar-btn-right">
                                <button class="btn btn-success" type="submit" name="Add">Save</button>
                                <!-- <button class="btn btn-danger" onclick="closeAdd()">Cancel</button> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="update" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit Project</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" enctype="multipart/form-data" action="projects.php">
                            <input type="text" id="ID" class="form-control" placeholder="ID" name="idUpdate" readonly><br>
                            <label style="font-weight:100"> Project </label> <br>
                            <div>
                                <img id="path1" src="" style="width:-webkit-fill-available" />
                                <input type="file" id="" class="form-control" placeholder="Image 1" name="data1"><br>
                                <input type="text" id="oldPath1" class="form-control" placeholder="Image 1" name="oldPath1" style=""><br>
                            </div>
                            <div>
                                <img id="path2" src="" style="width:-webkit-fill-available" />
                                <input type="file" id="" class="form-control" placeholder="Image 2" name="data2"><br>
                                <input type="text" id="oldPath2" class="form-control" placeholder="Image 2" name="oldPath2" style="display:none"><br>
                            </div>
                            <div>
                                <img id="path3" src="" style="width:-webkit-fill-available" />
                                <input type="file" id="" class="form-control" placeholder="Image 3" name="data3"><br>
                                <input type="text" id="oldPath3" class="form-control" placeholder="Image 3" name="oldPath3" style="display:none"><br>
                            </div>
                            <input type="text" id="nameUp" class="form-control" placeholder="Name" name="nameUpdate"><br>
                            <textarea class="form-control" id="description" name="descriptionUpdate" placeholder="Description" rows="4"></textarea><br>
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
    <div class="modal" id="remove" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Delete Project</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" enctype="multipart/form-data" action="projects.php">
                            <input type="hidden" id="ID" name="ID" class="form-control"><br>
                            Are you sure you want to delete <strong><input type="text" id="ProjectTitle" style="border:none; outline:none;" name="ProjectTitle"></strong><br>
                            <div class="navbar-btn-right">
                                <button class="btn btn-danger" onclick="closeAdd()">Cancel</button>
                                <button class="btn btn-success" type="submit" name="Remove">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN -->
<div class="clearfix"></div>
<footer>
    <div class="container-fluid">
        <p class="copyright">&copy; 2023 <a href="https://www.iotechet.com/" target="_blank">IO Tech Solutions</a>. All
            Rights Reserved.</p>
    </div>
</footer>
</div>
<!-- END WRAPPER -->
<!-- Javascript -->
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="assets/vendor/chartist/js/chartist.min.js"></script>
<script src="assets/scripts/klorofil-common.js"></script>
<script>
    function openAdd() {
        var add = document.getElementById("add");
        add.style.display = "block";
    }

    function openEdit() {
        var update = document.getElementById("update");
        update.style.display = "block";
    }

    function openModal() {
        var modal = document.getElementById("modal");
        modal.style.display = "block";
    }

    function closeAdd() {
        var modal = document.getElementById("add");
        add.style.display = "none";
    }

    function removeProject() {
        var remove = document.getElementById("remove");
        remove.style.display = "block";
    }
    $(document).on("click", ".modal-trigger-remove", function() {
        var ID = $(this).data('id');
        var title = $(this).data('title');
        $(".modal-content #ID").val(ID);
        $("#ProjectTitle").val(title);
    });
    $(document).on("click", ".modal-trigger", function() {
        $(".modal-content #ID").val($(this).data('id'));
        $("#nameUp").val($(this).data('name'));
        $("#description").val($(this).data('description'));
        $("#path1").attr('src', $(this).data('path1'));
        $("#path2").attr('src', $(this).data('path2'));
        $("#path3").attr('src', $(this).data('path3'));

        $("#oldPath1").val($(this).data('path1'));
        $("#oldPath2").val($(this).data('path2'));
        $("#oldPath3").val($(this).data('path3'));
    });
</script>
</body>
<!-- Mirrored from demo.thedevelovers.com/dashboard/klorofil-v2.0/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 20 Jul 2021 18:56:10 GMT -->

</html>