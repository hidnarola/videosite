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
            <input type="text" name="title" id ="title" placeholder="Title" value="<?php echo set_value('title'); ?>" class="form-css" />
        </div>

        <div class="input-wrap">
            <label class="label-css">Upload File</label>
            <div class="input-file">
                <input type="text" class="form-css" readonly>
                <label class="input-group-btn">
                    <span class="">
                        Browse <input type="file" name="img_path" style="display: none;" >
                    </span>
                </label>
            </div>
        </div>

        <div class="input-wrap full-width">
            <label class="label-css">Description</label>
            <textarea id="summernote" name="description"><?php echo set_value('description'); ?></textarea>
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

        $('#summernote').summernote({
            height:300
        });
    });

</script>
<!-- / -->