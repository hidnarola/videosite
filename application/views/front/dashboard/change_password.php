 <section>
	<div class="container">
		<div class="row">						
			<div class="col-md-12">
				<!-- login form -->
				
				<?php echo validation_errors(); ?>

				<form method="post" action="" id="frmregister" enctype="multipart/form-data">
					<div class="clearfix">
						
						<div class="form-group">
							<input type="password" name="old_password" id="" class="form-control" 
								   placeholder="Old Password *"  >
						</div>

						<div class="form-group">
							<input type="password" name="password" id="" class="form-control" 
								   placeholder="Password *"  >
						</div>

						<div class="form-group">
							<input type="password" name="repeat_password" id="" class="form-control" 
								   placeholder="Repeat Password *" >
						</div>				 		

					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
							<button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> Update</button>
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