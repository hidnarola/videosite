<div class="home-listing" id="content-1">
    <h2>Suggested</h2>
    <ul class="ul-list" id="new_ids">
        <?php foreach ($posts as $key => $post){?>
        <li>
            <div class="list-box">
                <div class="list-top">
                    <?php if($post['post_type'] == 'blog'){?>
                    <a class="img-anchor" href="<?php echo base_url() . 'blog/' . $post['slug']; ?>"><img src="<?php echo base_url() . $post['main_image'] ?>" alt=""/></a>
                    <a href="" class="tag-a">A</a>
                    <?php } else if($post['post_type'] == 'gallery'){?>
                     <a class="img-anchor" href="<?php echo base_url() . 'gallery/' . $post['slug']; ?>"><img src="<?php echo base_url() . $post['main_image'] ?>" alt=""/></a>
                    <a href="" class="tag-g">G</a>
                    <?php } else if($post['post_type'] == 'video'){?>
                     <a class="img-anchor" href="<?php echo base_url() . 'video/' . $post['slug']; ?>"><img src="<?php echo base_url() . $post['main_image'] ?>" alt=""/></a>
                    <a href="" class="tag-v">V</a>
                    <?php } ?>
                </div>
                    
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
    
    <input type="hidden" name="offset_listing" value="12" id="offset_listing">
    <input type="hidden" name="total_records" value="<?php echo $total_count_listing; ?>" id="total_records">
    
    <input type="hidden" name="cat_id" id="cat_id" value="<?php echo $cat_id; ?>">
    <input type="hidden" name="sub_id" id="sub_id" value="<?php echo $sub_id; ?>">

</div>

<script type="text/javascript">
    var is_many_posts = true;
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            
            var offset_listing = $('#offset_listing').val();
            var total_records = $('#total_records').val();
            var cat_id = $('#cat_id').val();
            var sub_id = $('#sub_id').val();

            if(offset_listing < total_records){

                $.ajax({
                    url:"<?php echo base_url().'home/ajax_category_listing_fetch'; ?>",
                    method:"POST",
                    data:{offset_listing:offset_listing,cat_id:cat_id,sub_id:sub_id},
                    dataType:"JSON",
                    success:function(data){
                        
                        $('body').loading({theme:'dark'});

                        setTimeout(function() {
                            $('#new_ids').append(data['html_str']);
                            $('#offset_listing').val(data['offset_listing']);
                            $('body').loading('stop');
                        },2000);
                        
                    }
                });
            }
        }
    });
</script>