<div class="white-box">
    <h3 class="h3-title"> Bookmarks</h3>
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
        <?php if (!empty($book)) { foreach ($book as $books) {?>
            <li>
                <div class="list-box">
                    <div class="list-top">
                    <?php if($books['post_type'] == 'blog'){?>
                        <a class="img-anchor" href="<?php echo base_url() . 'blog/' . $books['slug']; ?>"><img src="<?php echo base_url() . $books['main_image'] ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
                        <a href="" class="tag-a">A</a>
                        <?php } else if($books['post_type'] == 'gallery'){?>
                        <a class="img-anchor" href="<?php echo base_url() . 'gallery/' . $books['slug']; ?>"><img src="<?php echo base_url() . $books['main_image'] ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
                        <a href="" class="tag-g">G</a>
                        <?php } else if($books['post_type'] == 'video'){?>
                        <a class="img-anchor" href="<?php echo base_url() . 'video/' . $books['slug']; ?>"><img src="<?php echo base_url() . $books['main_image'] ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
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
                        <p> <small> By : <?php echo $books['username'] ?> </small> <span></span></p>
                        <h6><i class="fa fa-eye"></i> <?php echo $books['total_views'] ?> </h6>
                    <!--<h6><i class="fa fa-clock-o"></i><?php get_ago_time($books['blog_created_date'], date("Y-m-d H:i:s")) ?></h6>-->
                    </div>
                </div>
            </li>
        <?php } } else if(empty($book))
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
