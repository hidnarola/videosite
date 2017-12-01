<div class="home-listing">
    <h2>Suggested</h2>
    <ul class="ul-list">
        <?php foreach ($posts as $key => $post){?>
        <li>
            <div class="list-box">
                <div class="list-top"><a href=""><img src="<?php echo base_url() . $post['main_image'] ?>" alt=""/></a></div>
                <div class="list-btm">
                    <?php if ($post['post_type'] == 'blog'){?>
                    <a href="<?php echo base_url() . 'blog/' . $post['slug']; ?>"><?php echo $post['post_title'] ?></a> 
                        <?php } else if($post['post_type'] == 'gallery'){ ?>
                    <a href="<?php echo base_url() . 'gallery/' . $post['slug']; ?>"><?php echo $post['post_title'] ?></a>
                        <?php } else if($post['post_type'] == 'video'){  ?>
                    <a href="<?php echo base_url() . 'video/' . $post['slug']; ?>"><?php echo $post['post_title'] ?></a>
                        <?php }?>
                     <p>By : <?php echo $post['username'] ?> <span></span></p>
                     <h6><i class="fa fa-eye"></i> <?php echo $post['total_views'] ?></h6>
                     <!--<h6><i class="fa fa-clock-o"></i><?php get_ago_time($post['blog_created_date'], date("Y-m-d H:i:s")) ?></h6>-->
                </div>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>


