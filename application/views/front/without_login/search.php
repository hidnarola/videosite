<div class="white-box">
    <h3 class="h3-title">Search result for "<?php echo $this->input->get('q'); ?>"</h3>

<div class="home-listing">
    <ul class="ul-list">
        <?php 
            if (!empty($posts)){ foreach ($posts as $post) {
        ?>
            <li>
                <div class="list-box">
                    <div class="list-top">
                        <?php if($post['post_type'] == 'blog'){?>
                            <a class="img-anchor" href="<?php echo base_url() . 'blog/' . $post['post_slug']; ?>"><img src="<?php echo base_url() . $post['main_image'] ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
                            <a href="" class="tag-a">A</a>
                        <?php } else if($post['post_type'] == 'gallery'){?>
                            <a class="img-anchor" href="<?php echo base_url() . 'gallery/' . $post['post_slug']; ?>"><img src="<?php echo base_url() . $post['main_image'] ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
                            <a href="" class="tag-g">G</a>
                        <?php } else if($post['post_type'] == 'video'){?>
                            <a class="img-anchor" href="<?php echo base_url() . 'video/' . $post['post_slug']; ?>"><img src="<?php echo base_url() . $post['main_image'] ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
                            <a href="" class="tag-v">V</a>
                        <?php } ?>
                    </div>
                    <div class="list-btm">
                        <?php if($post['post_type'] == 'blog') { ?>
                            <a href="<?php echo base_url() . 'blog/' . $post['post_slug']; ?>"><?php echo $post['post_title'] ?></a>
                        <?php } else if($post['post_type'] == 'gallery') { ?>
                            <a href="<?php echo base_url() . 'gallery/' . $post['post_slug']; ?>"><?php echo $post['post_title'] ?></a>
                        <?php } else if($post['post_type'] == 'video'){?>
                            <a href="<?php echo base_url() . 'video/' . $post['post_slug']; ?>"><?php echo $post['post_title'] ?></a>
                        <?php } ?>
                        <p>By : <?php echo $post['username'] ?> <span></span></p>
                        <h6><i class="fa fa-eye"></i> <?php echo $post['total_views'] ?></h6>
                    </div>
                </div>
            </li>
        <?php } } else if(empty($posts))
         {
             echo"<div class='alert alert-success'>No Posts Found.</div>";
         } ?>
    </ul>
    <div id="pagination">
        <?php
            foreach ($links as $link) {
                echo $link;
            }
        ?>
    </div>
</div>
</div>
