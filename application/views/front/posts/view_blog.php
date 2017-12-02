<form method="post" action="" id="frmblog" enctype="multipart/form-data">
    <?php // echo validation_errors(); ?>
    <div class="listing-l">
        <div class="head-bg-01">
            <h2><?php echo $posts['post_title'] ?></h2>
            <p>By : <a href="<?php echo base_url() . 'channel/' . $posts['channel_slug']; ?>" target="_blank"><?php echo $posts['channel_name'] ?></a> <span class="verify-user"></span> </p> <p><i class="fa fa-eye"></i> <?php echo $posts['total_views'] ?> Views</p>
            <div class="r-links">
                <?php if ($user_loggedin == true){
        if ($is_user_bookmark == false){ ?>
      <a href="<?php echo base_url() . 'home/bookmark_post/' . $posts['id']; ?>" class="bookmark-btn"><i class="fa fa-folder-open"></i>Bookmark<small></small></a>
        <?php } else { ?>
        <a href="<?php echo base_url() . 'home/unbookmark_post/' . $posts['id']; ?>" class="bookmark-btn"><i class="fa fa-folder-open"></i>Bookmarked<small></small></a>
    <?php } } ?>
                
                
                
                 <?php if ($user_loggedin == true){
        if ($is_user_like == false){ ?>
            <a href="<?php echo base_url() . 'home/like_post/' . $posts['id']; ?>" class="like-btn"><i class="fa fa-thumbs-up"></i>like <small><?php echo $liked;?></small></a>
            <?php } else { ?>
            <a href="<?php echo base_url() . 'home/unlike_post/' . $posts['id']; ?>" class="like-btn"><i class="fa fa-thumbs-up"></i>Liked <small><?php echo $liked;?></small></a>
    <?php } } ?>
                
                
                
            </div>
        </div>
        <div class="listing-l-div">
            <?php if (isset($posts)) {?>
              <?php  if ($posts['post_type'] == 'blog') 
//            ==================================Blogs========================================================
                     { foreach ($blog as $key => $blogs){ ?>
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
                        <?php } } 
//          ==================================Blogs========================================================

//          ==================================Gallery========================================================
                        elseif ($posts['post_type'] == 'gallery') { foreach ($gallery as $key => $gal) { ?>
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
                        <?php } } 
//          ==================================Gallery========================================================
//          ==================================Video========================================================
                        elseif ($posts['post_type'] == 'video') { ?>
                    <div class="big-img">
                        <a href=""><img src="<?php echo base_url() . $posts['upload_path'] ?>" alt="" /></a>
                    </div>
                    <div class="list-content">
                        <h2><?php echo $posts['vtitle'] ?></h2>
                        <p><?php echo $posts['description'] ?></p>
                    </div>
                    <?php } } ?>
 <!--==================================Video========================================================-->            
            
            <div class="comman-tab">
                <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#intro" aria-controls="home" role="tab" data-toggle="tab">Comments</a></li>
                        <li role="presentation"><a href="#data" aria-controls="profile" role="tab" data-toggle="tab">Feedback</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="intro">
                        <ul>
                            <?php if(isset($comments)){ foreach ($comments as $key =>$comm){?>
                            <li><?php echo $comm['message'];?></li>
                            <?php } }?>
                        </ul>
                        <div class="input-wrap comments">
                            <?php $all_erros = validation_errors();
                            if (!empty($all_erros))
                            { ?>
                                <div class="alert alert-danger"><?php echo $all_erros; ?></div>
<?php } ?>
                            <label class="label-css">Add Comments </label>
                            <input type="text" name="comments" id ="comments" placeholder="Comments" class="form-css" />

                            <div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
                                <button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> Add</button>
                            </div>
                        </div>
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
        <h3>Related <?php echo $new_var . 's'; ?></h3>
        <ul class="list-ul">
            <?php if (isset($related_posts)) { foreach ($related_posts as $key => $related) {  ?>
            <li>
                <div class="list-ul-box">
                        <span><a href=""><img src="<?php echo base_url() . $related['main_image'] ?>" alt="" /></a></span>
                        <?php if ($related['post_type'] == 'blog') { ?>
                            <h4><a href="<?php echo base_url() . 'blog/' . $related['slug']; ?>"><?php echo $related['post_title'] ?></a></h4>
                        <?php } else if($related['post_type'] == 'gallery') { ?>
                            <h4><a href="<?php echo base_url() . 'gallery/' . $related['slug']; ?>"><?php echo $related['post_title'] ?></a></h4>
                        <?php } else if($related['post_type'] == 'video') {?>
                            <h4><a href="<?php echo base_url() . 'video/' . $related['slug']; ?>"><?php echo $related['post_title'] ?></a></h4>
                        <?php }?>
                        <p><?php echo $related['username'] ?></p>
                        <h6><?php echo $related['total_views'] ?> Views</h6>
                    </div>
                </li>
            <?php } }?>
            <li class="ad-li"><a href=""><img src="<?php echo DEFAULT_ADMIN_IMAGE_PATH ?>front/ad-02.jpg" alt="" /></a></li>
        </ul>
    </div>    
</form>


