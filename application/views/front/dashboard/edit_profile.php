<div class="right-panel">
				<div class="form-element">
					<h3 class="h3-title">Edit Profile</h3>
					<form method="post" action="" id="frmregister" enctype="multipart/form-data">
						<div class="input-wrap">
							<label class="label-css">User Name </label>
                                                        <?php $post_uname = ($_POST) ? set_value('username'):$user_data['username'];?>
                                                        <input type="text" name="username" placeholder="User Name" value="<?php echo $user_data['username']; ?>" class="form-css" />
						</div>
						<div class="input-wrap">
							<label class="label-css">E-mail </label>
							<input type="text" name="email_id" placeholder="E-mail" value="<?php echo $user_data['email_id']; ?>" class="form-css" disabled />
						</div>
                                                <div class="input-wrap">
							<label class="label-css">First Name </label>
							<input type="text" name="fname" placeholder="First Name" value="<?php echo $user_data['fname']; ?>" class="form-css" />
						</div>
                                            <div class="input-wrap">
							<label class="label-css">Last Name </label>
							<input type="text" name="lname" placeholder="Last Name" value="<?php echo $user_data['lname']; ?>" class="form-css" />
						</div>
						<div class="input-wrap">
							<label class="label-css">Upload File</label>
							<div class="input-file">
								<input type="file" class="form-css" readonly>
<!--								<label class="input-group-btn">
									<span class="">
										Browse <input type="file" style="display: none;" multiple>
									</span>
								</label>-->

							</div>
						</div>
						
						<div class="btn-btm">
							<button class="common-btn btn-submit" type="submit">Submit</button>
							<button class="common-btn btn-reset" type="reset">Reset</button>
						</div>
						
						
					</form>
				</div>
				
				
			</div>
<!--				
				<?php echo validation_errors(); ?>

				
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
				</form>-->
				<!-- /login form -->

