<html> 
    <title>Videosite</title>
	    <?php $this->load->view('front/layouts/layout_header'); ?>    
	    
	    <section class="content-wrap">
		    <?php $this->load->view('front/layouts/side_bar'); ?>
		    <div class="right-panel">
		    	<div class="for_height">		    		
		    		<?php $this->load->view($subview); ?>
		    	</div>
		    	<div class="clearfix"></div>
		    	<footer class="footer">
	               <p>©Copyright 2017 <a href="<?php echo base_url()?>home"><span>Videosite.com</span></a>, All Right Reserved</p>
	            </footer>
		    </div>
			<?php $this->load->view('front/layouts/layout_modal'); ?>
		</section>

		<script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'custom_new.js'; ?>"></script>	
		<!-- Go to www.addthis.com/dashboard to customize your tools --> 
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5948f4fb5a7fea54"></script>

		<script type="text/javascript">
			function check_login(){
				<?php 
					$s_data = $this->session->userdata('client');
					if(empty($s_data)){
				?>
					$('.btn_sign_in, .btn_header_login').trigger('click');
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
	</body>




</html>