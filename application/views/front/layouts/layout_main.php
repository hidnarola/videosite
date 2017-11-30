<html> 
    <title>Videosite</title>
    <?php $this->load->view('front/layouts/layout_header'); ?>    
    
    <section class="content-wrap">
	    <?php $this->load->view('front/layouts/side_bar'); ?>
	    <div class="right-panel">
	    	<?php $this->load->view($subview); ?>
	    	<footer class="footer">
                    <p>©Copyright 2017 <a href="<?php echo base_url()?>home"><span>Videosite.com</span></a>, All Right Reserved</p>
            </footer>
	    </div>
		<?php $this->load->view('front/layouts/layout_modal'); ?>
	</section>
    
	<script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'custom.js'; ?>"></script>
	
</body>



</html>