<section>
	<div class="container">
		<div class="row">						
			<div class="col-md-12">
				<!-- login form -->
				
				<?php echo validation_errors(); ?>

				<form method="post" action="" id="frmregister" >					
					<div class="form-group">
						<?php if($_POST){ $post_channel_name = set_value('channel_name'); }else{ $post_channel_name = $channel_data['channel_name']; } ?>
						<input type="text" name="channel_name" class="form-control" placeholder="Channel Name *" 
							   value="<?php echo $post_channel_name; ?>" >
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