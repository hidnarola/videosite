<html> 
    <title>Videosite</title>
    <?php $this->load->view('front/layouts/layout_header'); ?>    
    <?php $this->load->view($subview); ?>
    <?php $this->load->view('front/layouts/side_bar'); ?>
    
	<script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'custom.js'; ?>"></script>
	<!-- Go to www.addthis.com/dashboard to customize your tools --> 
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5948f4fb5a7fea54"></script>
	
</body>

<?php $this->load->view('front/layouts/layout_modal'); ?>

</html>