<script type="text/javascript" src="<?= DEFAULT_ADMIN_JS_PATH ?>plugins/forms/tags/tokenfield.min.js"></script>
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
            <li><a href="<?php echo site_url('admin/categories'); ?>"> Category</a></li>
            <li class="active"><?php echo $heading; ?></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" action="" id="frm_cat" method="POST">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Category Name:</label>
                            <div class="col-lg-9">
                                <input type="text" name="category_name" id="category_name" placeholder="Enter Category Name" class="form-control" value="<?php echo (isset($record['category_name'])) ? $record['category_name'] : set_value('category_name'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Category Icon </label>
                            <div class="col-lg-9">
                                <input type="text" name="icon" id="icon" placeholder="Enter Icon" class="form-control" value="<?php echo (isset($record['icon'])) ? $record['icon'] : set_value('icon'); ?>">

                                <span class="help-block">Please select the icon from the given link. <a href="<?php echo base_url() . 'admin/categories/select_icon' ?>" target="_blank">Icons</a></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Status:</label>
                            <div class="col-lg-3">
                                <label class="radio-inline">
                                    <input type="radio" class="styled" name="is_blocked" value="0" checked <?php
                                    if (isset($record['is_blocked']) && $record['is_blocked'] == '0')
                                    {
                                        echo 'checked';
                                    }
                                    ?>>
                                    Unblock
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" class="styled" name="is_blocked" value="1" <?php
                                    if (isset($record['is_blocked']) && $record['is_blocked'] == '1')
                                    {
                                        echo 'checked';
                                    }
                                    ?>>
                                    Block
                                </label>
                            </div>
                        </div>
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
    // Format icon
    function iconFormat(icon) {
        var originalOption = icon.element;
        if (!icon.id) {
            return icon.text;
        }
        var $icon = "<i class='icon-" + $(icon.element).data('icon') + "'></i>" + icon.text;

        return $icon;
    }
    // Initialize with options
    $(".select-icons").select2({
        templateResult: iconFormat,
        minimumResultsForSearch: Infinity,
        templateSelection: iconFormat,
        escapeMarkup: function (m) {
            return m;
        }
    });
    //---------------------- Validation -------------------
    $("#frm_cat").validate({
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        validClass: "validation-valid-label",
        success: function (label) {
            label.addClass("validation-valid-label").text("Success.")
        },
        rules: {
            category_name: {
                required: true,
                remote: {
                    url: "<?php echo base_url('admin/categories/check_category_name_exists/' . (isset($record['id']) ? $record['id'] : '0')); ?>",
                    type: "post",
                    data: {
                        category_name: function () {
                            return $("#category_name").val();
                        }
                    }
                }
            }

        },
        messages: {
            category_name: {
                required: "Please provide a Category Name",
                remote: "Category Name is already exist, please choose diffrent Name"
            }
        }
    });

    $(function () {
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