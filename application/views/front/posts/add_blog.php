<script type="text/javascript" src="<?= DEFAULT_ADMIN_JS_PATH ?>plugins/forms/tags/tokenfield.min.js"></script>
<script type="text/javascript" src="<?= DEFAULT_ADMIN_JS_PATH ?>plugins/editors/summernote/summernote.min.js"></script>
<script type="text/javascript" src="<?= DEFAULT_ADMIN_JS_PATH ?>pages/editor_summernote.js"></script>

<?php echo validation_errors(); ?>
<div class="right-panel">
    <div class="form-element">
        <h3 class="h3-title">Add Blog</h3>
        <form method="post" action="" id="frmblog" enctype="multipart/form-data">
            <div class="input-wrap">
                <label class="label-css">Select Channel </label>
                <select class="form-control" data-placeholder="Select a Channel"  name="channel" id="channel" class="form-css">
                    <option value="">Select Channel</option> 
                    <?php
                    foreach ($all_channels as $key => $channel)
                    {
                        ?> 
                        <option value="<?php echo $channel['id']; ?>"><?php echo $channel['channel_name']; ?></option>
                    <?php } ?> 
                </select>
            </div>

            <div class="input-wrap">
                <label class="label-css">Select Category </label>
                <select class="form-control category" data-placeholder="Select a Category"  name="category" id="category"class="form-css">
                    <option value="">Select Category</option> 
                    <?php
                    foreach ($all_category as $key => $category)
                    {
                        ?> 
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
                    <?php } ?> 
                </select>
            </div>

            <div class="input-wrap">
                <label class="label-css">Select Sub Category </label>
                <select class="form-control sub_category" data-placeholder="Select a Sub Category"  name="sub_category" id="sub_category" class="form-css">
                    <option value="">Select Sub Category</option> 
                    <?php
                    foreach ($all_sub_cat as $key => $cat)
                    {
                        ?> 
                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['category_name']; ?></option>
                    <?php } ?> 
                </select>
            </div>
            
            <div class="input-wrap">
                <label class="label-css">Blog Title </label>
                <input type="text" name="blog_title" id ="blog_title" placeholder="Blog Title" value="" class="form-css" />
            </div>
            <!--                    <div class="form-group">
                                    <textarea name="blog_description" class="form-control" placeholder="Blog Description *" ><?php echo set_value('blog_description'); ?></textarea>
                                </div>-->
            <div class="input-wrap">
                <label class="label-css">Upload File</label>
                <div class="input-file">
                    <input type="text" class="form-css" readonly>
                    <label class="input-group-btn">
                        <span class="">
                            Browse <input type="file" name="img_path[]" style="display: none;" multiple>
                        </span>
                    </label>

                </div>
            </div>

<!--            <div class="form-group">

                <textarea name="blog_description" id="blog_description" placeholder="Enter blog Description *" class="summernote form-control"><?php echo set_value('blog_description'); ?></textarea>

            </div>-->

            <div class="btn-btm">
                <button class="common-btn btn-submit" type="submit">Submit</button>
            </div>
        </form>
        <!-- /login form -->
    </div>
    <!-- /LOGIN -->
</div>
</div>
</section>
<script>
    $(document).ready(function () {
        $('.summernote').summernote({
            height: 230,
            minHeight: null,
            maxHeight: null,
            focus: false,
            callbacks: {
                onImageUpload: function (files, editor, welEditable) {
                    for (var i = files.length - 1; i >= 0; i--) {
                        sendFile(files[i], this);
                    }
                },
            },
            dialogsFade: true,
            fontNames: ['Roboto Light', 'Roboto Regular', 'Roboto Bold'],
            toolbar: [
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['font', ['style', 'bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
//['height', ['height']],
                ['table', ['table']],
                ['insert', ['picture', 'link']],
//['view', ['fullscreen', 'codeview']],
//['misc', ['undo','redo']]
            ]
        });

        function sendFile(file, el) {
            var form_data = new FormData();
            form_data.append('file', file);
            $.ajax({
                data: form_data,
                type: "POST",
                url: '/saveuploadedfile',
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                success: function (url) {
                    $(el).summernote('editor.insertImage', url);
                }
            });
        }
//
//        $("[name*='category']").on('change', function () {
//            $.ajax({
//                data: form_data,
//                type: "POST",
//                url: '/saveuploadedfile',
//                cache: false,
//                contentType: false,
//                processData: false,
//                success: function (url) {
//                    
//                }
//            });
//        });


        $('.category').change(function () {
            var selCategory = $(this).val();
            console.log(selCategory);
            $.ajax({
                url: "ajax_call",
                async: false,
                type: "POST",
                data: "category=" + selCategory,
                dataType: "html",
                success: function (data) {
                    $('.sub_category').html(data);
                }
            })
        });

    });


</script>
<!-- / -->