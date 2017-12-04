<div class="home-listing">
    <h2>User Posts</h2>
    <ul class="ul-list">
    <?php 
        if (!empty($posts)){ foreach ($posts as $post) {            
    ?>
        <li>
            <div class="list-box">
                <div class="list-top"><a href=""><img src="<?php echo base_url() . $post['main_image'] ?>" alt=""/></a>
                <?php if($post['post_type'] == 'blog'){?>
                    <a href="" class="tag-a">A</a>
                    <?php } else if($post['post_type'] == 'gallery'){?>
                    <a href="" class="tag-g">G</a>
                    <?php } else if($post['post_type'] == 'video'){?>
                    <a href="" class="tag-v">V</a>
                    <?php } ?>
                </div>
                <div class="list-btm">
                   <?php if($post['post_type'] == 'blog') { ?>
                    <a href="<?php echo base_url() . 'blog/' . $post['slug']; ?>"><?php echo $post['post_title'] ?></a>
                   <?php } else if($post['post_type'] == 'gallery') { ?>
                    <a href="<?php echo base_url() . 'gallery/' . $post['slug']; ?>"><?php echo $post['post_title'] ?></a>
                   <?php } else if($post['post_type'] == 'video'){?>
                    <a href="<?php echo base_url() . 'video/' . $post['slug']; ?>"><?php echo $post['post_title'] ?></a>
                   <?php }?>
                    <div class="edit-dlt">
                        <p>By : <?php echo $session_info['username'] ?> <span></span></p>
                        <?php if($post['post_type'] == 'video') { ?>
                            <a href="<?php echo base_url().'user_post/edit_video_post/'.$post['id']; ?>" class="fa fa-edit"></a>
                        <?php } else { ?>
                            <a href="<?php echo base_url().'user_post/edit_post/'.$post['id']; ?>" class="fa fa-edit"></a>
                        <?php } ?>
                        <a onclick="delete_confirm(this)" data-id="<?php echo $post['id']; ?>" class="cursor_pointer fa fa-trash"></a>
                    </div>
                    <h6><i class="fa fa-eye"></i> <?php echo $post['total_views'] ?> Views</h6>
                    <!--<h6><i class="fa fa-clock-o"></i><?php get_ago_time($post['blog_created_date'], date("Y-m-d H:i:s")) ?></h6>-->
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

<script type="text/javascript">
    function delete_confirm(obj){
        var post_id = $(obj).data('id');
        
        bootbox.confirm("Are you sure ?", 
            function(result){ 
                if(result){
                    window.location.href="<?php echo base_url().'user_post/delete_user_post/'; ?>"+post_id;
                }
            }
        );
    }
</script>




