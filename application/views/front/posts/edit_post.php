<!-- include summernote css/js-->
<!-- <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script> -->


<div class="form-element">    

    <h3 class="h3-title">Edit <?php echo $post_type; ?></h3>
    <?php 
        $all_erros = validation_errors(); 
        if(!empty($all_erros)){
    ?>
        <div class="alert alert-danger"><?php echo $all_erros; ?></div>
    <?php } ?>

    <a href="<?php echo base_url().'user_post/view_all_slides/'.$post_id; ?>" class="btn-black">
        View All Slides
    </a>
<br>
    <br>
    <br>
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
            <label class="label-css">Title </label>
            <?php if($_POST){$post_val = set_value('title'); }else{$post_val = $post_data['post_title']; } ?>
            <input type="text" name="title" id ="title" placeholder="Title" value="<?php echo $post_val; ?>" class="form-css" />
        </div>

         

        <div class="input-wrap">
            <label class="label-css">Upload File</label>
            <div class="input-file">
                
                <a data-fancybox href="<?php echo base_url().$post_data['main_image'] ?>">
                    <img src="<?php echo base_url().$post_data['main_image'] ?>" alt="" width="100px" height="100px" onerror="this.src='<?php echo base_url().'public/front/images/imgnotfound.jpg'; ?>'">
                </a>

                <input type="text" class="form-css browse_text" readonly >
                <label class="input-group-btn">
                    <span class="">
                        Browse <input type="file" style="display: none;" name="img_path">
                    </span>
                </label>
            </div>
        </div>

        <!-- <div class="input-wrap full-width">
            <label class="label-css">Comment</label>
            <div id="summernote">Hello Summernote</div>
        </div> -->

        <div class="btn-btm">
            <button class="common-btn btn-submit" type="submit">Submit</button>
        </div>
    </form>
    <!-- /login form -->
</div>
<!-- /LOGIN -->



<script>

    $(document).ready(function() {
        // $('#summernote').summernote({
        //     height:300
        // });

        $("[data-fancybox]").fancybox({
            buttons : [
                'slideShow',
                'fullScreen',
                'thumbs',
                // 'share',
                //'download',
                'zoom',
                'close'
            ]
        });
    });
    
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