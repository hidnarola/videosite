<div class="carousel-type">
  <ul>
      <?php if(!empty($most_recent)) { foreach($most_recent as $key => $recent){?>
      <li>
          <?php 
          if($recent['post_type'] == 'video')
          {
            $class = 'video-type';
            $tag = 'V';
            $img = $recent['main_image'];
            $slug =  base_url() . 'video/' . $recent['slug']; 
            $title = $recent['post_title'];
          }
          else if($recent['post_type'] == 'blog')
          {
            $class = 'artical-type';
            $tag = 'A';
            $img = $recent['main_image'];
            $slug =  base_url() . 'blog/' . $recent['slug']; 
            $title = $recent['post_title'];
          }
          else if($recent['post_type'] == 'gallery')
          {
            $class = 'gallery-type';  
            $tag = 'G';
            $img = $recent['main_image'];
            $slug =  base_url() . 'gallery/' . $recent['slug']; 
            $title = $recent['post_title'];
          }
          ?>
          <div class="<?php echo $class;?>">
              <a href="" class="tag"><?php echo $tag;?></a>
              <a href="" class="img"><img src="<?php echo $img?>" alt="" /></a>
              <h4><a href="<?php echo $slug?>"><?php $title?></a></h4>
          </div>
      </li>
      <?php } } ?>
      <li>
          <div class="artical-type">
              <a href="" class="tag">A</a>
              <a href="" class="img"><img src="public/front/images/artical-img.jpg" alt="" /></a>
              <h4><a href="">electronic typesettin remai essentially unchanged.</a></h4>
          </div>
      </li>
      <li>
          <div class="gallery-type">
              <a href="" class="tag">G</a>
              <a href=""><img src="public/front/images/gallery-01.jpg" alt="" /></a>
          </div>
      </li>
  </ul>
</div>

<div class="home-listing">
  <h2>Most Liked Posts</h2>
  <div class="owl-carousel owl-theme">
              <?php foreach($most_likes as $key => $like){?>
      <div class="item">
          <div class="list-box">
              <div class="list-top"><a href=""><img src="<?php echo $like['main_image']?>" alt="" /></a> 
                  <?php if($like['post_type'] == 'blog'){?>
                    <a href="" class="tag-a">A</a>
                    <?php } else if($like['post_type'] == 'gallery'){?>
                    <a href="" class="tag-g">G</a>
                    <?php } else if($like['post_type'] == 'video'){?>
                    <a href="" class="tag-v">V</a>
                    <?php } ?>
                  <!--<span>10:53</span>-->
              </div>
              <div class="list-btm">
                 <?php if($like['post_type'] == 'blog') {?>
                    <a href="<?php echo base_url() . 'blog/' . $like['slug']; ?>"><?php echo $like['post_title'] ?></a>
                    <?php } else if($like['post_type'] == 'gallery') {?>
                    <a href="<?php echo base_url() . 'gallery/' . $like['slug']; ?>"><?php echo $like['post_title'] ?></a>
                    <?php } else if($like['post_type'] == 'video') {?>
                    <a href="<?php echo base_url() . 'video/' . $like['slug']; ?>"><?php echo $like['post_title'] ?></a>
                    <?php } ?>
                  <p>By : <?php echo $like['username']?> <span></span></p>
                  <h6><i class="fa fa-eye"></i><?php echo $like['total_views']?>  Views</h6>
                  <!--<h6><i class="fa fa-clock-o"></i> 5 Mon ago</h6>-->
              </div>
          </div>
      </div>  
              <?php } ?>

  </div>

</div>
<div class="ad-01"><a href=""><img src="public/front/images/ad-01.png" alt="" /></a></div>

<div class="home-listing">
  <h2>Most Viewd Posts</h2>
  <div class="owl-carousel owl-theme">
              <?php foreach($most_views as $key => $view){?>
      <div class="item">
          <div class="list-box">
              <div class="list-top"><a href=""><img src="<?php echo $view['main_image']?>" alt="" /></a> 
                  <?php if($view['post_type'] == 'blog'){?>
                    <a href="" class="tag-a">A</a>
                    <?php } else if($view['post_type'] == 'gallery'){?>
                    <a href="" class="tag-g">G</a>
                    <?php } else if($view['post_type'] == 'video'){?>
                    <a href="" class="tag-v">V</a>
                    <?php } ?>
                  <!--<span>10:53</span>-->
              </div>
              <div class="list-btm">
                 <?php if($view['post_type'] == 'blog') {?>
                    <a href="<?php echo base_url() . 'blog/' . $view['slug']; ?>"><?php echo $view['post_title'] ?></a>
                    <?php } else if($view['post_type'] == 'gallery') {?>
                    <a href="<?php echo base_url() . 'gallery/' . $view['slug']; ?>"><?php echo $view['post_title'] ?></a>
                    <?php } else if($view['post_type'] == 'video') {?>
                    <a href="<?php echo base_url() . 'video/' . $view['slug']; ?>"><?php echo $view['post_title'] ?></a>
                    <?php } ?>
                  <p>By : <?php echo $view['username']?> <span></span></p>
                  <h6><i class="fa fa-eye"></i><?php echo $view['total_views']?>  Views</h6>
                  <!--<h6><i class="fa fa-clock-o"></i> 5 Mon ago</h6>-->
              </div>
          </div>
      </div>  
              <?php } ?>

  </div>
</div>

    