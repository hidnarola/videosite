<section>
	<div class="container">
		<div class="row">						
			<div class="col-md-12">
				<!-- login form -->
				
				<?php echo validation_errors(); ?>

				<form method="post" action="" id="frmregister" >					
					<div class="form-group">
						<input type="text" name="email_id" class="form-control" placeholder="Email *" 
							   value="<?php echo set_value('email_id'); ?>" >
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" placeholder="Password *" >
					</div>					
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
							<button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> Sign up</button>
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