<?php
$role_id = $this->session->userdata['admin']['role_id'];
$sess_data  = $this->session->userdata('admin');
if ($this->session->userdata['admin']['avatar'] != '')
{
    $image = (string) base_url('uploads/avatars/' . $this->session->userdata['admin']['avatar']);
}
else
{
    $image = DEFAULT_IMAGE_PATH . "user/user-img.jpg";
}
?>
<!DOCTYPE html>
<html lang="en">        
    <?php $this->load->view('admin/layouts/layout_header'); ?>
    <body>
        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>"><img style="margin-top: -1px;height: 33px;width: 100px;" src="<?= DEFAULT_ADMIN_IMAGE_PATH ?>logo_admin.jpg" alt=""></a>

                <ul class="nav navbar-nav visible-xs-block">
                    <!-- <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li> -->
                    <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
            </div>

            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown dropdown-user">                       
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo $image ?>" alt="">
                            
                            <span><?php echo $sess_data['fname'] .' '. $sess_data['lname'];?></span>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?php echo base_url() . "admin/edit_profile" ?>"><i class="icon-pencil5"></i> Edit profile</a></li>
                            <li><a href="<?php echo base_url() . "admin/change_password" ?>"><i class="icon-lock2"></i> Change Password</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . 'admin/logout'; ?>"><i class="icon-switch2"></i> Logout</a></li>
                        </ul>                          
                    </li>
                </ul>
            </div>
        </div>
        <!-- /main navbar -->

        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main sidebar -->
                <div class="sidebar sidebar-main">
                    <div class="sidebar-content">                        
                        <!-- Main navigation -->
                        <div class="sidebar-category sidebar-category-visible">
                            <div class="category-content no-padding">
                                <?php
                                $controller = $this->router->fetch_class();
                                ?>
                                <ul class="navigation navigation-main navigation-accordion">

                                    <!-- Main -->                                    
<!--                                    <li class="<?php echo ($controller == 'dashboard') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . "admin/dashboard" ?>">
                                            <i class="icon-home4"></i> 
                                            <span>Dashboard</span>
                                        </a>
                                    </li>-->
                                    <!--Users-->
                                    <li class="<?php echo ($controller == 'users') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/users'; ?>">
                                            <i class="icon-users4"></i>
                                            <span>Users</span></a>
                                    </li>
                                    <!--Users-->
                                    
                                    <!--Users' Post-->
                                    <li class="<?php echo ($controller == 'userpost') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . "admin/userpost" ?>">
                                            <i class="icon-books"></i> 
                                            <span>Users' Post</span>
                                        </a>
                                    </li>
                                    <!--/Users' Post-->

                                    <!-- Categories Menu -->


                                    <li class="<?php echo (in_array($controller, ['categories', 'subcategories',])) ? 'active' : ''; ?>">
                                        <a href="#" class="has-ul"><i class="icon-server"></i> <span>Categories</span></a>
                                        <ul style="">
                                            <li class="<?php echo (in_array($controller, ['categories'])) ? 'active' : ''; ?>">
                                                <a href="<?php echo base_url() . 'admin/categories'; ?>">
                                                    <i class="icon-arrow-right32"></i>
                                                    Categories
                                                </a>
                                            </li>
                                            <li class="<?php echo (in_array($controller, ['sub_categories'])) ? 'active' : ''; ?>">
                                                <a href="<?php echo base_url() . 'admin/sub_categories'; ?>">
                                                    <i class="icon-arrow-right32"></i>
                                                    Sub Categories
                                                </a>
                                            </li>
                                        </ul>
                                    </li>


                                    <!-- USERS Menu -->

                                    
<!--                                    <li class="<?php echo (in_array($controller, ['doctor', 'patient', 'users'])) ? 'active' : ''; ?>">
                                        <a href="#" class="has-ul"><i class="icon-users4"></i> <span>Users</span></a>
                                        <ul style="">
                                            <li class="<?php echo (in_array($controller, ['patient'])) ? 'active' : ''; ?>">
                                                <a href="<?php echo base_url() . 'admin/patient'; ?>">
                                                    <i class="icon-arrow-right32"></i>
                                                    Patients
                                                </a>
                                            </li>
                                            <li class="<?php echo (in_array($controller, ['doctor'])) ? 'active' : ''; ?>">
                                                <a href="<?php echo base_url() . 'admin/doctor'; ?>">
                                                    <i class="icon-arrow-right32"></i>
                                                    Doctors
                                                </a>
                                            </li>-->
<!--                                            <li class="<?php echo (in_array($controller, ['users'])) ? 'active' : ''; ?>">
                                                <a href="<?php echo base_url() . 'admin/users'; ?>">
                                                    <i class="icon-arrow-right32"></i>
                                                    Staff
                                                </a>
                                            </li>                                            
                                        </ul>
                                    </li>-->
                                    




<!--                                    <li class="<?php echo ($controller == 'videos') ? 'active' : ''; ?>">
    <a href="<?php echo base_url() . 'admin/videos'; ?>">
        <i class="icon-video-camera"></i>
        <span>Videos</span>
    </a>
</li>-->
<!--                                    <li class="<?php echo ($controller == 'email_template') ? 'active' : ''; ?>">
    <a href="<?php echo base_url() . 'admin/email_template'; ?>">
        <i class="icon-envelop"></i>
        <span>Email Template</span>
    </a>
</li>-->

<!--                                    <li class="<?php echo ($controller == 'contact_inquiry') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/contact_inquiry'; ?>">
                                            <i class="icon-phone-plus2"></i>
                                            <span>Contact Inquiry</span>
                                        </a>
                                    </li>                                    -->


                                    <li class="<?php echo (in_array($controller, ['testimonial', 'blogs', 'cms'])) ? 'active' : ''; ?>">
                                        <a href="#" class="has-ul"><i class="icon-command"></i> <span>Front Side Setting</span></a>
                                        <ul>
<!--                                            <li class="<?php echo ($controller == 'blogs') ? 'active' : ''; ?>">
                                                <a href="<?php echo base_url() . 'admin/blogs'; ?>">
                                                    <i class="icon-blogger"></i>
                                                    <span>Blogs</span>
                                                </a>
                                            </li>  -->
                                            <li class="<?php echo ($controller == 'cms') ? 'active' : ''; ?>">
                                                <a href="<?php echo base_url() . 'admin/cms'; ?>">
                                                    <i class="icon-stack3"></i>
                                                    <span>Cms Page</span>
                                                </a>
                                            </li>                                              
                                        </ul>
                                    </li>                                    

                                    <!-- Site Setting Menu -->                                    
                                    <li class="<?php echo ($controller == 'settings') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/settings'; ?>">
                                            <i class="icon-gear"></i>
                                            <span>Site Settings</span></a>
                                    </li>

                                    <li class="">
                                        <a href="<?php echo base_url() . "admin/logout"; ?>">
                                            <i class="icon-switch2"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <!-- /main navigation -->
                    </div>
                </div>
                <!-- /main sidebar -->

                <!-- Main content -->
                <div class="content-wrapper">
                    <?php $this->load->view($subview); ?>
                </div>
                <!-- /main content -->
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
    </body>
</html>
