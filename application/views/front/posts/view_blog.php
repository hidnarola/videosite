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
                    <?php
                    if (isset($blog))
                    {
                        ?>
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
                    <?php } ?>
                    <div class="form-group">
                        <textarea name="comments" class="form-control" placeholder="Add Comments *" ><?php echo set_value('comments'); ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
                            <button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> Add </button>
                        </div>
                    </div>

                    <?php
                    if ($user_loggedin == true)
                    {
                        ?>
                        <?php
                        if ($is_user_like == false)
                        {
                            ?>
                            <a href="<?php echo base_url() . 'user_post/like_post/' . $blog['id']; ?>" class="btn btn-success">
                                Like
                            </a>
                            <?php
                        }
                        else
                        {
                            ?>
                            <a href="<?php echo base_url() . 'user_post/unlike_post/' . $blog['id']; ?>" class="btn btn-danger">
                                Un-Like
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <div class="box_style_1 expose">
                        <h3 class="inner"> Share </h3>
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox_cmq4"></div>
                            </div>
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
//    $('#channel').val('<?php // echo $record["post_id"];         ?>');
</script>