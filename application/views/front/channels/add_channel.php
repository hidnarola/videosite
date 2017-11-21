<section>
	<div class="container">
		<div class="row">						
			<div class="col-md-12">
				<!-- login form -->
				
				<?php echo validation_errors(); ?>

				<form method="post" action="" id="frmregister" >					
					<div class="form-group">
						<input type="text" name="channel_name" class="form-control" placeholder="Channel Name *" 
							   value="<?php echo set_value('channel_name'); ?>" >
					</div>									
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
							<button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> Create </button>
						</div>
					</div>
				</form>
				<!-- /login form -->
			</div>
			<!-- /LOGIN -->
		</div>
	</div>
</section>
<!-- / -->