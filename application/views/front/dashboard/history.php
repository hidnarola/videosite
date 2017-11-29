<div class="right-panel">
    <div class="home-listing">
        <h2>User History</h2>
        <ul class="ul-list">
            <?php
            if (!empty($history))
            {
                foreach ($history as $his)
                {
                    if ($his['post_type'] == 'blog')
                    {
                        ?>
                        <li>
                            <div class="list-box">
                                <div class="list-top"><a href=""><img src="<?php echo base_url() . $his['bimg'] ?>" alt=""/></a> 
                                </div>
                                <div class="list-btm">
                                    <a href="<?php echo base_url() . 'blog/' . $his['slug']; ?>"><?php echo $his['blog_title'] ?></a>
                                    <p>By : <?php echo $his['username'] ?> <span></span></p>
                                    <h6><i class="fa fa-eye"></i> <?php echo $his['total_views'] ?></h6>
                                    <h6><i class="fa fa-clock-o"></i><?php get_ago_time($his['blog_created_date'], date("Y-m-d H:i:s")) ?></h6>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                    elseif ($his['post_type'] == 'video')
                    {
                        ?>
                        <li>
                            <div class="list-box">
                                <div class="list-top"><a href=""><img src="<?php echo base_url() . $his['upload_path'] ?>" alt="" style="height: 100px;  width: 187px;"/></a> 
                                    <!--<span>10:53</span>-->
                                </div>
                                <div class="list-btm">
                                    <a href="<?php echo base_url() . 'video/' . $his['slug']; ?>"><?php echo $his['vtitle'] ?></a>
                                    <p>By : <?php echo $his['username'] ?> <span></span></p>
                                    <h6><i class="fa fa-eye"></i> <?php echo $his['total_views'] ?></h6>
                                    <h6><i class="fa fa-clock-o"></i><?php get_ago_time($his['video_created_date'], date("Y-m-d H:i:s a")) ?></h6>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                    elseif ($his['post_type'] == 'gallery')
                    {
                        ?>
                        <li>
                            <div class="list-box">
                                <div class="list-top"><a href=""><img src="<?php echo base_url() . $his['gimg'] ?>" alt=""/></a> 
                                </div>
                                <div class="list-btm">
                                    <a href="<?php echo base_url() . 'gallery/' . $his['slug']; ?>"><?php echo $his['gtitle'] ?></a>
                                    <p>By : <?php echo $his['username'] ?> <span></span></p>
                                    <h6><i class="fa fa-eye"></i> <?php echo $his['total_views'] ?></h6>
                                    <h6><i class="fa fa-clock-o"></i> <?php get_ago_time($his['gallery_created_date'], date("Y-m-d H:i:s a")) ?></h6>
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

</div>
