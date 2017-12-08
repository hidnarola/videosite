<div class="form-element">    
    <?php 
        $all_erros = validation_errors(); 
        if(!empty($all_erros)){
    ?>
        <div class="alert alert-danger"><?php echo $all_erros; ?></div>
    <?php } ?>

    <h3 class="h3-title">Edit Video</h3>
    <form method="post" action="" id="frmblog" enctype="multipart/form-data">
        <div class="input-wrap">
            <label class="label-css">Select Channel </label>
            <select class="form-css selectpicker_blog" data-placeholder="Select a Channel"  name="channel" id="channel" >                
                <option value="">Select Channel</option>
                <?php
                    if(!empty($all_channels)) {
                        foreach ($all_channels as $key => $channel) {                            
                            $def_val = false;                            
                            if(empty($_POST)){
                                if($channel['id'] == $post_data['channel_id']){
                                    $def_val = true;
                                }
                            }
                ?>
                    <option value="<?php echo $channel['id']; ?>"<?php echo set_select('channel', $channel['id'], $def_val); ?> >
                        <?php echo $channel['channel_name']; ?>
                    </option>
                <?php } } ?> 
            </select>
        </div>

        <div class="input-wrap">
            <label class="label-css">Select Category </label>
            <select class="form-css category selectpicker_blog" data-placeholder="Select a Category"  name="category" id="category" >
                <option value="">Select Category</option> 
                <?php
                    if($all_category) {
                        foreach ($all_category as $key => $category) {
                            $def_val = false;                            
                            if(empty($_POST)){
                                if($category['id'] == $post_data['category_id']){
                                    $def_val = true;
                                }
                            }
                ?> 
                    <option value="<?php echo $category['id']; ?>" <?php echo set_select('category', $category['id'], $def_val); ?> >
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
                            $def_val = false;
                            if(empty($_POST)){
                                if($cat['id'] == $post_data['sub_category_id']){
                                    $def_val = true;
                                }
                            }                        
                ?> 
                    <option value="<?php echo $cat['id']; ?>" <?php echo set_select('sub_category', $cat['id'], $def_val); ?> >
                        <?php echo $cat['category_name']; ?>
                    </option>
                <?php } } ?> 
            </select>
        </div>
        
        <div class="input-wrap">
            <label class="label-css">Video Title </label>
            <?php if($_POST){$post_val = set_value('video_title'); }else{$post_val = $post_data['post_title']; } ?>
            <input type="text" name="video_title" id ="video_title" placeholder="Video Title" value="<?php echo $post_val; ?>" class="form-css" />
        </div>

        <div class="input-wrap full-width">
            <label class="label-css">Comment</label>
            <?php if($_POST){ $post_comm = set_value('video_desc'); }else{ $post_comm = $post_data['video']['description']; } ?>
            <textarea class="textarea-css" name="video_desc"><?php echo $post_comm; ?></textarea>
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