<div class="white-box">
    <h3 class="h3-title">User Bookmarks</h3>
    <div class="home-listing">
        <ul class="ul-list">
        <?php if (!empty($book)) { foreach ($book as $books) {?>
            <li>
                <div class="list-box">
                    <div class="list-top">
                    <?php if($books['post_type'] == 'blog'){?>
                        <a class="img-anchor" href="<?php echo base_url() . 'blog/' . $books['slug']; ?>"><img src="<?php echo base_url() . $books['main_image'] ?>" alt=""/></a>
                        <a href="" class="tag-a">A</a>
                        <?php } else if($books['post_type'] == 'gallery'){?>
                        <a class="img-anchor" href="<?php echo base_url() . 'gallery/' . $books['slug']; ?>"><img src="<?php echo base_url() . $books['main_image'] ?>" alt=""/></a>
                        <a href="" class="tag-g">G</a>
                        <?php } else if($books['post_type'] == 'video'){?>
                        <a class="img-anchor" href="<?php echo base_url() . 'video/' . $books['slug']; ?>"><img src="<?php echo base_url() . $books['main_image'] ?>" alt=""/></a>
                        <a href="" class="tag-v">V</a>
                        <?php } ?>
                    </div>
                    <div class="list-btm">
                        <?php if($books['post_type'] == 'blog') {?>
                        <a href="<?php echo base_url() . 'blog/' . $books['slug']; ?>"><?php echo $books['post_title'] ?></a>
                        <?php } else if($books['post_type'] == 'gallery') {?>
                        <a href="<?php echo base_url() . 'gallery/' . $books['slug']; ?>"><?php echo $books['post_title'] ?></a>
                        <?php } else if($books['post_type'] == 'video') {?>
                        <a href="<?php echo base_url() . 'video/' . $books['slug']; ?>"><?php echo $books['post_title'] ?></a>
                        <?php } ?>
                        <p>By : <?php echo $books['username'] ?> <span></span></p>
                        <h6><i class="fa fa-eye"></i> <?php echo $books['total_views'] ?> </h6>
                    <!--<h6><i class="fa fa-clock-o"></i><?php get_ago_time($books['blog_created_date'], date("Y-m-d H:i:s")) ?></h6>-->
                    </div>
                </div>
            </li>
        <?php } } ?>
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
