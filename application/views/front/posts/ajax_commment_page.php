<?php 
    if(isset($comments)){ 
        foreach ($comments as $key =>$comm){
?>
    <li>
        <div class="list-ul-box">    
        <span><a class="cursor_pointer" href="">
                <img src="<?php echo base_url().$comm['avatar'];?>" alt="" onerror="this.src='<?php echo base_url().'uploads/avatars/user-icon-image-download.jpg'; ?>'"></a></span>
        <h4><?php echo $comm['username']; ?></h4>                                
        <p><?php echo $comm['message']; ?></p>
        </div>
    </li>
<?php } } ?>