<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

<div class="form-element">
    <h3 class="h3-title">Add Blog</h3>
    <?php 
        $all_erros = validation_errors(); 
        if(!empty($all_erros)){
    ?>
        <div class="alert alert-danger"><?php echo $all_erros; ?></div>
    <?php } ?>
    <form method="post" action="" id="frmblog" enctype="multipart/form-data">

        <div class="input-wrap">
            <label class="label-css">Title </label>
            <?php 
                if($post_type == 'blog') { 
                    if($_POST){$post_val = set_value('title'); }else{$post_val = $slide_data['blog_title']; }
                }else{
                    if($_POST){$post_val = set_value('title'); }else{$post_val = $slide_data['title']; }
                }
            ?>
            <input type="text" name="title" id ="title" placeholder="Title" value="<?php echo $post_val; ?>" class="form-css" />
        </div>
        
        <div class="input-wrap">
            <label class="label-css">Upload File</label>
            <div class="input-file">
                <a data-fancybox class="cursor_pointer" href="<?php echo base_url().$slide_data['img_path'] ?>">
                    <img src="<?php echo base_url().$slide_data['img_path'] ?>" alt="" width="100px" height="100px">
                </a>
                <input type="text" class="form-css browse_text" readonly >
                <label class="input-group-btn">
                    <span class="">
                        Browse <input type="file" style="display: none;" name="img_path">
                    </span>
                </label>
            </div>
        </div>

        <div class="input-wrap full-width">
            <label class="label-css">Description</label>
            <?php 
                if($post_type == 'blog') { 
                    if($_POST){$post_desc = set_value('description'); }else{$post_desc = $slide_data['blog_description']; }
                }else{
                    if($_POST){$post_desc = set_value('description'); }else{$post_desc = $slide_data['description']; }
                }
            ?>
            <textarea id="summernote" name="description"><?php echo htmlspecialchars_decode($post_desc); ?></textarea>
        </div>

        <div class="btn-btm">
            <button class="common-btn btn-submit" type="submit">Submit</button>
        </div>
    </form>
    <!-- /login form -->
</div>    

<script type="text/javascript">

    $(document).ready(function () {                
        // $('.selectpicker_blog').selectpicker();

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

        $('#summernote').summernote({
            height:300
        });
    });

</script>
<!-- / -->