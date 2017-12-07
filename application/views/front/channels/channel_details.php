
<div class="chanelle-page">
    <div class="chanelle-head">
        <div class="chanelle-head-l">
            <?php if(!empty($channel_user)) { ?>
            <span><img src="<?php echo base_url().$channel_user['avatar']?>" alt=""/></span>
            <big><?php echo $channel_user['fname'].' '. $channel_user['lname']?> </big><small><?php echo $channel_user['designation']?></small>
            <?php } ?>
        </div>
        <div class="chanelle-head-r">
            <?php if($user_loggedin == true && $is_this_users_channel == false) { ?>
            <?php if($is_user_subscribe == false) { ?>
                <a href="<?php echo base_url().'user_channels/subscribe_channel/'.$res_channel['id']; ?>" class="bookmark-btn"><i class="fa fa-folder-open"></i>Subscribers  <span>(<?php echo $total_subscriber?>) </span></a>
            <?php } else { ?>
                <a href="<?php echo base_url().'user_channels/unsubscribe_channel/'.$res_channel['id']; ?>" class="bookmark-btn"><i class="fa fa-folder-open"></i>Subscribed  <span>(<?php echo $total_subscriber?>) </span></a>
            <?php } ?>
        <?php } else if($is_this_users_channel == true){
            ?>
                <a class="bookmark-btn"><i class="fa fa-folder-open"></i>Subscribers  <span>(<?php echo $total_subscriber?>) </span></a>
                <?php
        } ?>  
            
            <a href="" class="like-btn"><i class="fa fa-eye"></i> Views  <span>(<?php echo array_sum(array_column($channel_post,'total_views'))?>) </span></a>
        </div>
        </div>
        <div class="chanelle-body">
            <div class="chanelle-body-l">
                <ul class="list-ul comment-ul ">
                    <?php if(isset($comments)){ foreach ($comments as $key =>$comm){?>
                    <li>
                        <div class="list-ul-box">

                        <span><a class="cursor_pointer" href="">
                                <!--<img src="<?php echo base_url().$comm['avatar'];?>" alt="">-->
                                <img src="<?php echo base_url().$comm['avatar'];?>" alt="" onerror="this.src='<?php echo base_url().'uploads/avatars/user-icon-image-download.jpg'; ?>'"></a></span>
                            </a></span>
                        <h4><?php echo $comm['username']; ?></h4>                                
                        <p><?php echo word_limiter($comm['message'],10); ?></p>
                        </div>
                    </li>
                    <?php } }?>
                </ul>
            </div>


<div class="chanelle-body-r">
     <ul class="ul-list">
    <?php if (!empty($channel_post)) { foreach ($channel_post as $channel) {?>
        <li>
            <div class="list-box">
                <div class="list-top">
                <?php if($channel['post_type'] == 'blog'){?>
                    <a class="img-anchor" href="<?php echo base_url() . 'blog/' . $channel['slug']; ?>"><img src="<?php echo base_url() . $channel['main_image'] ?>" alt=""/></a>
                    <a href="" class="tag-a">A</a>
                    <?php } else if($channel['post_type'] == 'gallery'){?>
                    <a class="img-anchor" href="<?php echo base_url() . 'gallery/' . $channel['slug']; ?>"><img src="<?php echo base_url() . $channel['main_image'] ?>" alt=""/></a>
                    <a href="" class="tag-g">G</a>
                    <?php } else if($channel['post_type'] == 'video'){?>
                    <a class="img-anchor" href="<?php echo base_url() . 'video/' . $channel['slug']; ?>"><img src="<?php echo base_url() . $channel['main_image'] ?>" alt=""/></a>
                    <a href="" class="tag-v">V</a>
                    <?php } ?>
                </div>
                <div class="list-btm">
                    <?php if($channel['post_type'] == 'blog') {?>
                    <a href="<?php echo base_url() . 'blog/' . $channel['slug']; ?>"><?php echo $channel['post_title'] ?></a>
                    <?php } else if($channel['post_type'] == 'gallery') {?>
                    <a href="<?php echo base_url() . 'gallery/' . $channel['slug']; ?>"><?php echo $channel['post_title'] ?></a>
                    <?php } else if($channel['post_type'] == 'video') {?>
                    <a href="<?php echo base_url() . 'video/' . $channel['slug']; ?>"><?php echo $channel['post_title'] ?></a>
                    <?php } ?>
                    <p>By : <?php echo $channel['username'] ?> <span></span></p>
                    <h6><i class="fa fa-eye"></i> <?php echo $channel['total_views'] ?></h6>
                <!--<h6><i class="fa fa-clock-o"></i><?php get_ago_time($channel['blog_created_date'], date("Y-m-d H:i:s")) ?></h6>-->
                </div>
            </div>
        </li>
    <?php } } ?>
    </ul>
</div>
				

        </div>

    </div>

