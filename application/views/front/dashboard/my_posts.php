
    <div class="home-listing">
        <h2>User Posts</h2>
        <ul class="ul-list">
            <?php
            
            if (!empty($posts))
            {
//                pr($session_info);
//                pr($posts);die;
                foreach ($posts as $post)
                {
                    if ($post['post_type'] == 'blog')
                    {
                        ?>
                        <li>
                            <div class="list-box">
                                <div class="list-top"><a href=""><img src="<?php echo base_url() . $post['bimg'] ?>" alt=""/></a> 
                                </div>
                                <div class="list-btm">
                                    <a href="<?php echo base_url() . 'blog/' . $post['slug']; ?>"><?php echo $post['blog_title'] ?></a>
                                    <p>By : <?php echo $session_info['username'] ?> <span></span></p>
                                    <h6><i class="fa fa-eye"></i> <?php echo $post['total_views'] ?> Views</h6>
                                    <h6><i class="fa fa-clock-o"></i><?php get_ago_time($post['blog_created_date'], date("Y-m-d H:i:s")) ?></h6>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                    elseif ($post['post_type'] == 'video')
                    {
                        ?>
                        <li>
                            <div class="list-box">
                                <div class="list-top"><a href=""><img src="<?php echo base_url() . $post['upload_path'] ?>" alt="" style="height: 100px;  width: 187px;"/></a> 
                                    <!--<span>10:53</span>-->
                                </div>
                                <div class="list-btm">
                                    <a href="<?php echo base_url() . 'video/' . $post['slug']; ?>"><?php echo $post['vtitle'] ?></a>
                                    <p>By : <?php echo $session_info['username'] ?> <span></span></p>
                                    <h6><i class="fa fa-eye"></i> <?php echo $post['total_views'] ?> Views</h6>
                                    <h6><i class="fa fa-clock-o"></i><?php get_ago_time($post['video_created_date'], date("Y-m-d H:i:s a")) ?></h6>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                    elseif ($post['post_type'] == 'gallery')
                    {
                        ?>
                        <li>
                            <div class="list-box">
                                <div class="list-top"><a href=""><img src="<?php echo base_url() . $post['gimg'] ?>" alt=""/></a> 
                                </div>
                                <div class="list-btm">
                                    <a href="<?php echo base_url() . 'gallery/' . $post['slug']; ?>"><?php echo $post['gtitle'] ?></a>
                                    <p>By : <?php echo $session_info['username'] ?> <span></span></p>
                                    <h6><i class="fa fa-eye"></i> <?php echo $post['total_views'] ?> Views</h6>
                                    <h6><i class="fa fa-clock-o"></i> <?php get_ago_time($post['gallery_created_date'], date("Y-m-d H:i:s a")) ?></h6>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                }
            }
            ?>
        </ul>
        <div id="pagination">
            <?php
            foreach ($links as $link)
            {
                echo $link;
            }
            ?>
        </div>
    </div>


