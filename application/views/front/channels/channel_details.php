<?php // pr($posts);die;?>
<div class="chanelle-page">
    <div class="chanelle-head">
        <div class="chanelle-head-l">
            <span><img src="<?php echo base_url().$session_info['avatar']?>" alt=""/></span>
            <big><?php echo $session_info['fname'].' '. $session_info['lname']?> </big><small>Author, Blogger</small>
        </div>
        <div class="chanelle-head-r">
            <a href="" class="bookmark-btn"><i class="fa fa-folder-open"></i>Subscribers  <span>(<?php echo $total_subscriber?>) </span></a>
            <a href="" class="like-btn"><i class="fa fa-thumbs-up"></i> Views  <span>(<?php echo array_sum(array_column($post,'total_views'))?>) </span></a>
        </div>
        </div>
        <div class="chanelle-body">
            <div class="chanelle-body-l">
                <?php foreach($comments as $key => $comm){ echo '<ul><li>'.$comm['message'].'</ul></li>';}?>
            </div>
<!--            <div class="chanelle-body-r">
                <ul class="ul-list">
                    <?php foreach($post as $key => $posts){  ?>
                    <li>
                        <div class="list-box">
                            <div class="list-top"><a href=""><img src="<?php echo base_url() . $posts['main_image'] ?>" alt="" /></a></div>
                            <div class="list-btm">
                                <a href="<?php echo base_url() . 'video/' . $posts['slug']; ?>"> <?php echo $posts['vtitle'];?> </a> 
                                    
                                
                                <p>By : <?php echo $session_info['username'];?> <span></span></p>
                                <h6><i class="fa fa-eye"></i><?php echo $posts['total_views']?> </h6>
                                <h6><i class="fa fa-clock-o">nvbfsdjkbflkjsbfljkds</i>
                            <?php 
                                If($posts['post_type'] == 'blog'){
                                    echo get_ago_time($posts['blog_created_date'], date("Y-m-d H:i:s")) ;
                                }
                                else if($posts['post_type'] == 'gallery'){
                                    echo get_ago_time($posts['gallery_created_date'], date("Y-m-d H:i:s")) ;
                                }
                                else if($posts['post_type'] == 'video'){
                                    echo get_ago_time($posts['video_created_date'], date("Y-m-d H:i:s")) ;
                                }
                            ?>
                                </h6>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                </ul>	
            </div>-->

<div class="chanelle-body-r">
     <ul class="ul-list">
    <?php if (!empty($post)) { foreach ($post as $posts) {?>
        <li>
            <div class="list-box">
                <div class="list-top">
                <?php if($posts['post_type'] == 'blog'){?>
                    <a href="<?php echo base_url() . 'blog/' . $posts['slug']; ?>"><img src="<?php echo base_url() . $posts['main_image'] ?>" alt=""/></a>
                    <a href="" class="tag-a">A</a>
                    <?php } else if($posts['post_type'] == 'gallery'){?>
                    <a href="<?php echo base_url() . 'gallery/' . $posts['slug']; ?>"><img src="<?php echo base_url() . $posts['main_image'] ?>" alt=""/></a>
                    <a href="" class="tag-g">G</a>
                    <?php } else if($posts['post_type'] == 'video'){?>
                    <a href="<?php echo base_url() . 'video/' . $posts['slug']; ?>"><img src="<?php echo base_url() . $posts['main_image'] ?>" alt=""/></a>
                    <a href="" class="tag-v">V</a>
                    <?php } ?>
                </div>
                <div class="list-btm">
                    <?php if($posts['post_type'] == 'blog') {?>
                    <a href="<?php echo base_url() . 'blog/' . $posts['slug']; ?>"><?php echo $posts['post_title'] ?></a>
                    <?php } else if($posts['post_type'] == 'gallery') {?>
                    <a href="<?php echo base_url() . 'gallery/' . $posts['slug']; ?>"><?php echo $posts['post_title'] ?></a>
                    <?php } else if($posts['post_type'] == 'video') {?>
                    <a href="<?php echo base_url() . 'video/' . $posts['slug']; ?>"><?php echo $posts['post_title'] ?></a>
                    <?php } ?>
                    <p>By : <?php echo $posts['username'] ?> <span></span></p>
                    <h6><i class="fa fa-eye"></i> <?php echo $posts['total_views'] ?> Views</h6>
                <!--<h6><i class="fa fa-clock-o"></i><?php get_ago_time($posts['blog_created_date'], date("Y-m-d H:i:s")) ?></h6>-->
                </div>
            </div>
        </li>
    <?php } } ?>
    </ul>
</div>
				

        </div>

    </div>

