 <div class="form-element">
        <h3 class="h3-title">Edit Channel</h3>
    
        <?php 
            $all_erros = validation_errors(); 
            if(!empty($all_erros)){
        ?>
            <div class="alert alert-danger"><?php echo $all_erros; ?></div>
        <?php } ?>

            <form method="post" action="" id="frmeditprofile" enctype="multipart/form-data">		
                <div class="input-wrap">
                    <label class="label-css">Channel Name: </label>
                    <?php if ($_POST)
                    {
                        $post_channel_name = set_value('channel_name');
                    }
                    else
                    {
                        $post_channel_name = $channel_data['channel_name'];
                    } ?>
                    <input type="text" name="channel_name" class="form-css" placeholder="Channel Name *"   value="<?php echo $post_channel_name; ?>" >
                </div>				
                <div class="btn-btm">
                <button class="common-btn btn-submit" type="submit">Submit</button>
                <!-- <button class="common-btn btn-reset" type="reset">Reset</button> -->
            </div>
<!--					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
							<button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> Create </button>
						</div>
					</div>-->
                                 </form>
	 </div>	