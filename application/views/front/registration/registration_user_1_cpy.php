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
				<form method="post" action="" id="frmregister" >					
					<div class="clearfix">
						
						<div class="form-group user-type">
							<!-- <select name="role" class="form-control" id="role">								
								<option value="4" <?php echo  set_select('role', '4',true); ?>>Doctor</option>							
								<option value="5" <?php echo  set_select('role', '5'); ?> >Patient</option>							
							</select>	 -->
							<div class="text">
								<span>I am a</span>
							</div>
							<div class="radio-check-new">
								<label class="radio pull-left nomargin-top">
									<input  name="role" value="4" id="role" type="radio" <?php echo set_radio('role', '4',TRUE); ?>>
									<i></i> <span class="weight-300">Doctor</span>
								</label>
								<label class="radio pull-left nomargin-top">
									<input  name="role" value="5" id="role" type="radio" <?php echo set_radio('role', '5'); ?>>
									<i></i> <span class="weight-300">Patient</span>
								</label>
							</div>	
						</div>

						<!-- Email -->
						<div class="form-group">
							<input type="text" name="email_id" class="form-control" placeholder="Email" value="<?php echo set_value('email_id'); ?>" >
						</div>

						<div class="form-group">
							<select name="state_id" class="form-control select2" id="state_id" data-id="select2">
								<option value="" selected disabled>Select State</option>
								<?php foreach($state_list as $state) : ?>
									<option value="<?=$state['id']?>" <?php echo  set_select('state_id', $state['id']); ?> ><?=$state['name']?></option>
								<?php endforeach; ?>
							</select>	
						</div>			

						<div class="form-group">
							<input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zip code"
							       value="<?php echo set_value('zipcode'); ?>">
						</div>	

						<div class="form-group">
							<select name="country_id" class="form-control" id="country_id" data-id="select2_disable">
								<option value="" selected disabled>Select Country</option>
								<?php foreach($country_list as $country) : ?>
									<option disabled value="<?=$country['id']?>" <?php echo  set_select('country_id', $country['id']); ?> >
										<?=$country['name']?>
									</option>
								<?php endforeach; ?>
							</select>	
						</div>				
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<!-- Inform Tip -->                                        
							<div class="form-tip margin-top-10">
								Already have an account? <a href="<?=base_url('login')?>"><strong>Back to login!</strong></a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
							<button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> Next</button>
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
