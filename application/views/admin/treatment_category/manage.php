<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/forms/tags/tokenfield.min.js"></script>
<style>
.setting-heading{
    margin: 0px;
}
</style>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - <?php echo $heading; ?></h4>            
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li><a href="<?php echo site_url('admin/treatment_category'); ?>">Treatment Category</a></li>
            <li class="active"><?php echo $heading; ?></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" action="" id="frm_treat_cat" method="POST">
                <input type="hidden" name="slug" id="slug" value="<?php echo (isset($record['slug'])) ? $record['slug'] : set_value('slug'); ?>">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Treatment Category Title:</label>
                            <div class="col-lg-9">
                                <input type="text" name="title" id="title" placeholder="Enter Category title" class="form-control" value="<?php echo (isset($record['title'])) ? $record['title'] : set_value('title'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Category Code:</label>
                            <div class="col-lg-9">
                                <input type="text" name="code" id="code" placeholder="Enter Category code" class="form-control" value="<?php echo (isset($record['code'])) ? $record['code'] : set_value('code'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Keywords:</label>
                            <div class="col-lg-9">
                                

                                <textarea  name="site_keywords" id="site_keywords" placeholder="Keywords..." class="form-control tokenfield-teal" 
                                ><?php echo (isset($record['keywords'])) ? $record['keywords'] : set_value('site_keywords'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Status:</label>
                            <div class="col-lg-6">

                                <label class="radio-inline">
                                    <input type="radio" class="styled" checked name="is_blocked" value="0" <?php
                                    if (isset($record['is_blocked']) && $record['is_blocked'] == '0') {
                                        echo 'checked';
                                    }
                                    ?>> In-active </label>

                                <label class="radio-inline">
                                    <input type="radio" class="styled" name="is_blocked" value="1" <?php
                                    if (isset($record['is_blocked']) && $record['is_blocked'] == '1') {
                                        echo 'checked';
                                    }
                                    ?>> Standard Request </label>

                                <label class="radio-inline">
                                    <input type="radio" class="styled" name="is_blocked" value="2" <?php
                                    if (isset($record['is_blocked']) && $record['is_blocked'] == '2') {
                                        echo 'checked';
                                    }
                                    ?>> Quick request eligible </label>

                                <label class="radio-inline">
                                    <input type="radio" class="styled" name="is_blocked" value="3" <?php
                                    if (isset($record['is_blocked']) && $record['is_blocked'] == '3') {
                                        echo 'checked';
                                    }
                                    ?>> Auto Bid </label>

                            </div>
                        </div>
                        
                        <?php if(isset($edit_page)) { ?>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Treatment Category Link:</label>
                                <div class="col-lg-9">                                                                    
                                    <?php $encoded_url = encode($record['id'].'_'.date('Y-m-d H:i:s')); ?>
                                    <textarea name="" rows="2" cols="150" class="form form-control" readonly
                                        ><?php echo base_url().'quick_rfp/register/'.$encoded_url; ?>
                                    </textarea>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="text-right">
                        <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<script>
    $(".styled, .multiselect-container input").uniform({
        radioClass: 'choice'
    });

    //---------------------- Validation -------------------
    $("#frm_treat_cat").validate({
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        validClass: "validation-valid-label",
        success: function(label) {
            label.addClass("validation-valid-label").text("Success.")
        },
        rules: {
            title: {
                required: true,
                remote: {
                    url: "<?php echo base_url('admin/treatment_category/check_cat_title_exists/' . (isset($record['id']) ? $record['id'] : '0')); ?>",
                    type: "post",
                    data: {
                        title: function () {
                            return $("#title").val();
                        }
                    }
                }
            }

        },
        messages: {
            title: {
                required: "Please provide a Title",
                remote: "Title is already exist, please choose diffrent Title"
            }
        }
    });

    $(function(){
         // Add class on init
        $('.tokenfield-teal').on('tokenfield:initialize', function (e) {
            $(this).parent().find('.token').addClass('bg-teal')
        });

        // Initialize plugin
        $('.tokenfield-teal').tokenfield();

        // Add class when token is created
        $('.tokenfield-teal').on('tokenfield:createdtoken', function (e) {
            $(e.relatedTarget).addClass('bg-teal')
        });

    });
</script>