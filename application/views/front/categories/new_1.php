<?php
	$data['all_cms_pages'] = $this->db->get_where('cms_page',['is_deleted'=>'0','is_blocked'=>'0'])->result_array();
	$data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
	$data['subview'] = "front/home";
	$data['categories'] = $this->db->get_where('categories', ['is_deleted' => 0, 'is_blocked' => 0])->result_array();
    $data['sub_categories'] = $this->Post_model->get_sub_cat();
    $data['most_likes'] = $this->Post_model->get_most_liked_post(10,0);
    $data['most_views'] = $this->Post_model->get_most_viewed_post(10,0);
    $data['most_recent_video'] = $this->Post_model->get_recently_posted_videos(2,0);
    $data['most_recent_blog'] = $this->Post_model->get_recently_posted_blogs(1,0);
    $data['most_recent_gallery'] = $this->Post_model->get_recently_posted_gallery(1,0);
    $data['subview'] = "front/home";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Breack.com</title>

		<!-- Bootstrap -->
		<link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700|Roboto:400,500" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
		<link href="<?php echo base_url().'public/front/'; ?>css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url().'public/front/'; ?>css/owl.carousel.css" rel="stylesheet" />
		<link href="<?php echo base_url().'public/front/'; ?>css/icomoon.css" rel="stylesheet" />
		<link href="<?php echo base_url().'public/front/'; ?>css/style.css" rel="stylesheet" />
		<link href="<?php echo base_url().'public/front/'; ?>css/responsive.css" rel="stylesheet" />
		<link href="<?php echo DEFAULT_ADMIN_CSS_PATH . "icons/icomoon/styles.css"; ?>" rel="stylesheet" type="text/css">		 
	</head>
	<body>
		<?php $this->load->view('front/layouts/layout_header',$data); ?>    
		
		<section class="content-wrap">
			<?php $this->load->view('front/layouts/side_bar',$data); ?>
			<div class="right-panel">
				<div class="for_height">		    		
					<?php $this->load->view($data['subview'],$data); ?>
				</div>
				
				<div class="clearfix"></div>
				<footer class="footer">
					<p>©Copyright 2017 <span>Break.com</span>, All Right Reserved</p>
				</footer>
			</div>
		</section>
		
		
		<div class="modal fade" id="login-register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-body" >
					<div class="sign-in hide">
						<div class="sign-in-l">
							<h2>
								<big>Sign in</big>
								<small>Please enter your login information.</small>
							</h2>
							<form>
								<input type="text" name="" class="input-css" placeholder="Name"/>
								<input type="text" name="" class="input-css" placeholder="E-mail"/>
								<div class="remember-forgat">
									<div class="checkbox">
										<input id="check1" type="checkbox" name="check" value="check1">
										<label for="check1">Rememner Me</label>
									</div>	
									<a href="">Forget password?</a>
								</div>
								<button type="submit" name="">SIGN IN</button>
							</form>
							
							<div class="or"><span>OR</span></div>
							<div class="social-login">
								<a href=""><img src="<?php echo base_url().'public/front/'; ?>images/facebook.png" alt="" /></a>
								<a href=""><img src="<?php echo base_url().'public/front/'; ?>images/twitter.png" alt="" /></a>
								<a href=""><img src="<?php echo base_url().'public/front/'; ?>images/instagram.png" alt="" /></a>
								<a href=""><img src="<?php echo base_url().'public/front/'; ?>images/snapchat.png" alt="" /></a>
							</div>
						</div>
						<div class="sign-in-r">
							<h3>Don’t have an account?</h3>
							<p>When an unknown printer took a galley of type and scrambled it to make a type specimen book has survived not only five.</p>
							<a href="javascript:void(0)" class="btn_sign_up">sign up</a>
						</div>
					</div>
					<div class="sign-up">
						<div class="sign-in-l">
							<h2>
								<big>Sign in</big>
								<small>Please enter your login information.</small>
							</h2>
							<form>
								<input type="text" name="" class="input-css" placeholder="Name"/>
								<input type="text" name="" class="input-css" placeholder="E-mail"/>
								<input type="password" name="" class="input-css" placeholder="Password"/>
								<input type="password" name="" class="input-css" placeholder="Re-Password"/>
								<div class="remember-forgat">
									<div class="checkbox">
										<input id="check2" type="checkbox" name="check" value="check2">
										<label for="check2">Term & Condition</label>
									</div>
								</div>
								<button type="submit" name="">SIGN IN</button>
							</form>
						</div>
						<div class="sign-in-r">
							<h3>Have an account?</h3>
							<p>When an unknown printer took a galley of type and scrambled it to make a type specimen book has survived not only five.</p>
							<a href="javascript:void(0)" class="btn_sign_in">sign IN</a>
						</div>
					</div>
				</div>
				
				<div class="re-password" style="display:none;">
					<h2>Forgot password</h2>
					<p>Please enter your email information.</p>
					<form>
						<input type="text" name="" placeholder="E-mail"/>
						<button type="submit">Submit</button>
						<button type="reset">cencel</button>
					</form>
				</div>
			</div>
		</div>
		

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?php echo base_url().'public/front/'; ?>js/bootstrap.min.js"></script>
		<script src="<?php echo base_url().'public/front/'; ?>js/owl.carousel.min.js"></script>
		<script src="<?php echo base_url().'public/front/'; ?>js/custom.js"></script>


		<script type="text/javascript">
			$(window).scroll(function() {
			   if($(window).scrollTop() + $(window).height() == $(document).height()) {
			       alert("bottom!");
			   }
			});
		</script>
	</body>
</html>
