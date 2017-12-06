<?php
	$data['all_cms_pages'] = $this->db->get_where('cms_page',['is_deleted'=>'0','is_blocked'=>'0'])->result_array();
	$data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
?>
<!DOCTYPE html>
<html> 
    <title>Videosite</title>

    <head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	    <title>Videosite.com</title>

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
	    <script src="<?php echo DEFAULT_ADMIN_JS_PATH . "sweetalert.min.js"; ?>"></script>
	    <link rel="stylesheet" type="text/css" href="<?php echo DEFAULT_ADMIN_CSS_PATH . "sweetalert.css"; ?>">
	    <link href="<?php echo DEFAULT_CSS_PATH ?>icomoon.css" rel="stylesheet" />
	    <link href="<?php echo DEFAULT_CSS_PATH ?>jquery.fancybox.min.css" rel="stylesheet" />        
	    <link href="<?php echo DEFAULT_CSS_PATH ?>animate.css" rel="stylesheet" />        
	    <link href="<?php echo DEFAULT_CSS_PATH ?>style.css" rel="stylesheet" />
	    <link href="<?php echo DEFAULT_CSS_PATH ?>pam_style.css" rel="stylesheet" /> 
	    <link href="<?php echo DEFAULT_CSS_PATH ?>responsive.css" rel="stylesheet" /> 

	    <script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'jquery.min.js'; ?>"></script>    
	    <script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'bootstrap.min.js'; ?>"></script>
	    <script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'bootstrap-datepicker.js'; ?>"></script>    
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

	    <?php $this->load->view('front/layouts/layout_header',$data); ?>    
	    
	    <section class="content-wrap">
		    <?php $this->load->view('front/layouts/side_bar',$data); ?>
		    <div class="right-panel">
		    	<div class="for_height">		    		
		    		<?php $this->load->view($subview); ?>
		    	</div>
		    	<div class="cleafix"></div>
		    	<footer class="footer">
	               <p>©Copyright 2017 <a href="<?php echo base_url()?>home"><span>Videosite.com</span></a>, All Right Reserved</p>
	            </footer>
		    </div>
		</section>
		<?php $this->load->view('front/layouts/layout_modal'); ?>

		<script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'custom_new.js'; ?>"></script>	
		<!-- Go to www.addthis.com/dashboard to customize your tools --> 
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5948f4fb5a7fea54"></script>

		<script type="text/javascript">
			function check_login(){
				<?php 
					$s_data = $this->session->userdata('client');
					if(empty($s_data)){
				?>
					$('.sign-up').addClass('hide');
					$('.sign-in').removeClass('hide');
					$('#login-register').modal('show');
				<?php }else {  ?>
					window.location.href="<?php echo base_url().'user_post/add_video_post'; ?>";
				<?php } ?>
				// href="<?php echo base_url().'user_post/add_post'; ?>"
			}

			<?php
				$success_msg = $this->session->flashdata('success');
				if(!empty($success_msg)){
			?>
				$.notify("<?php echo $success_msg; ?>", {
					type: 'success',
					animate: {
						enter: 'animated lightSpeedIn',
						exit: 'animated lightSpeedOut'
					}
				});
			<?php } ?>

			<?php
				$error_msg = $this->session->flashdata('error');
				if(!empty($error_msg)){
			?>
				$.notify("<?php echo $error_msg; ?>", {
					type: 'danger',
					animate: {
						enter: 'animated lightSpeedIn',
						exit: 'animated lightSpeedOut'
					}
				});
			<?php } ?>

			var window_height = parseInt($(window).height());
			var header_height = parseInt($('header.header').height());

			$('.for_height').css('min-height', window_height+header_height-40);
			console.log(window_height);
			console.log(header_height);

		</script>

		<script type="text/javascript">
			$(window).scroll(function() {
			   if($(window).scrollTop() + $(window).height() == $(document).height()) {
			       alert("bottom!");
			   }
			});
		</script>
	</body>
</html>