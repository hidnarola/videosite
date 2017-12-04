<div class="form-element">
    <h3 class="h3-title">Add Channel</h3>
        <?php 
            $all_erros = validation_errors(); 
            if(!empty($all_erros)){ ?>
            <div class="alert alert-danger"><?php echo $all_erros; ?></div>
        <?php } ?>
				
        <?php echo validation_errors(); ?>
    <form method="post" action="" id="frmeditprofile" enctype="multipart/form-data">		
        <div class="input-wrap">
            <label class="label-css">Channel Name: </label>
            <input type="text" name="channel_name" class="form-css" placeholder="Channel Name *"   value="<?php echo set_value('channel_name'); ?>" >
        </div>				
        <div class="btn-btm">
            <button class="common-btn btn-submit" type="submit">Submit</button>
        </div>
    </form>
</div>	