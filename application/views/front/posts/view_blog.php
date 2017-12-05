<form method="post" action="" id="frmblog" enctype="multipart/form-data">
    <?php // pr($posts); ?>
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
                                <a href=""><img src="<?php echo base_url() . $blogs['img_path']; ?>" alt="" /></a>
                                <?php if($count_blog > 1) { ?>
                                    <span><?php echo $key +1; ?> <small>of <?php echo $count_blog; ?></small></span>
                                <?php } ?>
                            </div>
                        <div class="list-content">
                            <h2><?php echo $blogs['blog_title']; ?></h2>
                            <p><?php echo htmlspecialchars_decode($blogs['blog_description']); ?></p>
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
                            <h2><?php echo $gal['title']; ?></h2>
                            <p><?php echo htmlspecialchars_decode($gal['description']); ?></p>
                        </div>
                        <?php } } 
//          ==================================Gallery========================================================
//          ==================================Video========================================================
                        elseif ($posts['post_type'] == 'video') { ?>
                    <div class="big-img">
                        <!--<img src="<?php echo base_url() . $posts['upload_path']; ?>" alt="" />-->
                        <a href="">
                            <video width="100%" controls>
                                <source src="<?php echo base_url() . $posts['upload_path']; ?>" type="video/mp4">
                            </video>
                        </a>
                    </div>
                    <div class="list-content">
                        <h2><?php echo $posts['vtitle']; ?></h2>
                        <p><?php echo htmlspecialchars_decode($posts['description']); ?></p>
                        
                    </div>
                    <?php } } ?>
 <!--==================================Video========================================================-->            
            
            <div class="comman-tab">
                <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#intro" aria-controls="home" role="tab" data-toggle="tab">Comments</a></li>
                        <li role="presentation"><a href="#data" aria-controls="profile" role="tab" data-toggle="tab">More Info</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="intro">
                        <ul class="list-ul comment-ul ">
                            <?php if(isset($comments)){ foreach ($comments as $key =>$comm){?>
                            <!-- <li><?php echo $comm['message'];?></li> -->
                            <li>
                                <div class="list-ul-box">
                                        
                                <span><a class="cursor_pointer" href=""><img src="<?php echo base_url().$comm['avatar'];?>" alt=""></a></span>
                                <h4><?php echo $comm['username']; ?></h4>                                
                                <p><?php echo $comm['message']; ?></p>
                                </div>
                            </li>
                            <?php } }?>
                        </ul>
                        <?php if ($user_loggedin == true){?>
                        <div class="input-wrap comments">
                            <?php $all_erros = validation_errors();
                            if (!empty($all_erros))
                            { ?>
                                <div class="alert alert-danger"><?php echo $all_erros; ?></div>
<?php } ?>
                            <label class="label-css">Add Comments </label>
                            <textarea name="comments" id="comments" cols="30" rows="10"></textarea>
                            <div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
                                <button type="submit" class="btn-black"> Add</button>
                            </div>
                        </div>
                        <?php } ?>
                </div>
                    <div role="tabpanel" class="tab-pane" id="data">
                        <p class="general-text">
                        <div class="Content-discovery d-flex flex-column flex-md-row justify-content-around">
                            <div class="Content-channels"><h4>Channel</h4>
                                <ul>
                                    <li><a href="<?php echo base_url(); ?>">Home Page</a></li>
                                    <li><a href="<?php echo base_url() . 'channel/' . $posts['channel_slug']; ?>" target="_blank"><?php echo $posts['channel_name'] ?></a></li>
                                </ul>
                            </div>
                            <div class="Content-categories"><h4>Category</h4>
                                <ul>
                                    <li><a href="<?php echo base_url() . 'category_detail_page/' . $posts['category_id']; ?>" target="_blank"><?php echo $posts['category'] ?></a></li>
                                </ul>
                            </div>
                            <div class="Content-tags"><h4>Explore</h4>
				<span><a href="<?php echo base_url() . 'category_detail_page/' . $posts['category_id']; ?>/sub/<?php echo $posts['sub_category_id']?>" target="_blank"><?php echo $posts['sub_category'] ?></a></span>
                            </div>

			</div>
                        </p>
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
                        
                        <?php if ($related['post_type'] == 'blog') { ?>
                    <span><a href="<?php echo base_url() . 'blog/' . $related['slug']; ?>"><img src="<?php echo base_url() . $related['main_image'] ?>" alt="" /></a></span>    
                    <h4><a href="<?php echo base_url() . 'blog/' . $related['slug']; ?>"><?php echo $related['post_title'] ?></a></h4>
                        <?php } else if($related['post_type'] == 'gallery') { ?>
                    <span><a href="<?php echo base_url() . 'gallery/' . $related['slug']; ?>"><img src="<?php echo base_url() . $related['main_image'] ?>" alt="" /></a></span>        
                    <h4><a href="<?php echo base_url() . 'gallery/' . $related['slug']; ?>"><?php echo $related['post_title'] ?></a></h4>
                        <?php } else if($related['post_type'] == 'video') {?>
                    <span><a href="<?php echo base_url() . 'video/' . $related['slug']; ?>"><img src="<?php echo base_url() . $related['main_image'] ?>" alt="" /></a></span>        
                    <h4><a href="<?php echo base_url() . 'video/' . $related['slug']; ?>"><?php echo $related['post_title'] ?></a></h4>
                        <?php }?>
                        <p><?php echo $related['username'] ?></p>
                        <h6><?php echo $related['total_views'] ?> <i class="fa fa-eye"></i></h6>
                    </div>
                </li>
            <?php } }?>
            <li class="ad-li"><a href=""><img src="<?php echo DEFAULT_ADMIN_IMAGE_PATH ?>front/ad-02.jpg" alt="" /></a></li>
        </ul>
    </div>    
</form>
<script>
//    $('#frmblog').validate();
$("#frmblog").validate({
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        validClass: "validation-valid-label",
        success: function (label) {
            label.addClass("validation-valid-label").text("Success.")
        },
        rules: {
            comments: {
                required: true,
            }
        },
        messages: {
            comments: {
                required: "Please provide Comments",
            }
        }
    });
</script>

