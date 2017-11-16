<style>
	.rfp-title{
		border-bottom: 2px solid gray;
		margin-bottom: 0px;
		margin-top: 10px;
	}
</style>

<section class="page-header page-header-xs">
	<div class="container">
		<h1>Patient Request</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
			<li><a href="<?=base_url('rfp');?>">Request List</a></li>
			<li class="active">Patient Request</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>

<!-- -->
<section>
	<div class="container">
		<div class="row">
		
		<!-- ALERT -->
		<?php if($this->session->flashdata('success')) : ?>
			<div class="alert alert-success margin-bottom-30">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?=$this->session->flashdata('success');?>
			</div>
		<?php endif; ?>
		<?php if($this->session->flashdata('error')) : ?>
			<div class="alert alert-danger margin-bottom-30">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?=$this->session->flashdata('error');?>
			</div>
		<?php endif; ?>
		<!-- /ALERT -->					
	
	<div class="col-md-12">
		<form method="post" enctype="multipart/form-data">
			
			<!-- End For Step View -->
			<?php if(!isset($record)) :?>
				<!-- <div class="row">
					<div class="col-md-12 col-sm-12">
						<a href="<?=base_url('rfp/redirect_profile')?>" class="btn btn-info">Edit Profile</a>
						<a href="#" class="btn btn-info new_person">Clear All Fields</a>
					</div>
				</div> -->
			<?php endif;?>

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h3 class="rfp-title">Basic Details</h3>
				</div>
			</div>	
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<span class="mand_field"><span class="required_field">*</span> INDICATES FIELDS WHICH ARE MANDATORY</span>
				</div>
			</div>	
			
			<?php if(isset($quick_without_login)) { ?>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label>Email <span class="required_field">*</span></label>
							<input type="text" name="email" class="form-control" placeholder="Email.." 
								value="<?php if(set_value('email') != '') { echo set_value('email'); }else { echo ''; } ?>"
								>
						</div>
						<?php echo form_error('email','<div class="alert alert-mini alert-danger">','</div>'); ?>
					</div>
				</div>				
			<?php } ?>

			<div class="row">
				<div class="col-md-6 col-sm-6">	
					<div class="form-group">
						<label>First Name <span class="required_field">*</span></label>
						<input type="text" name="fname" class="form-control" placeholder="First Name" 
							value="<?php if(set_value('fname') != '') { echo set_value('fname'); }else { echo $this->session->userdata['client']['fname']; } ?>" 
							>
					</div>
					<?php echo form_error('fname','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
				<div class="col-md-6 col-sm-6">	
					<div class="form-group">
						<label>Last Name <span class="required_field">*</span></label>
						<input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php if(set_value('lname') != '') { echo set_value('lname'); }else { echo $this->session->userdata['client']['lname']; } ?>" >
					</div>
					<?php echo form_error('lname','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>				
			</div>

			<div class="row">
				<div class="col-md-6 col-sm-6">
					<div class="form-group">
						<label>Birth Date </label>							
						<input type="text" name="birth_date" id="birth_date" data-format="mm-dd-yyyy" class="form-control datepicker" 
							  placeholder="MM-DD-YYYY" 
							  	value="<?php 
							  		if(set_value('birth_date') != '') {
							  			echo set_value('birth_date'); 
							  		} else if($this->session->userdata['client']['birth_date'] != ''){
							  			echo date("m-d-Y",strtotime($this->session->userdata['client']['birth_date'])); 
							  		} ?>" >
						<small class="text-muted block">Please Select Date in MM-DD-YYYY Format</small>	
					</div>
					<?php echo form_error('birth_date','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="form-group">
						<label>Zip Code <span class="required_field">*</span></label>
						<input type="text" name="zipcode" class="form-control" placeholder="Zip Code" value="<?php if(set_value('zipcode') != '') { echo set_value('zipcode'); }else { echo $this->session->userdata['client']['zipcode']; } ?>" >
					</div>
					<?php echo form_error('zipcode','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
			</div>	
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Request Title <span class="required_field">*</span></label>						
						<input type="text" name="title" class="form-control" placeholder="Request Title" value="<?=set_value('title',$rfp_def_val);?>" >
					</div>
					<?php echo form_error('title','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
				<input type="hidden" name="dentition_type" id="dentition_type" value="permanent">
			</div>	

			<!-- Range Picker -->
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="margin-bottom-20">
						<label for="donation">Travel Distance (In. Miles) <span class="required_field">*</span></label>
						<label class="field">
							<input type="text" name="distance_travel" id="distance_travel" class="form-control NumbersAndRange" value="<?php if(set_value('distance_travel') != '') { echo set_value('distance_travel'); }else { echo 20; } ?>">
						</label>
					</div>
					<div class="slider-wrapper black-slider custom-range-slider">
						<div id="slider5"></div>
					</div>
				</div>
			</div>
			<?php echo form_error('distance_travel','<div class="alert alert-mini alert-danger">','</div>'); ?>				
			<!-- End Range Picker -->

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h3 class="rfp-title">Medical History</h3>
				</div>
			</div>	
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Treatment Plan Total ($)</label>
						<input type="text" name="treatment_plan_total" class="form-control NumbersAndDot" placeholder="If you already have received an estimate or a budget, you may enter. We will calculate your potential saving per each quote against this value." value="<?=set_value('treatment_plan_total');?>" >
					</div>
					<?php echo form_error('treatment_plan_total','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-sm-12">	
					<div class="form-group">
						<label>Insurance Provider</label>
						<textarea name="insurance_provider" class="form-control" placeholder="Optionally, you can share your Insurance Provider and Type with the doctor in this field."><?=set_value('insurance_provider');?></textarea>
					</div>
					<?php echo form_error('insurance_provider','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>	
			</div>

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Attachment</label>
						<div class="all_file_uploads">									
							<div class="fancy-file-upload">
								<i class="fa fa-upload"></i>
								<input type="file" id="img_path_id_1" data-id="1" class="img_upload form-control" name="img_path[]"/>
								<input type="text" id="img_path_txt_1" class="form-control" placeholder="no file selected" readonly="" />
								<span class="button">Choose File</span>
							</div>
						</div>
						<small class="text-muted block">Max Allow File : 10 & Max file size: 10 MB & Allow jpg, jpeg, png, pdf File</small>
						<a class="btn btn-primary" onclick="add_more_img()">Add</a>
						<a class="btn btn-danger" style="display:none" id="remove_btn" onclick="remove_img()">Remove</a>
					</div>
				</div>
			</div>

			<div class="row">	
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Treatment Description</label> 
						<textarea name="other_description" class="form-control" placeholder="Enter a description related to your treatment, helping the doctor obtaining a better understanding what is required to be done"><?php echo set_value('other_description'); ?></textarea>
					</div>
					<?php echo form_error('other_description','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<label>Further Information for our Agents</label> 
					<div class="fancy-form">
						<textarea rows="3" name="message" class="form-control char-count" data-maxlength="500" data-info="textarea-chars-info" placeholder="Share any comments you would like to provide to us."><?php echo set_value('message'); ?></textarea>
						<i class="fa fa-comments"><!-- icon --></i>
						<span class="fancy-hint size-11 text-muted">
							<strong>Hint:</strong> 500 characters allowed!
							<span class="pull-right">
								<span id="textarea-chars-info"><span class="count-text_data">0</span>/500</span> Characters
								<script>
									var text_length=$(".char-count").val().length;
									$(".count-text_data").html(text_length);
								</script>
							</span>
						</span>
					</div>	
					<?php echo form_error('message','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>	
			</div>	
			

			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 text-right">
					<button type="submit" class="btn btn-success submit_data"><i class="fa fa-arrow-right"></i> Next</button>
					<a class="btn btn-success send_chat_loader" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Loading...</a>
				</div>
			</div>
		</form>
	</div>
</div>	
</div>	
</section>
<!-- / --> 


<script>
	$('.NumbersAndRange').keyup(function () { 
    	this.value = this.value.replace(/[^0-9]/g,'');
    	if(this.value > 2000){
    		this.value= 2000;
    	}
  });
		
	$(".new_person").click(function(){
		$("input[name=fname]").val('');
		$("input[name=lname]").val('');
		$("input[name=birth_date]").val('');
		$("input[name=zipcode]").val('');
	});


	//------ For Check Age and display dentition type -----------------------
	$(window).ready(function() {
		//------- For Range Picker -------------
		loadScript(plugin_path + 'jquery/jquery-ui.min.js', function() { /** jQuery UI **/
			loadScript(plugin_path + 'jquery/jquery.ui.touch-punch.min.js', function() { /** Mobile Touch Slider **/
				loadScript(plugin_path + 'form.slidebar/jquery-ui-slider-pips.min.js', function() { /** Slider Script **/
		            
		            var initialValue = $("#distance_travel").val() || 100;
		            console.log(initialValue)
					$("#slider5").slider({
						value: initialValue,
						animate: true,
						min: 0,
						max: 2000,
						step: 1,
						range: "min",
						slide: function(event, ui) {
							$("#distance_travel").val(ui.value);
							//------- For Tooltip -------
							var curValue = ui.value;
							var tooltip = '<div class="tooltip"><div class="tooltip-inner">' + curValue + '</div><div class="tooltip-arrow"></div></div>';
							$('.ui-slider-handle').html(tooltip);
							//-------------------------------
						}
					});

					$("#slider5").slider("pips" , {
						rest: false
					});	
					
					$("#distance_travel").val($("#slider5").slider("value"));
					$("#distance_travel").blur(function() {
						$("#slider5").slider("value", $(this).val());
						//------- For Tooltip -------
						var curValue = $(this).val() || initialValue;
						var tooltip = '<div class="tooltip"><div class="tooltip-inner">' + curValue + '</div><div class="tooltip-arrow"></div></div>';
						$('.ui-slider-handle').html(tooltip);
						//-------------------------------
					});

				});	
			});
		});
		//------- End For Range Picker -------------
	});

	$(".submit_data").click(function(event) {
		$(".submit_data").hide();
		$(".send_chat_loader").show();
	});

	$('.NumbersAndDot').keyup(function () { 
	    this.value = this.value.replace(/[^0-9.]/g,'');
	});


	function add_more_img(){
		var total_img_upload = $('.fancy-file-upload').length;		

		if(total_img_upload < 10){

			var fancy_html = '';
			fancy_html += '<div class="fancy-file-upload">';
			fancy_html += '<i class="fa fa-upload"></i>';
			fancy_html += '<input type="file" id="img_path_id_'+(total_img_upload+1)+'"  data-id="'+(total_img_upload+1)+'" class="form-control img_upload" name="img_path[]"/>';
			fancy_html += '<input type="text" id="img_path_txt_'+(total_img_upload+1)+'" class="form-control" placeholder="no file selected" readonly="" />';
			fancy_html += '<span class="button">Choose File</span>';
			fancy_html += '</div>';

			$('.all_file_uploads').append(fancy_html);

			if($('.fancy-file-upload').length > 1){
				$('#remove_btn').show();
			}else{
				$('#remove_btn').hide();
			}			
		}else{
			bootbox.alert('Can not enter more than 10 images.');
		}	
	}

	function remove_img(){
		$('.fancy-file-upload').last().remove();
		if($('.fancy-file-upload').length > 1){
			$('#remove_btn').show();
		}else{
			$('#remove_btn').hide();
		}
	}

	$(document).on('change','.img_upload',function(){		
		var d_id = $(this).attr('data-id');
		var files = $(this)[0].files;
		var file_text= files.length+" files selected";
		$('#img_path_txt_'+d_id).val(file_text);
	});


	$(".submit_data").click(function(event) {
		$(".submit_data").hide();
		$(".send_chat_loader").show();
	});
</script>


