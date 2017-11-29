<div class="right-panel">      
        <h1>
            <?php echo $res_channel['channel_name']; ?>                
        </h1>
        <p>Total Subscriber - <span class="btn btn-primary"><?php echo (int)$total_subscriber; ?></span> 
        </p>
            
        <?php if($user_loggedin == true && $is_this_users_channel == false) { ?>
            <?php if($is_user_subscribe == false) { ?>
                <a href="<?php echo base_url().'user_channels/subscribe_channel/'.$res_channel['id']; ?>" class="btn btn-success">
                    Subscribe
                </a>
            <?php } else { ?>
                <a href="<?php echo base_url().'user_channels/unsubscribe_channel/'.$res_channel['id']; ?>" class="btn btn-danger">
                    Un-Subscribe
                </a>
            <?php } ?>
        <?php } ?>
    
  
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <h3>Comments</h3>
                
            </div>     
        </div>
    </div>
        
        
        <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <h3><?php pr($posts);?></h3>
                
            </div>     
        </div>
    </div>

</div>