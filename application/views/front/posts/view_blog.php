<form method="post" action="" id="frmblog" enctype="multipart/form-data">
    <?php echo validation_errors(); ?>
    <div class="right-panel">
    <?php if ($user_loggedin == true){
        if ($is_user_like == false){ ?>
            <a href="<?php echo base_url() . 'home/like_post/' . $posts['id']; ?>" class="btn btn-success">Like</a>
            <?php } else { ?>
            <a href="<?php echo base_url() . 'home/unlike_post/' . $posts['id']; ?>" class="btn btn-danger">Un-Like</a>
    <?php } } ?>

    <?php if ($user_loggedin == true){
            if ($is_user_bookmark == false){ ?>
            <a href="<?php echo base_url() . 'home/bookmark_post/' . $posts['id']; ?>" class="btn btn-success">BookMark</a>
            <?php } else { ?>
            <a href="<?php echo base_url() . 'home/unbookmark_post/' . $posts['id']; ?>" class="btn btn-danger">Un-BookMark</a>
            <?php } } ?>
        <div class="listing-l">
            <div class="listing-l-div">
                <?php if (isset($posts)) {
                    if ($posts['post_type'] == 'blog') { foreach ($blog as $key => $blogs){ ?>
                <h4>Channel Name: </h4> <?php echo $posts['channel_name'] ?>
                <br><br>
                                <div class="big-img">
                                    <a href=""><img src="<?php echo base_url() . $blogs['img_path'] ?>" alt="" /></a>
                                    <?php if($count_blog > 1) { ?>
                                        <span><?php echo $key +1; ?> <small>of <?php echo $count_blog; ?></small></span>
                                    <?php } ?>
                                </div>
                            <div class="list-content">
                                <h2><?php echo $blogs['blog_title'] ?></h2>
                                <p><?php echo $blogs['blog_description'] ?></p>
                            </div>
                            <?php } } elseif ($posts['post_type'] == 'gallery') { foreach ($gallery as $key => $gal) { ?>
                            <div class="big-img">
                                <a href=""><img src="<?php echo base_url() . $gal['img_path'] ?>" alt="" /></a>
                                <?php if($count_gallery > 1) { ?>
                                <span><?php echo $key +1; ?> <small>of <?php echo $count_gallery?></small></span>
                                <?php } ?>
                            </div>
                            <div class="list-content">
                                <h2><?php echo $gal['title'] ?></h2>
                                <p><?php echo $gal['description'] ?></p>
                            </div>
                            <?php } } elseif ($posts['post_type'] == 'video') { ?>
                        <div class="big-img">
                            <a href=""><img src="<?php echo base_url() . $posts['upload_path'] ?>" alt="" /></a>
                            <!--<span>06 <small>of 40</small></span>-->
                        </div>
                        <div class="list-content">
                            <h2><?php echo $posts['vtitle'] ?></h2>
                            <p><?php echo $posts['description'] ?></p>
                        </div>
                        <?php } } ?>
                <div class="list-content">
                    <a href="">Comments</a>
                </div>
                
                
    <div class="comman-tab">
        <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#intro" aria-controls="home" role="tab" data-toggle="tab">Comment</a></li>
                <li role="presentation"><a href="#data" aria-controls="profile" role="tab" data-toggle="tab">Feedback</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="intro">
                        <p class="general-text">When an unknown printer took a galley of type and scrambled it to make a type specimen book has survived not only five centuries b also the leap the lectronic typesetting remaining essentially unchanged.</p>
            </div>
            <div role="tabpanel" class="tab-pane" id="data">
                <p class="general-text">Has been the industry's standard dummy text ever since the is simply dummy text of the printing and typesetting industry been industry's standard dummy text eversince thehas survived not only five centuries but also the leap into electronic typesettwas popularised in the was popularised in the with the release of etraset sheets containing and more recently with desktop publishing software like aldus pageMaker including versions.</p>
            </div>
        </div>
    </div>
	
                <div class="box_style_1 expose">
                    <h3 class="inner"> Share </h3>
                    <div class="row">
                        <div class="col-xs-12">
                            <!--Go to www.addthis.com/dashboard to customize your tools-->  
                            <div class="addthis_inline_share_toolbox_cmq4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="listing-r"> 
                <?php if (isset($posts))
                {
                    if ($posts['post_type'] == 'blog')
                    {
                        foreach ($blog as $key => $blogs)
                        {
                            ?>
                            <h3>Related <?php echo $posts['post_type'] . 's'; ?></h3>
                            <ul class="list-ul">
                                <li>
                                    <div class="list-ul-box">
                                        <span><a href=""><img src="<?php echo DEFAULT_ADMIN_IMAGE_PATH ?>front/img02.jpg" alt="" /></a></span>
                                        <h4><a href="">When an unknown printer took a  of.</a></h4>
                                        <p>By : Scrambled it to</p>
                                        <h6>1,50.000 Views</h6>
                                    </div>
                                </li>
                                <li class="ad-li"><a href=""><img src="<?php echo DEFAULT_ADMIN_IMAGE_PATH ?>front/ad-02.jpg" alt="" /></a></li>
                            </ul>
            <?php       }
                    }
                } ?>

            </div>
    </div>
</form>