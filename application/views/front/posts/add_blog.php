<script type="text/javascript" src="<?= DEFAULT_ADMIN_JS_PATH ?>plugins/forms/tags/tokenfield.min.js"></script>
<script type="text/javascript" src="<?= DEFAULT_ADMIN_JS_PATH ?>plugins/editors/summernote/summernote.min.js"></script>
<script type="text/javascript" src="<?= DEFAULT_ADMIN_JS_PATH ?>pages/editor_summernote.js"></script>
<section>
    <div class="container">
        <div class="row">						
            <div class="col-md-12">
                <!-- login form -->

                <?php echo validation_errors(); ?>

                <form method="post" action="" id="frmblog" enctype="multipart/form-data">
                    <div class="form-group">
                        <select class="form-control" data-placeholder="Select a Channel"  name="channel" id="channel">
                            <option value="">Select Channel</option> 
                            <?php
                            foreach ($all_channels as $key => $channel)
                            {
                                ?> 
                                <option value="<?php echo $channel['id']; ?>"><?php echo $channel['channel_name']; ?></option>
                            <?php } ?> 
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" data-placeholder="Select a Category"  name="category" id="category">
                            <option value="">Select Category</option> 
                            <?php
                            foreach ($all_category as $key => $category)
                            {
                                ?> 
                                <option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
                            <?php } ?> 
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" data-placeholder="Select a Sub Category"  name="sub_category" id="sub_category">
                            <option value="">Select Sub Category</option> 
                            <?php
                            foreach ($all_sub_cat as $key => $cat)
                            {
                                ?> 
                                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['category_name']; ?></option>
                            <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="blog_title" class="form-control" placeholder="Blog Title *" 
                               value="<?php echo set_value('blog_title'); ?>" >
                    </div>
                    <!--                    <div class="form-group">
                                            <textarea name="blog_description" class="form-control" placeholder="Blog Description *" ><?php echo set_value('blog_description'); ?></textarea>
                                        </div>-->
                    <div class="form-group">
                        <input type="file" name="img_path[]" class="form-control">
                    </div>

                    <div class="form-group">

                        <textarea name="blog_description" id="blog_description" placeholder="Enter blog Description *" class="summernote form-control"><?php echo set_value('blog_description'); ?></textarea>

                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
                            <button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> Create </button>
                        </div>
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
    });

</script>
<!-- / -->