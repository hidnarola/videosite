<?php
// pr($all_channels);
//pr($record['post_id'], 1); 
?>
<section>
    <div class="container">
        <div class="row">						
            <div class="col-md-12">
                <!-- login form -->

                <?php echo validation_errors(); ?>

                <form method="post" action="" id="frmblog" enctype="multipart/form-data">

                    <div class="form-group">
                        Channel Name: <?php echo $blog['channel_name']; ?>
                    </div>
                    <div class="form-group">
                        Blog Title: <?php echo $blog['blog_title']; ?>
                    </div>
                    <div class="form-group">
                        Blog Description: <?php echo $blog['blog_description']; ?>
                    </div>
                    <div class="form-group">
                        Blog Image: <?php echo $blog['img_path']; ?>
                    </div>
                    <div class="form-group">
                        <textarea name="comments" class="form-control" placeholder="Add Comments *" ><?php echo set_value('comments'); ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
                            <button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> Add </button>
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