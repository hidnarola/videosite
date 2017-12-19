<?php
	$data['all_cms_pages'] = $this->db->get_where('cms_page',['is_deleted'=>'0','is_blocked'=>'0'])->result_array();
	$data['categories'] = $this->db->get_where('categories', ['is_deleted' =>'0', 'is_blocked' =>'0'])->result_array();
	$this->load->view('front/layouts/layout_header',$data); ?>    
	    
    <section class="content-wrap">
	    <?php $this->load->view('front/layouts/side_bar',$data); ?>
	    <div class="right-panel">
	    	<div class="for_height">		    		
	    		<?php $this->load->view($subview); ?>
	    	</div>
	    	<div class="cleafix"></div>
	    	<footer class="footer">
                     <?php 
                        $str = config('copy_right');
                        $str1 = substr($str,0,16);
                        $str2 = substr($str,30,21);
                        $new_str = substr($str,16,14);
                     ?> 
               <p><?php echo $str1; ?> <a href="<?php echo base_url()?>home"><span><?php echo $new_str;?></span></a><?php echo $str2; ?></p>
            </footer>
	    </div>
	</section>
	<?php $this->load->view('front/layouts/layout_modal'); ?>

	<script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'custom_new.js'; ?>"></script>	
	
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
			$.notify({				
				message: '<?php echo $success_msg; ?>',						
			},{
				// settings
				allow_dismiss: true,
				newest_on_top: false,
				animate: {
					enter: 'animated lightSpeedIn',
					exit: 'animated lightSpeedOut'
				},
				template: '<div data-notify="container" class="success-msg col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
					'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
					'<span data-notify="message">{2}</span>' +					
				'</div>' 
			});

		<?php } ?>

		<?php
			$error_msg = $this->session->flashdata('error');
			if(!empty($error_msg)){
		?>			
			$.notify({
				message: '<?php echo $error_msg; ?>',						
			},{
				// settings
				allow_dismiss: true,
				newest_on_top: false,
				animate: {
					enter: 'animated lightSpeedIn',
					exit: 'animated lightSpeedOut'
				},
				template: '<div data-notify="container" class="error-msg col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
					'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
					'<span data-notify="message">{2}</span>' +					
				'</div>' 
			});
		<?php } ?>

		var window_height = parseInt($(window).height());
		var header_height = parseInt($('header.header').height());

		$('.for_height').css('min-height', window_height+header_height-40);

	</script>		

	</body>
</html>