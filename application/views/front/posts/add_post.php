<div class="form-element">    
    <h3 class="h3-title">Add <?php echo $post_type; ?></h3>
    <?php 
        $all_erros = validation_errors(); 
        if(!empty($all_erros)){
    ?>
        <div class="alert alert-danger"><?php echo $all_erros; ?></div>
    <?php } ?>
        <?php
        $data['channel_name'] = $this->db->get_where('user_channels',['id' => $channel_id])->row_array();
    ?>
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
        } else {?>
        
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
        <?php }?>
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
            <label class="label-css">Title </label>
            <input type="text" name="title" id ="title" placeholder="Title" value="<?php echo set_value('title'); ?>" class="form-css" />
        </div>

        <div class="input-wrap">
            <label class="label-css">Upload File</label>
            <div class="input-file">
                <input type="text" class="form-css" name="main_img_path" readonly >
                <label class="input-group-btn">
                    <span class="">
                        Browse <input type="file" name="img_path" style="display: none;">
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