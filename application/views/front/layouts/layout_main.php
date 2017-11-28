<html> 
    <title>Videosite</title>
    <?php $this->load->view('front/layouts/layout_header'); ?>    
    <?php $this->load->view($subview); ?>
    <?php $this->load->view('front/layouts/side_bar'); ?>
    
	<script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'custom.js'; ?>"></script>
	<!-- Go to www.addthis.com/dashboard to customize your tools --> 
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5948f4fb5a7fea54"></script> 
	<script src="<?php echo base_url().'public/front_js/jquery_validation.js'; ?>"></script>

	<script type="text/javascript">
		$(function(){
			$("#commentForm").validate({
				submitHandler:function(form){
					$.ajax({
		                type: "POST",
		                url: "/formfiles/submit.php",
		                data: $(form).serialize(),
		                success: function (data) {
		                    
		                    return false;
		                }
		            });
		            return false; // required to block normal submit since you used ajax
				}
			});
		});
	</script>
</body>

<?php $this->load->view('front/layouts/layout_modal'); ?>

</html>