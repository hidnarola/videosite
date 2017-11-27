<div class="right-panel">
    <section>
        <div class="container">
            <div class="row">						
                <div class="col-md-12">
                    <!-- login form -->

                    <?php echo validation_errors(); ?>

                    <form method="post" action="" id="frmblog" enctype="multipart/form-data">
                        <?php
                        if (isset($posts))
                        {
                            if ($posts['post_type'] == 'blog')
                            {
                                ?>

                                <div class="form-group">
                                    <b>Channel Name:</b> <?php echo $posts['channel_name']; ?>
                                </div>
                                <div class="form-group">
                                    <b> Title: </b> <?php echo $posts['blog_title']; ?>
                                </div>
                                <div class="form-group">
                                    <b> Description:</b> <?php echo $posts['blog_description']; ?>
                                </div>
                                <div class="form-group">
                                    <img src="<?php echo base_url() . $posts['bimg']; ?>"> 
                                </div>
                                <?php
                            }
                            elseif ($posts['post_type'] == 'gallery')
                            {
                                ?>
                                <div class="form-group">
                                    <b> Channel Name:</b> <?php echo $posts['channel_name']; ?>
                                </div>
                                <div class="form-group">
                                    <b> Title:</b> <?php echo $posts['gtitle']; ?>
                                </div>
                                <div class="form-group">
                                    <b>Description:</b> <?php echo $posts['description']; ?>
                                </div>
                                <div class="form-group">
                                    <img src="<?php echo base_url() . $posts['gimg']; ?>">
                                </div>
                                <?php
                            }
                            elseif ($posts['post_type'] == 'video')
                            {
                                ?>
                                <div class="form-group">
                                    <b> Channel Name:</b> <?php echo $posts['channel_name']; ?>
                                </div>
                                <div class="form-group">
                                    <b> Title:</b> <?php echo $posts['vtitle']; ?>
                                </div>
                                <div class="form-group">
                                    <b>Description:</b> <?php echo $posts['description']; ?>
                                </div>
                                <div class="form-group">
                                    <img src="<?php echo $posts['upload_path']; ?>">
                                </div>
                                <?php
                            }
                            ?>
                        <?php } ?>
                        <div class="col-md-9 col-sm-9 col-xs-9 form-group">                   
                            <textarea name="comments" class="form-control" placeholder="Add Comments *" ><?php echo set_value('comments'); ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-xs-9 text-right register-btn">
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
                                <a href="<?php echo base_url() . 'home/like_post/' . $posts['id']; ?>" class="btn btn-success">
                                    Like
                                </a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a href="<?php echo base_url() . 'home/unlike_post/' . $posts['id']; ?>" class="btn btn-danger">
                                    Un-Like
                                </a>
                            <?php } ?>
                        <?php } ?>

                        <?php
                        if ($user_loggedin == true)
                        {
                            ?>
                            <?php
                            if ($is_user_bookmark == false)
                            {
                                ?>
                                <a href="<?php echo base_url() . 'home/bookmark_post/' . $posts['id']; ?>" class="btn btn-success">
                                    BookMark
                                </a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a href="<?php echo base_url() . 'home/unbookmark_post/' . $posts['id']; ?>" class="btn btn-danger">
                                    Un-BookMark
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
</div>
<!-- / -->

<script type="text/javascript">
//    $('#channel').val('<?php // echo $record["post_id"];                            ?>');
</script>