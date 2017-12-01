<?php // pr($post);die;?>
    <div class="chanelle-page">
        <div class="chanelle-head">
            <div class="chanelle-head-l">
                <?php // pr($session_info);?>
                <span><img src="<?php echo base_url().$session_info['avatar']?>" alt=""/></span>
                <big><?php echo $session_info['fname'].' '. $session_info['lname']?> 
                    <!--(Username: <?php // echo $session_info['username']?>)-->
                </big><small>Author, Blogger</small>
            </div>
            <div class="chanelle-head-r">
                <a href="">Subscribers  <span>(<?php echo $total_subscriber?>) </span></a>
                <a href="">Views  <span>(<?php echo array_sum(array_column($post,'total_views'))?>) </span></a>
            </div>
        </div>
        <div class="chanelle-body">
            <div class="chanelle-body-l">
<?php foreach($comments as $key => $comm){
 echo '<ul><li>'.$comm['message'].'</ul></li>';   
}?>

            </div>
            <div class="chanelle-body-r">
                <ul class="ul-list">
                    <?php // pr($post);?>
                    <?php foreach($post as $key => $posts){  ?>
                    <li>
                        <div class="list-box">
                            <div class="list-top"><a href="">
                                        <?php
                                        if ($posts['post_type'] == 'blog')
                                        {
                                            ?>
                                            <img src="<?php echo base_url() . $posts['bimg'] ?>" alt="" />
                                        <?php
                                        }
                                        else if ($posts['post_type'] == 'gallery')
                                        {
                                            ?>
                                            <img src="<?php echo base_url() . $posts['gimg'] ?>" alt="" />
                                        <?php
                                        }
                                        else if ($posts['post_type'] == 'video')
                                        {
                                            ?>
                                            
                                            <img src="<?php echo base_url() . $posts['upload_path'] ?>" alt="" />
    <?php } ?>
                                    </a> <span>10:53</span></div>
                            <div class="list-btm">
                                <?php // pr($posts);die;?>
                                    <?php 

                                        if ($posts['post_type'] == 'blog')
                                        {
                                            ?>
                                <a href="<?php echo base_url() . 'blog/' . $posts['slug']; ?>"> <?php echo $posts['blog_title'];?> </a>           
                                <?php        }
                                        else if($posts['post_type'] == 'gallery')
                                        {?>
                                            <a href="<?php echo base_url() . 'gallery/' . $posts['slug']; ?>"> <?php echo $posts['gtitle'];?> </a> 
                                            <?php
                                        }
                                        else if($posts['post_type'] == 'video')
                                        {?>
                                           <a href="<?php echo base_url() . 'video/' . $posts['slug']; ?>"> <?php echo $posts['vtitle'];?> </a> 
                                           <?php
                                        }
                                    ?>
                                    
                                
                                <p>By : <?php echo $session_info['username'];?> <span></span></p>
                                <h6><i class="fa fa-eye"></i><?php echo $posts['total_views']?> </h6>
                                <h6><i class="fa fa-clock-o"></i>
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
            </div>
        </div>

    </div>

