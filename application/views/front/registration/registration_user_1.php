<!-- <section>
	<div class="container">-->
<!--		<div class="row">						
			<div class="col-md-12">-->
				 <!--login form--> 
				<div class="right-panel">
				<?php echo validation_errors(); ?>

				<form method="post" action="" id="frmregister" >
					<div class="clearfix">
						
						<div class="form-group">
							<input type="text" name="username" class="form-control" placeholder="Username " 
								   value="<?php echo set_value('username'); ?>" >
						</div>

						<div class="form-group">
							<input type="text" name="email_id" class="form-control" placeholder="Email *" 
								   value="<?php echo set_value('email_id'); ?>" >
						</div>

						<div class="form-group">
							<input type="password" name="password" id="" class="form-control" 
								   placeholder="Password *"  >
						</div>

						<div class="form-group">
							<input type="password" name="repeat_password" id="" class="form-control" 
								   placeholder="Repeat Password *" >
						</div>

						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="i agree" name="i_agree">
									I agree
								</label>
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
							<button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> Sign up</button>
						</div>
					</div>
				</form>
                                    
                                </div>
				 <!--/login form--> 
			<!--</div>-->
			 <!--/LOGIN--> 
		<!--</div>-->
<!--	</div>
</section>-->
<!-- / -->