
    <div class="home-listing">
        <h2>Search result for </h2>
        <ul>
            <li>
                <div class="list-box">
                    <div class="list-top">
                        <a href="">
                            <img src="<?php echo base_url() . $post['bimg'] ?>" alt=""/>
                        </a>
                    </div>
                    <div class="list-btm">
                        <a href="<?php echo base_url() . 'blog/' . $post['slug']; ?>">
                            <?php echo $post['blog_title'] ?>                                
                        </a>
                        <p>By : <?php echo $post['username'] ?> <span></span></p>
                        <h6><i class="fa fa-eye"></i> 1,25,000 Views</h6>
                        <h6><i class="fa fa-clock-o"></i> 5 Months aago</h6>
                    </div>
                </div>
            </li>
        </ul>
    </div>
