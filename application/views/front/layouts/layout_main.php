<html> 
    <title>Videosite</title>
	    <?php $this->load->view('front/layouts/layout_header'); ?>    
	    
	    <section class="content-wrap">
		    <?php $this->load->view('front/layouts/side_bar'); ?>
		    <div class="right-panel">
		    	<?php $this->load->view($subview); ?>
		    	<div class="clearfix"></div>
		    	<footer class="footer">
	               <p>©Copyright 2017 <a href="<?php echo base_url()?>home"><span>Videosite.com</span></a>, All Right Reserved</p>
	            </footer>
		    </div>
			<?php $this->load->view('front/layouts/layout_modal'); ?>
		</section>

		<script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'custom.js'; ?>"></script>	
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
		</script>
	</body>




</html>