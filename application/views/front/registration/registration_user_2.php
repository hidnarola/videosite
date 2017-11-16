<style>
.reg2_text{
	font-weight: bold;
    text-align: center;
    font-size: 14px;
}
.mand_field{
	font-weight: bold;
    text-align: center;
    font-size: 12px;
    margin-bottom: 5px;
}
</style>
<section class="page-header page-header-xs">
	<div class="container">

		<h1>User Registration</h1>

		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url();?>">Home</a></li>
			<li class="active">User Registration</li>
		</ol><!-- /breadcrumbs -->

	</div>
</section>

<!-- -->
<section>
	<div class="container">
		<div class="row">			
			<!-- LOGIN -->
			<div class="col-md-12">				

				<!-- ALERT -->
				<?php if($this->session->userdata('new_error')) : ?>
					<div class="alert alert-mini alert-danger margin-bottom-30">
						<?=$this->session->userdata('new_error');?>
					</div>
				<?php endif; ?>
				<!-- /ALERT -->

				<?php $this->session->unset_userdata('new_error'); ?>

				<!-- ALERT -->
				<?php if($this->session->flashdata('error')) : ?>
					<div class="alert alert-mini alert-danger margin-bottom-30">
						<?=$this->session->flashdata('error');?>
					</div>
				<?php endif; ?>
				<!-- /ALERT -->

				<?php 
					$all_errors = validation_errors('<li>','</li>');
					if($all_errors != '') { 
				?>
					<div class="alert alert-mini alert-danger">				
						<ul>							
							<?php echo $all_errors; ?>
						</ul>
					</div>
				<?php } ?>

				<!-- login form -->
				<form method="post" action="<?=base_url('registration/user_2')?>" id="frmregister" >					
					<input type="hidden" name="email_id" value="<?php echo isset($this->session->userdata['reg_data']['email_id'])?$this->session->userdata['reg_data']['email_id']:''; ?>">
					<input type="hidden" name="zipcode" value="<?php echo isset($this->session->userdata['reg_data']['zipcode'])?$this->session->userdata['reg_data']['zipcode']:''; ?>">
					<input type="hidden" name="state_id" value="<?php echo isset($this->session->userdata['reg_data']['state_id'])?$this->session->userdata['reg_data']['state_id']:''; ?>">
					<input type="hidden" name="role" value="<?php echo isset($this->session->userdata['reg_data']['role'])?$this->session->userdata['reg_data']['role']:''; ?>">
					<p class="mand_field">* INDICATES FIELDS WHICH ARE MANDATORY</p>
					<p class="reg2_text">In order to proceed with the registration kindly fill in all the following fields:</p>
					<div class="clearfix">

						<!-- For Display Step 1 Data -->
						<a href="<?=base_url('registration/back_user')?>" name="back" class="btn btn-info pull-right"><i class="fa fa-arrow-left"></i> Back</a>
						<div class="form-group user-type">
							<div class="text">
								<span>I am a</span>
							</div>
							<div class="radio-check-new">
								<label class="radio pull-left nomargin-top">
									<input value="4" type="radio" disabled <?php if(isset($this->session->userdata['reg_data']['role']) && $this->session->userdata['reg_data']['role'] == '4') echo 'checked'; ?>>
									<i></i> <span class="weight-300">Doctor</span>
								</label>
								<label class="radio pull-left nomargin-top">
									<input value="5" type="radio" disabled <?php if(isset($this->session->userdata['reg_data']['role']) && $this->session->userdata['reg_data']['role'] == '5') echo 'checked'; ?>>
									<i></i> <span class="weight-300">Patient</span>
								</label>
							</div>	
						</div>

						<div class="form-group">
							<input type="text" class="form-control" placeholder="Email" value="<?php echo isset($this->session->userdata['reg_data']['email_id'])?$this->session->userdata['reg_data']['email_id']:''; ?>" disabled>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Zip code" value="<?php echo isset($this->session->userdata['reg_data']['zipcode'])?$this->session->userdata['reg_data']['zipcode']:''; ?>" disabled>
						</div>
						<div class="form-group">
							<select class="form-control" id="state_id" data-id="select2_disable">
								<option value="" selected disabled>Select State</option>
								<?php foreach($state_list as $state) : ?>
									<option value="<?=$state['id']?>" <?php echo set_select('state_id', $state['id']); ?> ><?=$state['name']?></option>
								<?php endforeach; ?>
							</select>	
						</div>
						<div class="form-group">
							<select class="form-control" data-id="select2_disable" id="country_id">
								<option value="" selected disabled>Select Country</option>
								<?php foreach($country_list as $country) : ?>
									<option disabled value="<?=$country['id']?>" <?php echo  set_select('country_id', $country['id']); ?> >
										<?=$country['name']?>
									</option>
								<?php endforeach; ?>
							</select>	
						</div>
						<!-- End For Display Step 1 Data -->


						<div class="form-group">
							<input type="text" name="fname" class="form-control AlphaAndDotWithhypen" placeholder="First Name *" value="<?php echo set_value('fname'); ?>" >
						</div>						

						<div class="form-group">
							<input type="text" name="lname" class="form-control AlphaAndDotWithhypen" placeholder="Last Name *" value="<?php echo set_value('lname'); ?>" >
						</div>

						<!-- Password -->
						<div class="form-group">
							<input type="password" name="password" class="form-control" placeholder="Password *" value="<?php echo set_value('password'); ?>">
						</div>						

						<div class="form-group">
							<input type="password" name="c_password" class="form-control" placeholder="Confirm Password *" value="<?php echo set_value('c_password'); ?>">
						</div>												
						<!-- Street Name -->
						<div class="form-group">
							<input type="text" name="street" class="form-control" placeholder="Street name" value="<?php echo set_value('street'); ?>" >
						</div>

						<div class="form-group">
							<input type="text" name="city" class="form-control" placeholder="City" value="<?php echo set_value('city'); ?>" >
						</div>

						<div class="form-group">
							<select name="gender" class="form-control" id="gender">
								<option selected disabled >Select Gender *</option>
								<option value="male" <?php echo  set_select('gender', 'male'); ?> >Male</option>
								<option value="female" <?php echo  set_select('gender', 'female'); ?>>Female</option>							
							</select>		
						</div>
									
						<div class="form-group">
							<input type="text" name="phone" class="form-control NumbersAndPlus" placeholder="Phone" value="<?php echo set_value('phone'); ?>" >
						</div>					

						<div class="form-group">
							<input type="text" name="birth_date" placeholder="Birth Date *" class="form-control birth_date" data-format="mm-dd-yyyy" data-lang="en" data-RTL="false" value="<?php echo set_value('birth_date'); ?>">
							<small class="text-muted block">Please Select Date in MM-DD-YYYY Format</small>	
						</div>

						<div class="margin-top-30">
							<label class="checkbox nomargin"><input class="checked-agree" type="checkbox" name="agree"><i></i>* I agree to the <a href="<?php echo base_url().'terms-condition'; ?>" target="_blank">Terms of Service</a></label>
						</div>
						
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<!-- Inform Tip -->                                        
							<!-- <div class="form-tip margin-top-10">
								Already have an account? <a href="<?=base_url('login')?>"><strong>Back to login!</strong></a>
							</div> -->
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
							<button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> REGISTER</button>
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

<script type="text/javascript">
	$('#country_id').val('231');
	$("#country_id").prop("disabled", true); // For Disable select option

	$('#state_id').val(<?=isset($this->session->userdata['reg_data']['state_id'])?$this->session->userdata['reg_data']['state_id']:'';?>);
	$("#state_id").prop("disabled", true); // For Disable select option

	$('.AlphaAndDotWithhypen').keyup(function () { 
    	this.value = this.value.replace(/[^A-Za-z.-\s]/g,'');
	});

	$('.NumbersAndPlus').keyup(function () { 
    	this.value = this.value.replace(/[^0-9+ ]/g,'');
  });

	/*------------- Custom Select 2 focus open select2 option @DHK-Select2 --------- */
	$(document).on('focus', '.select2', function() {
	    $(this).siblings('select').select2('open');
	});
	/*-------------End Custom Select 2 focus open select2 options -----*/
</script> 
