<div class="form-element">    
    <h3 class="h3-title">Add Video</h3>
    <?php 
        $all_erros = validation_errors(); 
        if(!empty($all_erros)){
    ?>
        <div class="alert alert-danger"><?php echo $all_erros; ?></div>
    <?php } ?>
    <?php
        
        $data['channel_name'] = $this->db->get_where('user_channels',['id' => $channel_id])->row_array();
    ?>
        <?php if(!empty($channel_id)) {?>
    <a href="<?php echo base_url().'user_post/add_post/blog?channel_id='.$data['channel_name']['id']; ?>" class="btn-black">
        <i class="fa fa-rss"></i>
        Add Article
    </a>
    <a href="<?php echo base_url().'user_post/add_post/gallery?channel_id='.$data['channel_name']['id'];; ?>" class="btn-red">
        <i class="fa fa-camera"></i>
        Add Gallery
    </a>
    <?php } else { ?>
    <a href="<?php echo base_url().'user_post/add_post/blog'; ?>" class="btn-black">
        <i class="fa fa-rss"></i>
        Add Article
    </a>
    <a href="<?php echo base_url().'user_post/add_post/gallery';?>" class="btn-red">
        <i class="fa fa-camera"></i>
        Add Gallery
    </a>    
   <?php  } ?>

   <a href="<?php echo base_url().'user_post/add_video_post';?>" class="btn-red">
        <i class="fa fa-camera"></i>
        Add Video Post
    </a>    
    
    <br>
    <br>
    <br>
    
    <form method="post" action="" id="frmblog" enctype="multipart/form-data">
        <?php 
        if(!empty($channel_id))
        {    
            
            ?>
        <div class="input-wrap">
            <label class="label-css">Channel Name </label>
            <input disabled="" type="text" name="channel_name" id="channel_name" placeholder="Channel Name" value="<?php echo $data['channel_name']['channel_name']; ?>" class="form-css" />
        </div>
        <?php
        }        
        else
        {
          ?>
        <div class="input-wrap">
            <label class="label-css">Select Channel </label>
            <select class="form-css selectpicker_blog" data-placeholder="Select a Channel"  name="channel" id="channel" >                
                <option value="">Select Channel</option>
                <?php
                    if(!empty($all_channels)) {
                        foreach ($all_channels as $key => $channel) {
                ?>
                    <option value="<?php echo $channel['id']; ?>" <?php echo set_select('channel', $channel['id'], false); ?>>
                        <?php echo $channel['channel_name']; ?>
                    </option>
                <?php } } ?> 
            </select>
        </div>
        <?php
        }
        ?>
        

        <div class="input-wrap">
            <label class="label-css">Select Category </label>
            <select class="form-css category selectpicker_blog" data-placeholder="Select a Category"  name="category" id="category" >
                <option value="">Select Category</option> 
                <?php
                    if($all_category) {
                        foreach ($all_category as $key => $category) {
                ?> 
                    <option value="<?php echo $category['id']; ?>" <?php echo set_select('category', $category['id'], false); ?> >
                        <?php echo $category['category_name']; ?>
                    </option>
                <?php } } ?> 
            </select>
        </div>

        <div class="input-wrap">
            <label class="label-css">Select Sub Category </label>
            <select class="form-css sub_category selectpicker_blog" data-placeholder="Select a Sub Category"  name="sub_category" id="sub_category">
                <option value="">Select Sub Category</option> 
                <?php
                    if(!empty($all_sub_cat)) {
                        foreach ($all_sub_cat as $key => $cat) {
                ?> 
                    <option value="<?php echo $cat['id']; ?>" <?php echo set_select('sub_category', $cat['id'], false); ?> >
                        <?php echo $cat['category_name']; ?>
                    </option>
                <?php } } ?> 
            </select>
        </div>
        
        <div class="input-wrap">
            <label class="label-css">Video Title </label>
            <input type="text" name="video_title" id ="video_title" placeholder="Video Title" value="<?php echo set_value('video_title'); ?>" class="form-css" />
        </div>        
        
        <div class="input-wrap full-width">
            <label class="label-css">Embed Video URL </label>
            <input type="text" name="embed_video" id ="embed_video" placeholder="Video Url" value="<?php echo set_value('embed_video'); ?>" class="form-css" />
        </div>

        <div class="input-wrap full-width">
            <label class="label-css">Description</label>
            <textarea class="textarea-css" name="video_desc"><?php echo set_value('video_desc'); ?></textarea>
        </div>

        <div class="btn-btm">
            <button class="common-btn btn-submit" type="submit">Submit</button>
        </div>
    </form>
    <!-- /login form -->
</div>
<!-- /LOGIN -->



<script>
    
    $(document).ready(function () {                
        $('.selectpicker_blog').selectpicker();
    });

    $('.category').change(function () {
        var selCategory = $(this).val();        
        $.ajax({
            url: "<?php echo base_url().'user_post/ajax_call'; ?>",
            async: false,
            type: "POST",
            data: "category=" + selCategory,
            dataType: "json",
            success: function (data) {                
                $('.sub_category.selectpicker_blog').html(data['all_sub_str']);
                $(".selectpicker_blog").selectpicker("refresh");
            }
        })
    });

</script>
<!-- / -->