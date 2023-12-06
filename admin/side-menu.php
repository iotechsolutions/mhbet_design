<!doctype html>
<html lang="en">

<head>
    <title>Dashboard | Mhbet Design</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/linearicons/style.css">
    <link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="assets/css/demo.css">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
</head>

<body>
    <!-- WRAPPER -->
    <div id="wrapper">
        <!-- NAVBAR -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div style=" padding-top: 11px;  padding-bottom: 10px;" class="brand">
                <a href="about.php"><img src="assets/img/Mhbet logo.png" style="width: 50%" alt="Mhbet Design Logo" class="img-responsive logo"></a>
            </div>
            <div class="container-fluid">
                <div id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="assets/img/user.png" class="img-circle" alt="Avatar">
                                <span><?php echo "" . $_SESSION["UserName"] . ""; ?> </span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                            <ul class="dropdown-menu">
                                <!-- <li><a href="#"><i class="lnr lnr-envelope"></i> <span>Message</span></a></li> -->
                                <li><a href="reset-password.php"><i class="lnr lnr-cog"></i> <span>Reset
                                            Password</span></a></li>
                                <li><a href="Login/logout.php"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- END NAVBAR -->
        <!-- LEFT SIDEBAR -->
        <div id="sidebar-nav" class="sidebar">
            <div class="sidebar-scroll">
                <nav>
                    <ul class="nav">
                        <li><a href="about.php" class=""><i class="lnr lnr-code"></i> <span>About Page</span></a></li>
                        <li><a href="values.php" class=""><i class="lnr lnr-bullhorn"></i>
                                <span>Values</span></a>
                        </li>
                        <li><a href="services.php" class=""><i class="lnr lnr-layers"></i> <span>Services</span></a>
                        </li>
                        <li><a href="subservices.php" class=""><i class="lnr lnr-layers"></i> <span>SubServices</span></a>
                        </li>

                        <li><a href="category.php" class=""><i class="lnr lnr-cog"></i> <span>Category</span></a>
                        </li>
                        <li><a href="gallery.php" class=""><i class="lnr lnr-picture"></i>
                                <span>Gallery</span></a>
                        </li>
                        <li><a href="products.php" class=""><i class="lnr lnr-tag"></i> <span>Products</span></a>
                        </li>
                        <li><a href="projects.php" class=""><i class="lnr lnr-laptop"></i> <span>Projects</span></a>
                        </li>
                        <li><a href="subscriber.php" class=""><i class="lnr lnr-envelope"></i>
                                <span>Subscribers</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- END LEFT SIDEBAR -->