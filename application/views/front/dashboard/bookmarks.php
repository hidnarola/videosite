<div class="right-panel">
    <div class="home-listing">
        <h2>User Bookmarks</h2>
        <ul class="ul-list">
            <?php
            if (!empty($book))
            {
                foreach ($book as $books)
                {
                    if ($books['post_type'] == 'blog')
                    {
                        ?>
                        <li>
                            <div class="list-box">
                                <div class="list-top"><a href=""><img src="<?php echo base_url() . $books['bimg'] ?>" alt=""/></a> 
                                </div>
                                <div class="list-btm">
                                    <a href="<?php echo base_url() . 'blog/' . $books['slug']; ?>"><?php echo $books['blog_title'] ?></a>
                                    <p>By : <?php echo $books['username'] ?> <span></span></p>
                                    <h6><i class="fa fa-eye"></i> <?php echo $books['total_views'] ?></h6>
                                    <h6><i class="fa fa-clock-o"></i><?php get_ago_time($books['blog_created_date'], date("Y-m-d H:i:s")) ?></h6>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                    elseif ($books['post_type'] == 'video')
                    {
                        ?>
                        <li>
                            <div class="list-box">
                                <div class="list-top"><a href=""><img src="<?php echo base_url() . $books['upload_path'] ?>" alt="" style="height: 100px;  width: 187px;"/></a> 
                                    <!--<span>10:53</span>-->
                                </div>
                                <div class="list-btm">
                                    <a href="<?php echo base_url() . 'video/' . $books['slug']; ?>"><?php echo $books['vtitle'] ?></a>
                                    <p>By : <?php echo $books['username'] ?> <span></span></p>
                                    <h6><i class="fa fa-eye"></i> <?php echo $books['total_views'] ?></h6>
                                    <h6><i class="fa fa-clock-o"></i><?php get_ago_time($books['video_created_date'], date("Y-m-d H:i:s a")) ?></h6>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                    elseif ($books['post_type'] == 'gallery')
                    {
                        ?>
                        <li>
                            <div class="list-box">
                                <div class="list-top"><a href=""><img src="<?php echo base_url() . $books['gimg'] ?>" alt=""/></a> 
                                </div>
                                <div class="list-btm">
                                    <a href="<?php echo base_url() . 'gallery/' . $books['slug']; ?>"><?php echo $books['gtitle'] ?></a>
                                    <p>By : <?php echo $books['username'] ?> <span></span></p>
                                    <h6><i class="fa fa-eye"></i> <?php echo $books['total_views'] ?></h6>
                                    <h6><i class="fa fa-clock-o"></i> <?php get_ago_time($books['gallery_created_date'], date("Y-m-d H:i:s a")) ?></h6>
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
