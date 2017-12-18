<div class="white-box">
    <h3 class="h3-title">Search result for</h3>
</div>
    <div class="home-listing">
        <ul>
            <li>
                <div class="list-box">
                    <div class="list-top">
                        <a href="">
                            <img src="<?php echo base_url() . $post['bimg'] ?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/>
                        </a>
                    </div>
                    <div class="list-btm">
                        <a href="<?php echo base_url() . 'blog/' . $post['slug']; ?>">
                            <?php echo $post['blog_title'] ?>                                
                        </a>
                        <p><?php echo $post['username'] ?> <span></span></p>
                        <h6><i class="fa fa-eye"></i> 1,25,000 Views</h6>
                        <h6><i class="fa fa-clock-o"></i> 5 Months aago</h6>
                    </div>
                </div>
            </li>
        </ul>
    </div>