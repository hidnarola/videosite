<?php 
    if(!empty($posts)){
        foreach ($posts as $key => $post){    
?>
            <li>
                <div class="list-box">
                    <div class="list-top">
                        <?php if($post['post_type'] == 'blog'){?>
                        <a class="img-anchor" href="<?php echo base_url() . 'blog/' . $post['slug']; ?>"><img src="<?php echo base_url() . $post['main_image'] ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
                        <a href="" class="tag-a">A</a>
                        <?php } else if($post['post_type'] == 'gallery'){?>
                         <a class="img-anchor" href="<?php echo base_url() . 'gallery/' . $post['slug']; ?>"><img src="<?php echo base_url() . $post['main_image'] ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
                        <a href="" class="tag-g">G</a>
                        <?php } else if($post['post_type'] == 'video'){?>
                         <a class="img-anchor" href="<?php echo base_url() . 'video/' . $post['slug']; ?>"><img src="<?php echo base_url() . $post['main_image'] ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
                        <a href="" class="tag-v">V</a>
                        <?php } ?>
                    </div>
                        
                    <div class="list-btm">
                        <?php if ($post['post_type'] == 'blog'){?>
                        <a href="<?php echo base_url() . 'blog/' . $post['slug']; ?>"><?php echo character_limiter($post['post_title'],20); ?></a> 
                            <?php } else if($post['post_type'] == 'gallery'){ ?>
                        <a href="<?php echo base_url() . 'gallery/' . $post['slug']; ?>"><?php echo character_limiter($post['post_title'],20); ?></a>
                            <?php } else if($post['post_type'] == 'video'){  ?>
                        <a href="<?php echo base_url() . 'video/' . $post['slug']; ?>"><?php echo character_limiter($post['post_title'],20); ?></a>
                            <?php }?>
                         <p> <small><?php echo $post['username'] ?> </small><span></span></p>
                         <h6><i class="fa fa-eye"></i> <?php echo $post['total_views'] ?></h6>
                         <!--<h6><i class="fa fa-clock-o"></i><?php get_ago_time($post['blog_created_date'], date("Y-m-d H:i:s")) ?></h6>-->
                    </div>
                </div>
            </li>
<?php } }  ?>