 <section>
	<div class="container">
		<div class="row">						
			<div class="col-md-12">
				<!-- login form -->
				
				<?php echo validation_errors(); ?>

				<form method="post" action="" id="frmregister" enctype="multipart/form-data">
					<div class="clearfix">
						
						<div class="form-group">
							<?php $post_uname = ($_POST) ? set_value('username'):$user_data['username'];?>
							<input type="text" name="username" class="form-control" placeholder="Username " 
								   value="<?php echo $post_uname; ?>" >
						</div>

						<div class="form-group">
							<input type="text" name="email_id" class="form-control" placeholder="Email *" disabled
								   value="<?php echo $user_data['email_id']; ?>" >
						</div>

						<div class="form-group">
							<?php $post_fname = ($_POST) ? set_value('fname'):$user_data['fname'];?>
							<input type="text" name="fname" class="form-control" placeholder="First Name " 
								   value="<?php echo $post_fname; ?>" >
						</div>

						<div class="form-group">
							<?php $post_lname = ($_POST) ? set_value('lname'):$user_data['lname'];?>
							<input type="text" name="lname" class="form-control" placeholder="Last Name " 
								   value="<?php echo $post_lname; ?>" >
						</div>

						<div class="form-group">
							<input type="file" name="profile_picture" class="form-control" >
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