<!-- Go to www.addthis.com/dashboard to customize your tools --> 
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5948f4fb5a7fea54"></script>
<form method="post" action="" id="frmblog" enctype="multipart/form-data">
    <?php if(!empty($posts)){ ?>
    <div class="listing-l">
        <div class="head-bg-01">
                <h2>
                <?php if($posts['post_type'] == 'blog') {?>
                <a href="" class="tag artical-tag">A</a>
                <?php } else if($posts['post_type'] == 'video') {?>
                <a href="" class="tag video-tag">V</a>
                <?php } else if($posts['post_type'] == 'gallery') {?>
                <a href="" class="tag gallery-tag">G</a>
                <?php } ?>
                    <?php echo $posts['post_title'] ?></h2>
                <div class="head-bg-btm">
                    <div class="user-pic-01">
                        <a data-fancybox href="<?php echo base_url() . $posts['main_image'];?>">                            
                            <img src="<?php echo base_url() . $posts['main_image'];?>" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'">
                        </a>
                        
                    </div>
                    <div class="head-bg-btm-l">
                        <h6><strong>Channel : </strong> 
                            <a href="<?php echo base_url() . 'channel/' . $posts['channel_slug']; ?>" target="_blank"><?php echo $posts['channel_name'] ?></a> <span class="verify-user"></span>
                        </h6>
                        <h5> Username : <?php echo $posts['username'] ?></h5>
                        <p><i class="fa fa-eye"></i> <?php echo $posts['total_views'] ?> Views </p>
                    </div>

                    <div class="r-links">
                         <?php if ($user_loggedin == true){
        if ($is_user_bookmark == false){ ?>
      <a href="<?php echo base_url() . 'home/bookmark_post/' . $posts['id']; ?>" class="bookmark-btn"><i class="fa fa-star"></i>Bookmark<small></small></a>
        <?php } else { ?>
        <a href="<?php echo base_url() . 'home/unbookmark_post/' . $posts['id']; ?>" class="bookmark-btn"><i class="fa fa-star"></i>Bookmarked<small></small></a>
    <?php } } ?>
                
                
                 <?php if ($user_loggedin == true){
         if ($is_user_like == false){ ?>
            <a href="<?php echo base_url() . 'home/like_post/' . $posts['id']; ?>" class="like-btn"><i class="fa fa-thumbs-up"></i>like <small><?php echo $liked;?></small></a>
            <?php } else { ?>
            <a href="<?php echo base_url() . 'home/unlike_post/' . $posts['id']; ?>" class="like-btn"><i class="fa fa-thumbs-up"></i>Liked <small><?php echo $liked;?></small></a>
    <?php } } else { ?>
            <a class="like-btn"><i class="fa fa-thumbs-up"></i>likes <small><?php echo $liked;?></small></a>    
    <?php } ?>
                    </div>
                </div>
            </div>
        <div class="listing-l-div">
            <?php if (isset($posts)) {?>
              <?php  if ($posts['post_type'] == 'blog') 
//            ==================================Blogs========================================================
                     { foreach ($blog as $key => $blogs){ ?>
                            <div class="big-img">
                                <a><img src="<?php echo base_url() . $blogs['img_path']; ?>" alt=""  onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
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
                            <a><img src="<?php echo base_url() . $gal['img_path'] ?>" alt=""  onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
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
                        elseif ($posts['post_type'] == 'video') { 
                            if($posts['embed_link'] == '') {
                    ?>                    
                        <div class="black-bg-video">
                            <div id="myDiv" style="width:100%">This text will be replaced with a player.</div>
                        </div>
                        <script src="https://content.jwplatform.com/libraries/sJ4UhosD.js"></script>
                        <script>
                        jwplayer("myDiv").setup({
                            "file": "<?php echo base_url() . $posts['upload_path']; ?>",
                            "image": "<?php echo base_url() . $posts['main_image']; ?>",
                            "height": 360,
                            "width": 640
                        });
                        </script>
                    <?php } else { 
                        echo $posts['embed_link'];
                    } ?>
                    <!--</div>-->
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
                        <ul class="list-ul comment-ul " id="post_comment_id">
                            <?php if(!empty(($comments))){ foreach ($comments as $key =>$comm){?>
                            <li>
                                <div class="list-ul-box">
                                <span><a class="cursor_pointer" href="">
                                        <img src="<?php echo base_url().$comm['avatar'];?>" alt="" onerror="this.src='<?php echo base_url().'uploads/avatars/user-icon-image-download.jpg'; ?>'"></a></span>
                                <h4><?php echo $comm['username']; ?></h4>                                
                                <p class="less" id="less_<?php echo $comm['id'];?>"><?php echo character_limiter($comm['message'],50); ?></p>
                        <p class="more" id="more_<?php echo $comm['id'];?>" style="display:none;"><?php echo $comm['message']; ?></p>
                        <a class="link_less" href="javascript:;" style="display:none;">Read Less</a>
                            <?php
                            if(strlen($comm['message']) > 50) {
                                echo "<a class='link_more' href='javascript:;'>Read More</a>";
                            } else { echo '';   }
                       ?>
                        </div>
                    </li>
                    <?php } } else { echo "<div class='alert alert-success'>No Comments Found.</div>"; }?>
                        </ul>
                        
                        

                        <?php if($total_comments > 5){?>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-left show_more_btn">
                            <a class="btn-black show_more cursor_pointer"> Show More</a>
                        </div>
                        <?php } ?>
                        
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
<?php if ($user_loggedin == true){?>
            <div class="box_style_1 expose">
                <h3 class="inner"> Share </h3>
                <div class="row">
                    <div class="col-xs-12">
                        <!--Go to www.addthis.com/dashboard to customize your tools-->  
                        <div class="addthis_inline_share_toolbox_cmq4"></div>
                    </div>
                </div>
            </div>
<?php } ?>
        </div>
    </div>
    <?php } ?>

    <input type="hidden" name="offset_comment" value="5" id="offset_comment">
    

    <div class="listing-r"> 
        <h3>Related <?php echo $new_var . 's'; ?></h3>
        <ul class="list-ul">
            <?php if (isset($related_posts)) { foreach ($related_posts as $key => $related) {   ?>
            <li>
                <div class="list-ul-box">
                        
                    <?php if ($related['post_type'] == 'blog') {  ?>
                    <span><a href="<?php echo base_url() . 'blog/' . $related['slug']; ?>"><img src="<?php echo base_url() . $related['main_image'] ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a></span>
                    <h4><a href="<?php echo base_url() . 'blog/' . $related['slug']; ?>"><?php echo character_limiter($related['post_title'],20); ?></a></h4>
                        <?php } else if($related['post_type'] == 'gallery') {  ?>
                    <span><a href="<?php echo base_url() . 'gallery/' . $related['slug']; ?>"><img src="<?php echo base_url() . $related['main_image'] ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a></span>
                    <h4><a href="<?php echo base_url() . 'gallery/' . $related['slug']; ?>"><?php echo character_limiter($related['post_title'],20); ?></a></h4>
                        <?php } else if($related['post_type'] == 'video') { ?>
                    <span><a href="<?php echo base_url() . 'video/' . $related['slug']; ?>"><img src="<?php echo base_url() . $related['main_image'] ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a></span>
                    <h4><a href="<?php echo base_url() . 'video/' . $related['slug']; ?>"><?php echo character_limiter($related['post_title'],20); ?></a></h4>
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
 
 $(document).ready(function() {
    // Configure/customize these variables.
  
//    ===========================================================Comments======================================
        $('.show_more').on('click', function () {

        var offset_comment = $('#offset_comment').val();
        // var total_comments = $('#total_comments').val();    

        var post_id = '<?php echo $posts['id']; ?>';
        $.ajax({
            url: '<?php echo base_url(); ?>home/ajax_load_comments/' + post_id,
            data:{offset_comment:offset_comment},
            dataType:"JSON",
            method: 'post',
            success: function (resp) {

                if (resp.status == 1) {
                    $('#post_comment_id').append(resp['all_html']);
                    $('#offset_comment').val(resp['offset_comment']);
                } else {
                    $('.show_more_btn').hide();
                    $.notify({              
                        message: 'No more comments found.',
                    },{
                        // settings
                        allow_dismiss: true,
                        newest_on_top: false,
                        animate: {
                            enter: 'animated lightSpeedIn',
                            exit: 'animated lightSpeedOut'
                        },
                        template: '<div data-notify="container" class="error-msg col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                            '<span data-notify="message">{2}</span>' +                  
                        '</div>' 
                    });
                }

            }
        });
    });
    
    
    
    
    $('.link_more').on('click', function(){
        $(this).siblings('.less').hide();
        $(this).hide();
        $(this).siblings('.more').show();
        $(this).siblings('.link_less').show();
        
    });
    
    $('.link_less').on('click', function(){
        $(this).siblings('.more').hide();
        $(this).hide();
        $(this).siblings('.less').show();
        $(this).siblings('.link_more').show();
        
    });
});
    

</script>

