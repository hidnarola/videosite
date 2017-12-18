<div class="carousel-type">
  <ul>
      <li>
      <?php if(!empty($most_recent_video)) { foreach($most_recent_video as $key => $recent_video){?>
          <div class="video-type">
              <a href="" class="tag">V</a>
              <a href="<?php echo base_url() . 'video/' . $recent_video['slug']; ?>" class="img"><img src="<?php echo $recent_video['main_image']?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
              <h4><a href="<?php echo base_url() . 'video/' . $recent_video['slug']; ?>"><?php echo $recent_video['post_title']?></a></h4>
          </div>
      <?php } } ?>
      </li>
      <li>
      <?php if(!empty($most_recent_blog)) { foreach($most_recent_blog as $key => $recent_blog){?>
          <div class="artical-type">
              <a href="" class="tag">A</a>
              <a href="<?php echo base_url() . 'blog/' . $recent_blog['slug']; ?>" class="img"><img src="<?php echo $recent_blog['main_image']?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
              <h4><a href="<?php echo base_url() . 'blog/' . $recent_blog['slug']; ?>"><?php echo $recent_blog['post_title']?></a></h4>
          </div>
      <?php } } ?>
      </li>
      <li>
      <?php if(!empty($most_recent_gallery)) { foreach($most_recent_gallery as $key => $recent_gallery){?>
          <div class="gallery-type">
              <a href="" class="tag">G</a>
              <a href="<?php echo base_url() . 'gallery/' . $recent_gallery['slug']; ?>"><img src="<?php echo $recent_gallery['main_image']?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>
              <h4><a href="<?php echo base_url() . 'gallery/' . $recent_gallery['slug']; ?>"><?php echo $recent_gallery['post_title']?></a></h4>
          </div>
      <?php  } } ?>
      </li>
  </ul>
</div>

<div class="home-listing">
  <h2>Recommended</h2>
  <div class="owl-carousel owl-theme">
              <?php foreach($recommended as $key => $recommend){?>
      <div class="item">
          <div class="list-box">
              <div class="list-top"> 
                  <?php if($recommend['post_type'] == 'blog'){?>
                  <a  class="img-anchor" href="<?php echo base_url() . 'blog/' . $recommend['slug']; ?>"><img src="<?php echo $recommend['main_image']?>" alt="" /></a>  
                  <a href="" class="tag-a">A</a>
                    <?php } else if($recommend['post_type'] == 'gallery'){?>
                  <a class="img-anchor" href="<?php echo base_url() . 'gallery/' . $recommend['slug']; ?>"><img src="<?php echo $recommend['main_image']?>" alt="" /></a>  
                  <a href="" class="tag-g">G</a>
                    <?php } else if($recommend['post_type'] == 'video'){?>
                  <a class="img-anchor" href="<?php echo base_url() . 'video/' . $recommend['slug']; ?>"><img src="<?php echo $recommend['main_image']?>" alt="" /></a>  
                  <a href="" class="tag-v">V</a>
                    <?php } ?>
                  <!--<span>10:53</span>-->
              </div>
              <div class="list-btm">
                 <?php if($recommend['post_type'] == 'blog') {?>
                    <a href="<?php echo base_url() . 'blog/' . $recommend['slug']; ?>"><?php echo $recommend['post_title'] ?></a>
                    <?php } else if($recommend['post_type'] == 'gallery') {?>
                    <a href="<?php echo base_url() . 'gallery/' . $recommend['slug']; ?>"><?php echo $recommend['post_title'] ?></a>
                    <?php } else if($recommend['post_type'] == 'video') {?>
                    <a href="<?php echo base_url() . 'video/' . $recommend['slug']; ?>"><?php echo $recommend['post_title'] ?></a>
                    <?php } ?>
                  <p><?php echo $recommend['username']?> <span></span></p>
                  <h6><i class="fa fa-eye"></i> <?php echo $recommend['total_views']?></h6>
                  <!--<h6><i class="fa fa-clock-o"></i> 5 Mon ago</h6>-->
              </div>
          </div>
      </div>  
              <?php } ?>

  </div>

</div>
<div class="ad-01"><a href="">
        <img src="public/front/images/ad-01.png" alt="" />
        <!--<div id="myDiv">This text will be replaced with a player.</div>-->
    </a></div>
<!--<script src="https://content.jwplatform.com/libraries/sJ4UhosD.js"></script>
<script>
jwplayer("myDiv").setup({
    "file": "uploads/videos/mov_bbb.mp4",
    "image": "uploads/videos/0aRUoyOKVxL93teQwidG.jpg",
    "height": 360,
    "width": 640
});
</script> -->

<div class="home-listing">
  <h2>Most Popular Posts</h2>
  <div class="owl-carousel owl-theme">
              <?php foreach($most_popular as $key => $popular){?>
      <div class="item">
          <div class="list-box">
              <div class="list-top"> 
                  <?php if($popular['post_type'] == 'blog'){?>
                  <a class="img-anchor" href="<?php echo base_url() . 'blog/' . $popular['slug']; ?>"><img src="<?php echo $popular['main_image']?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>  
                  <a href="" class="tag-a">A</a>
                    <?php } else if($popular['post_type'] == 'gallery'){?>
                  <a class="img-anchor" href="<?php echo base_url() . 'gallery/' . $popular['slug']; ?>"><img src="<?php echo $popular['main_image']?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>         
                  <a href="" class="tag-g">G</a>
                    <?php } else if($popular['post_type'] == 'video'){?>
                  <a class="img-anchor" href="<?php echo base_url() . 'video/' . $popular['slug']; ?>"><img src="<?php echo $popular['main_image']?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>  
                  <a href="" class="tag-v">V</a>
                    <?php } ?>
                  <!--<span>10:53</span>-->
              </div>
              <div class="list-btm">
                 <?php if($popular['post_type'] == 'blog') {?>
                    <a href="<?php echo base_url() . 'blog/' . $popular['slug']; ?>"><?php echo $popular['post_title'] ?></a>
                    <?php } else if($popular['post_type'] == 'gallery') {?>
                    <a href="<?php echo base_url() . 'gallery/' . $popular['slug']; ?>"><?php echo $popular['post_title'] ?></a>
                    <?php } else if($popular['post_type'] == 'video') {?>
                    <a href="<?php echo base_url() . 'video/' . $popular['slug']; ?>"><?php echo $popular['post_title'] ?></a>
                    <?php } ?>
                  <p><?php echo $popular['username']?> <span></span></p>
                  <h6><i class="fa fa-eye"></i> <?php echo $popular['total_views']?></h6>
                  <!--<h6><i class="fa fa-clock-o"></i> 5 Mon ago</h6>-->
              </div>
          </div>
      </div>  
              <?php } ?>

  </div>
</div>


<div class="home-listing">
  <h2>Most Recent Posts</h2>
  <div class="owl-carousel owl-theme">
              <?php foreach($most_recent as $key => $recent){?>
      <div class="item">
          <div class="list-box">
              <div class="list-top"> 
                  <?php if($recent['post_type'] == 'blog'){?>
                  <a class="img-anchor" href="<?php echo base_url() . 'blog/' . $recent['slug']; ?>"><img src="<?php echo $recent['main_image']?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>  
                  <a href="" class="tag-a">A</a>
                    <?php } else if($recent['post_type'] == 'gallery'){?>
                  <a class="img-anchor" href="<?php echo base_url() . 'gallery/' . $recent['slug']; ?>"><img src="<?php echo $recent['main_image']?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>         
                  <a href="" class="tag-g">G</a>
                    <?php } else if($recent['post_type'] == 'video'){?>
                  <a class="img-anchor" href="<?php echo base_url() . 'video/' . $recent['slug']; ?>"><img src="<?php echo $recent['main_image']?>" alt="" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'"/></a>  
                  <a href="" class="tag-v">V</a>
                    <?php } ?>
                  <!--<span>10:53</span>-->
              </div>
              <div class="list-btm">
                 <?php if($recent['post_type'] == 'blog') {?>
                    <a href="<?php echo base_url() . 'blog/' . $recent['slug']; ?>"><?php echo $recent['post_title'] ?></a>
                    <?php } else if($recent['post_type'] == 'gallery') {?>
                    <a href="<?php echo base_url() . 'gallery/' . $recent['slug']; ?>"><?php echo $recent['post_title'] ?></a>
                    <?php } else if($recent['post_type'] == 'video') {?>
                    <a href="<?php echo base_url() . 'video/' . $recent['slug']; ?>"><?php echo $recent['post_title'] ?></a>
                    <?php } ?>
                  <p><?php echo $recent['username']?> <span></span></p>
                  <h6><i class="fa fa-eye"></i> <?php echo $recent['total_views']?></h6>
                  <!--<h6><i class="fa fa-clock-o"></i> 5 Mon ago</h6>-->
              </div>
          </div>
      </div>  
              <?php } ?>

  </div>
</div>

    