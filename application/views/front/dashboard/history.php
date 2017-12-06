<div class="white-box">
    <h3 class="h3-title">User History</h3>
</div>

<div class="home-listing">
    <ul class="ul-list">
    <?php if (!empty($history)) { foreach ($history as $his) {?>
        <li>
            <div class="list-box">
                <div class="list-top">
                <?php if($his['post_type'] == 'blog'){?>
                    <a class="img-anchor" href="<?php echo base_url() . 'blog/' . $his['slug']; ?>"><img src="<?php echo base_url() . $his['main_image'] ?>" alt=""/></a>
                    <a href="" class="tag-a">A</a>
                    <?php } else if($his['post_type'] == 'gallery'){?>
                    <a class="img-anchor" href="<?php echo base_url() . 'gallery/' . $his['slug']; ?>"><img src="<?php echo base_url() . $his['main_image'] ?>" alt=""/></a>
                    <a href="" class="tag-g">G</a>
                    <?php } else if($his['post_type'] == 'video'){?>
                    <a class="img-anchor" href="<?php echo base_url() . 'video/' . $his['slug']; ?>"><img src="<?php echo base_url() . $his['main_image'] ?>" alt=""/></a>
                    <a href="" class="tag-v">V</a>
                    <?php } ?>
                </div>
                <div class="list-btm">
                    <?php if($his['post_type'] == 'blog') {?>
                    <a href="<?php echo base_url() . 'blog/' . $his['slug']; ?>"><?php echo $his['post_title'] ?></a>
                    <?php } else if($his['post_type'] == 'gallery') {?>
                    <a href="<?php echo base_url() . 'gallery/' . $his['slug']; ?>"><?php echo $his['post_title'] ?></a>
                    <?php } else if($his['post_type'] == 'video') {?>
                    <a href="<?php echo base_url() . 'video/' . $his['slug']; ?>"><?php echo $his['post_title'] ?></a>
                    <?php } ?>
                    <p>By : <?php echo $his['username'] ?> <span></span></p>
                    <h6><i class="fa fa-eye"></i> <?php echo $his['total_views'] ?></h6>
                <!--<h6><i class="fa fa-clock-o"></i><?php get_ago_time($his['blog_created_date'], date("Y-m-d H:i:s")) ?></h6>-->
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
