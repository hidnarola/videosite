<?php // pr($all_channels);
//pr($record['post_id'], 1); ?>
<section>
    <div class="container">
        <div class="row">						
            <div class="col-md-12">
                <!-- login form -->

                <?php echo validation_errors(); ?>

                <form method="post" action="" id="frmblog" enctype="multipart/form-data">
                    <div class="form-group">
                        <select class="form-control" data-placeholder="Select a Channel"  name="channel" id="channel">
                            <?php
                                foreach ($all_channels as $key => $channel) {
                            ?> 
                                <option value="<?php echo $channel['id']; ?>">
                                    <?php echo $channel['channel_name']; ?></option>
                            <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="blog_title" class="form-control" placeholder="Blog Title *" value="<?php echo (isset($record['blog_title'])) ? $record['blog_title'] : set_value('blog_title'); ?>" >
                    </div>
                    <div class="form-group">
                        <textarea name="blog_description" class="form-control" placeholder="Blog Description *" ><?php echo (isset($record['blog_description'])) ? $record['blog_description'] : set_value('blog_description'); ?></textarea>
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

<script type="text/javascript">
    $('#channel').val('<?php echo $record["post_id"]; ?>');
</script>