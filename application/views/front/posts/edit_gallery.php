<section>
    <div class="container">
        <div class="row">						
            <div class="col-md-12">
                <!-- login form -->

                <?php echo validation_errors(); ?>

                <form method="post" action="" id="frmgallery" enctype="multipart/form-data">
                    <div class="form-group">
                        <select class="form-control" data-placeholder="Select a Channel"  name="channel" id="channel">
                            <option value="">Select Channel</option> 
                            <?php
                            foreach ($all_channels as $key => $channel)
                            {
                                ?> 
                                <option value="<?php echo $channel['id']; ?>"><?php echo $channel['channel_name']; ?></option>
                            <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Title *" 
                               value="<?php echo set_value('title'); ?>" >
                    </div>
                    <div class="form-group">
                        <textarea name="description" class="form-control" placeholder="Description *" ><?php echo set_value('description'); ?></textarea>
                    </div>
                    <div class="form-group">
                        <input type="file" name="img_path[]" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
                            <button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> Create </button>
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