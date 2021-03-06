<div class="white-box">
    <h3 class="h3-title"> Posts</h3>
    <div class="user-srh">
        <form>
            <input type="text" name="q" value="<?php echo $this->input->get('q'); ?>" placeholder="Search">
            <button type="submit">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"> <g> <g> <path d="M386.348,336.165c23.574-34.148,37.408-75.546,37.408-120.19c0-117.015-94.843-211.878-211.878-211.878 S0,98.959,0,215.974s94.843,211.878,211.878,211.878c48.849,0,93.8-16.572,129.637-44.338l124.388,124.388L512,461.812 L386.348,336.165z M211.878,382.217c-91.667,0-166.243-74.574-166.243-166.243c0-91.667,74.574-166.243,166.243-166.243 s166.243,74.574,166.243,166.243S303.545,382.217,211.878,382.217z"></path> </g> </g> <g> <g> <path d="M191.738,85.575c-52.877,15.19-94.418,56.731-109.615,109.609l31.338,8.99c12.035-42.005,45.264-75.239,87.267-87.274 L191.738,85.575z"></path> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
            </button>
        </form>
    </div>
    <div class="home-listing">
        <ul class="ul-list">
        <?php 
            if (!empty($posts)){ foreach ($posts as $post) {
                                
                $user_name = $session_info['username'];
                if($post['upload_user_id'] != 0){
                    $u_data = $this->db->select('username')->get_where('users',['id'=>$post['upload_user_id']])->row_array();
                    $user_name = $u_data['username'];
                }
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
                        <?php if($post['post_type'] == 'blog') { ?>
                            <a href="<?php echo base_url() . 'blog/' . $post['slug']; ?>"><?php echo character_limiter($post['post_title'],20); ?></a>
                        <?php } else if($post['post_type'] == 'gallery') { ?>
                            <a href="<?php echo base_url() . 'gallery/' . $post['slug']; ?>"><?php echo character_limiter($post['post_title'],20); ?></a>
                        <?php } else if($post['post_type'] == 'video'){?>
                            <a href="<?php echo base_url() . 'video/' . $post['slug']; ?>"><?php echo character_limiter($post['post_title'],20); ?></a>
                        <?php }?>
                        <div class="edit-dlt">
                            <p> <small><?php echo $user_name; ?> </small><span></span></p>
                            <?php 
                                if($post['post_type'] == 'video') { 
                                    $vid_data = $this->db->get_where('video',['post_id'=>$post['id']])->row_array();
                                    $v_link = 'edit_video_post';
                                    if(!empty($vid_data['embed_link'])){
                                        $v_link = 'edit_embed_video';
                                    }
                            ?>
                                <a href="<?php echo base_url().'user_post/'.$v_link.'/'.$post['id']; ?>" class="fa fa-edit"></a>
                            <?php } else { ?>
                                <a href="<?php echo base_url().'user_post/edit_post/'.$post['id']; ?>" class="fa fa-edit"></a>
                            <?php } ?>
                            <a onclick="delete_confirm(this)" data-id="<?php echo $post['id']; ?>" class="cursor_pointer fa fa-trash"></a>
                        </div>
                        <h6><i class="fa fa-eye"></i> <?php echo $post['total_views'] ?></h6>
                        <?php if($post['upload_user_id'] != 0){
                                if($post['is_approved'] == 0){
                            ?>
                        <h6 class="approve"><a class="cursor_pointer" onclick="approve_confirm(this)" data-id="<?php echo $post['id']; ?>"><i class="fa fa-thumbs-o-up"></i>Approve</a></h6>
                        <h6 class="disapprove"><a class="cursor_pointer" onclick="disapprove_confirm(this)" data-id="<?php echo $post['id']; ?>"><i class="fa fa-thumbs-o-down"></i>Disapprove</a></h6>
                        <?php } 
                        else { ?>
                            <h6 class="active"><i class="fa fa-thumbs-o-up"></i> Approved</h6>
                        <?php }
                                }?>
                        <!--<h6><i class="fa fa-clock-o"></i><?php get_ago_time($post['blog_created_date'], date("Y-m-d H:i:s")) ?></h6>-->
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
            foreach ($links as $link)
            {
                echo $link;
            }
            ?>
        </div>
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
    
    function approve_confirm(obj){
        var post_id = $(obj).data('id');
        
        bootbox.confirm("Are you sure to approve this post ?", 
            function(result){ 
                if(result){
                    window.location.href="<?php echo base_url().'user_post/approve_post/'; ?>"+post_id;
                }
            }
        );
    }
    
    function disapprove_confirm(obj){
        var post_id = $(obj).data('id');
        
        bootbox.confirm("Are you sure to disapprove this post ?", 
            function(result){ 
                if(result){
                    window.location.href="<?php echo base_url().'user_post/disapprove_post/'; ?>"+post_id;
                }
            }
        );
    }
</script>




