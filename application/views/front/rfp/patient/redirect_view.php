<style>
	.rfp-title{
		border-bottom: 2px solid gray;
		margin-bottom: 0px;
		margin-top: 10px;
	}
</style>

<section class="page-header page-header-xs">
	<div class="container">
		<h1>Quick Request</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
			<li class="active"><a href="<?=base_url('rfp');?>">Quick Request List</a></li>			
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
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<h3 class="">
								We are forwarding you to our homepage (in 10 seconds), 
								as the requested URL is not available. If you require assistant, 
								kindly contact the provider of the URL.
							</h3>
							<a href="<?php echo base_url(); ?>" class="btn btn-primary">
								HomePage
							</a>
						</div>
					</div>	
					
				</form>
			</div>
		</div>
	</div>
</section>
<!-- / --> 
<script>
	setTimeout(function(){
		window.location.href = "<?php echo base_url(); ?>";
	},10000);
</script>


