<?php $sess_u_data = $this->session->userdata('client'); ?>

<!DOCTYPE html>
<html> 
    <title>Videosite</title>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->        
        
        <!-- Bootstrap -->        
        <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700|Roboto:400,500" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
        <link href="<?php echo DEFAULT_CSS_PATH ?>bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo DEFAULT_CSS_PATH . "owl.carousel.css"; ?>" rel="stylesheet" type="text/css">      
        <link href="<?php echo DEFAULT_CSS_PATH ?>datepicker.css" rel="stylesheet" />    
        <link href="<?php echo DEFAULT_CSS_PATH ?>bootstrap-select.min.css" rel="stylesheet" />
        <link href="<?php echo DEFAULT_CSS_PATH ?>font.css" rel="stylesheet">
        <link href="<?php echo DEFAULT_ADMIN_CSS_PATH . "font.css"; ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo DEFAULT_ADMIN_CSS_PATH . "icons/icomoon/styles.css"; ?>" rel="stylesheet" type="text/css">
        
        <link href="<?php echo DEFAULT_CSS_PATH ?>icomoon.css" rel="stylesheet" />
        <link href="<?php echo DEFAULT_CSS_PATH ?>jquery.fancybox.min.css" rel="stylesheet" />        
        <link href="<?php echo DEFAULT_CSS_PATH ?>animate.css" rel="stylesheet" />        
        <link href="<?php echo DEFAULT_CSS_PATH ?>jquery.loading.min.css" rel="stylesheet" />        
        <link href="<?php echo DEFAULT_CSS_PATH ?>style.css" rel="stylesheet" />
        <link href="<?php echo DEFAULT_CSS_PATH ?>pam_style.css" rel="stylesheet" /> 
        <link href="<?php echo DEFAULT_CSS_PATH ?>simplebar.css" rel="stylesheet" /> 
        <link href="<?php echo DEFAULT_CSS_PATH ?>responsive.css" rel="stylesheet" />         

        <script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'jquery.min.js'; ?>"></script>    
        <script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'bootstrap.min.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'bootstrap-datepicker.js'; ?>"></script>    
        <script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'simplebar.js'; ?>"></script>        
        <script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'jquery.loading.min.js'; ?>"></script>        
        <script src="<?php echo DEFAULT_JS_PATH.'jquery_validation.js'; ?>"></script>
        <script src="<?php echo DEFAULT_JS_PATH.'bootstrap-select.min.js'; ?>"></script>    
        <script src="<?php echo DEFAULT_JS_PATH.'jquery.fancybox.min.js'; ?>"></script>        
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
        
        <script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'bootbox.min.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'bootstrap-notify.min.js'; ?>"></script>    
        <script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'owl.carousel.min.js'; ?>"></script>  
        
        <!-- DEFAULT_JS_PATH
        DEFAULT_CSS_PATH -->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            .cursor_pointer { cursor: pointer;  }
        </style>
    </head>
    <body>

        <header class="header">
            <div class="logo">
                <a href="<?php echo base_url() ?>home">
                    <img src="<?php echo base_url().'public/front/images/logo_1.jpg'; ?>" alt="" width="161px" height="60px" />
                </a>
            </div>
            <div class="search">
                <form action="<?php echo base_url().'search'; ?>">
                    <input type="text" placeholder="Search Here" name="q" value="<?php echo $this->input->get('q');?>"/>
                    <button type="submit">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"> <g> <g> <path d="M386.348,336.165c23.574-34.148,37.408-75.546,37.408-120.19c0-117.015-94.843-211.878-211.878-211.878 S0,98.959,0,215.974s94.843,211.878,211.878,211.878c48.849,0,93.8-16.572,129.637-44.338l124.388,124.388L512,461.812 L386.348,336.165z M211.878,382.217c-91.667,0-166.243-74.574-166.243-166.243c0-91.667,74.574-166.243,166.243-166.243 s166.243,74.574,166.243,166.243S303.545,382.217,211.878,382.217z"/> </g> </g> <g> <g> <path d="M191.738,85.575c-52.877,15.19-94.418,56.731-109.615,109.609l31.338,8.99c12.035-42.005,45.264-75.239,87.267-87.274 L191.738,85.575z"/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
                    </button>
                </form>
            </div>

            <div class="header-upload">
                <a class="cursor_pointer" onclick="check_login()" >
                    Submit Content <small><p>Video</p> <p>Gallery</p> <p>Article</p> </small>
                    <span>
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 489.4 489.4" style="enable-background:new 0 0 489.4 489.4;" xml:space="preserve"> <g> <g> <path d="M0,348.65v84.2c0,28.9,23.5,52.5,52.5,52.5h384.4c28.9,0,52.5-23.5,52.5-52.5v-84.2c0-28.9-23.5-52.5-52.5-52.5h-106 c-10.8,0-19.8,8.2-20.9,19c-3.4,33.6-31.5,58.9-65.3,58.9s-61.9-25.3-65.3-58.9c-1.1-10.8-10.1-19-20.9-19h-106 C23.6,296.15,0,319.65,0,348.65z M244.7,398.55c45.4,0,83.3-33.3,89.3-77.9h102.9c15.4,0,28,12.5,28,28v84.2c0,15.4-12.5,28-28,28 H52.5c-15.4,0-28-12.5-28-28v-84.2c0-15.4,12.5-28,28-28h102.9C161.4,365.25,199.3,398.55,244.7,398.55z"/> <path d="M244.7,267.95c6.8,0,12.3-5.5,12.3-12.3V45.85l59.3,59.3c2.4,2.4,5.5,3.6,8.7,3.6s6.3-1.2,8.7-3.6 c4.8-4.8,4.8-12.5,0-17.3l-80.3-80.2c-4.8-4.8-12.5-4.8-17.3,0l-80.2,80.2c-4.8,4.8-4.8,12.5,0,17.3s12.5,4.8,17.3,0l59.3-59.3 v209.8C232.5,262.45,237.9,267.95,244.7,267.95z"/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g></svg>
                    </span>
                </a>
            </div>

            <?php 
                if(!empty($sess_u_data)){ 
                    $u_data = $this->db->get_where('users',['id'=>$sess_u_data['id']])->row_array();
            ?>
                <div class="user-nav dropdown">
                    <a href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo base_url().$u_data['avatar']; ?>" alt="" 
                             onerror="this.src='<?php echo base_url().'uploads/avatars/user-icon-image-download.jpg'; ?>'" />
                        <?php echo $u_data['username']; ?>
                        <span class="caret"></span>

                    </a>
                    <ul class="dropdown-menu">                    
                        <li>
                            <a href="<?php echo base_url().'dashboard/view_bookmarked_post';?>">
                                Bookmarked Posts
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url().'dashboard/view_recommended';?>">
                                Recommended Posts
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url().'dashboard/view_history';?>">
                                History
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url().'user_channels';?>">
                                Channels
                            </a>
                        </li>
                         <li>
                            <a href="<?php echo base_url().'dashboard/view_my_posts';?>">
                                My Posts
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url().'dashboard/edit_profile';?>">
                                Edit Profile
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url().'dashboard/change_password';?>">
                                Change Password
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url().'dashboard/logout'; ?>">Log Out</a>
                        </li>
                    </ul>
                </div>
            <?php } else { ?>
                <div class="sign-in-up">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#login-register" class="btn_header_login">
                        Sign In
                    </a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#login-register" class="btn_header_register">Sign Up</a>
                </div>
            <?php } ?>
            
            <div class="mobile-nav" id="mobile_menu">
                <a onclick="$('#mobile_menu').toggleClass('menu-nav');" class="nav-icon"><span></span></a>
                <div class="mobile-nav-ul">
    				<div class="info_div">				
    					<h4> Information Pages</h4>
    					<ul class="main_pages_ul">
    						<li>
    							<a href="<?php echo base_url() ?>home">
    								<i class="fa fa-home">
    								</i> 
    								Home
    							</a>
    						</li>
    						<?php 
    							if(isset($all_cms_pages)){
    								foreach ($all_cms_pages as $key =>$cms){
    									if($cms['title'] != 'Home'){
    						?>
    							<li>
    								<a href="<?php echo base_url(). 'page/'.$cms['slug']; ?>">
    									<i class="<?php echo $cms['icons']?>"></i>
    									<?php echo $cms['title']?>
    								</a>
    							</li>
    						<?php } } } ?>
    						
    						<?php 
    							if(empty($sess_u_data)){                            
    						?>                    
    							<li>
    								<a href="javascript:void(0)" data-toggle="modal" data-target="#login-register" class="btn_header_login">
    									<i class="icon-user">
    									</i> 
    									Sign In
    								</a>
    							</li>    
    							<li>
    								<a href="javascript:void(0)" data-toggle="modal" data-target="#login-register" class="btn_header_register">
    									<i class="icon-send">
    									</i> 
    									Sign Up
    								</a>
    							</li>
    						<?php } ?>
    						<li>
    							<a class="cursor_pointer" onclick="check_login()" >
    								<i class="icon-upload">
    								</i> 
    								submit video 
    							</a>
    						</li>
    					</ul>				
    				</div>
    				
                    <div class="info_div">				
    					<h4> Category Pages</h4>
            				<ul class="main_pages_ul">
                                <?php
                                    foreach ($categories as $key_new => $cat) {
                                        $sub_cat = $this->db->get_where('sub_categories', ['main_cat_id' => $cat['id']])->result_array();
                                ?>
                                    <li class="dropdown">
                                        <a href="<?php echo base_url() . 'category_detail_page/' . $cat['id']; ?>" class="ct-link">
                                            <i class="<?php echo $cat['icon']; ?>"></i> 
                                            <?php echo $cat['category_name'] ?>
                                        </a>
                                        <?php if(!empty($sub_cat)) { ?>
                                            <a id="dropdownMenu<?php echo $key_new; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" 
                                                class="fa fa-angle-down arrow-down"></a>
                                        <?php } ?>                                    
                                        <ul class="sub-category dropdown-menu"  aria-labelledby="dropdownMenu<?php echo $key_new; ?>">
                                            <?php                        
                                                foreach ($sub_cat as $key => $sub) {
                                            ?> 
                                                <li>
                                                    <a href="<?php echo base_url() . 'category_detail_page/' . $cat['id']; ?>/sub/<?php echo $sub['id']?>">
                                                        <i class="<?php echo $sub['icon']; ?>"></i>
                                                        <?php echo $sub['category_name'] ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                            </ul>
    				</div>
                </div>
            </div>
        </header>