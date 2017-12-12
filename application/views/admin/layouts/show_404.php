<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Video Site - 404</title>
        <base href="<?php echo base_url() ?>">
        
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
        <link href="<?php echo DEFAULT_ADMIN_CSS_PATH ?>icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="<?php echo DEFAULT_ADMIN_CSS_PATH ?>bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo DEFAULT_ADMIN_CSS_PATH ?>core.css" rel="stylesheet" type="text/css">
        <link href="<?php echo DEFAULT_ADMIN_CSS_PATH ?>components.css" rel="stylesheet" type="text/css">
        <link href="<?php echo DEFAULT_ADMIN_CSS_PATH ?>colors.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->

        <!-- Core JS files -->
        <script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH ?>plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH ?>core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH ?>core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH ?>plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->
        <!-- Theme JS files -->
        <script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH ?>core/app.js"></script>
        <!-- /theme JS files -->
    </head>

    <body class="login-container">

        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo site_url() ?>">VideoSite.com</a>

                <ul class="nav navbar-nav pull-right visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                </ul>
            </div>

            <div class="navbar-collapse collapse" id="navbar-mobile">
                <?php if ($this->session->userdata('admin')['id'] != '') { ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown dropdown-user">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                <?php if ($this->session->userdata('admin')['avatar'] != '') { ?>
                                        <img src="<?php echo DEFAULT_USER_IMAGE_PATH. $this->session->userdata('admin')['avatar']?>" alt="">
                                <?php } else { ?>
                                    <img src="<?php echo base_url('assets/admin/images/placeholder.jpg') ?>" alt="">
                                <?php } ?>
                                <span><?php echo $this->session->userdata('admin')['fname'] . ' ' . $this->session->userdata('admin')['lname'] ?></span>
                                <i class="caret"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="<?php echo site_url('admin/profile') ?>"><i class="icon-cog5"></i> Account settings</a></li>
                                <li><a href="<?php echo site_url('admin/logout'); ?>"><i class="icon-switch2"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main content -->
                <div class="content-wrapper">
                    <!-- Content area -->
                    <div class="content">
                        <!-- Error title -->
                        <div class="text-center content-group">
                            <h1 class="error-title">404</h1>
                            <h5>Oops, an error has occurred. Page not found!</h5>
                        </div>
                        <!-- /error title -->
                        <!-- Error content -->
                        <div class="row">
                            <div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
                                <form action="#" class="main-search">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <a href="<?php echo site_url('admin/dashboard') ?>" class="btn btn-primary btn-block content-group"><i class="icon-circle-left2 position-left"></i> Go to Dashboard</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /error wrapper -->
                        <!-- Footer -->
                        <div class="footer text-muted text-center">
                            &copy;Copyright 2017. <a href="<?php echo site_url('admin/dashboard')?>">VideoSite.com</a>, All Rights Reserved
                        </div>
                        <!-- /footer -->
                    </div>
                    <!-- /content area -->
                </div>
                <!-- /main content -->
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
    </body>
</html>
