<script type="text/javascript" src="<?= DEFAULT_ADMIN_JS_PATH ?>pages/form_inputs.js"></script>
<script type="text/javascript" src="<?= DEFAULT_ADMIN_JS_PATH ?>plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?= DEFAULT_ADMIN_JS_PATH ?>plugins/pickers/anytime.min.js"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . 'plugins/uploaders/fileinput.min.js' ?>"></script>
<style>                                  
    .valid-zip{
        margin-top: 7px;
        margin-bottom: 7px;
        display: block;
        color: #F44336;
        position: relative;
    }
</style>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Edit Profile</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li class="active">Edit Profile</li>
        </ul>
    </div>
</div>

<div class="content">
    <?php
    $message = $this->session->flashdata('message');
    echo my_flash($message);
    ?>
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" id="frmadmin" method="POST" enctype="multipart/form-data">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">First Name:</label>
                            <div class="col-lg-9">
                                <input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo $user_data['fname']; ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Last Name:</label>
                            <div class="col-lg-9">
                                <input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo $user_data['lname']; ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email:</label>
                            <div class="col-lg-9">
                                <input type="email" name="email_id" id="email_id" class="form-control" placeholder="Email" value="<?php echo $user_data['email_id']; ?>" >
                            </div>
                        </div>  
                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Username:</label>
                            <div class="col-lg-9">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo isset($user_data['username']) ? $user_data['username'] : ''; ?>" >
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Birth Date:</label>
                            <div class="col-lg-9">
                                <input type="text" name="birth_date" class="form-control" id="anytime-date" placeholder="Birth Date" 
                                       value="<?php echo $user_data['birth_date']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Avatar:</label>
                            <div class="col-lg-9">
                                <input type="file" class="file-input" name="my_img">
                                <input type="hidden" value="<?= isset($user_data['avatar']) ? $user_data['avatar'] : '' ?>" name="Himg_path" id="Himg_path">
                                <span class="help-block">Please upload only image file With .jpg, .jpeg, .png, .gif extension (Size : 1140px * 475px)</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">&nbsp;</label>
                            <div class="col-lg-6">
                                <img id="img-preview" src="<?php
                                if (isset($user_data['avatar']) && $user_data['avatar'] != '')
                                {
                                    echo base_url('uploads/avatars/' . $user_data['avatar']);
                                }
                                else
                                {
                                    echo DEFAULT_ADMIN_IMAGE_PATH . 'placeholder.jpg';
                                }
                                ?>" style="height:100px;width:100px;"/>
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


<script type="text/javascript">

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('.file-input').fileinput({
        browseLabel: 'Browse',
        browseIcon: '<i class="icon-file-plus"></i>',
        uploadIcon: '<i class="icon-file-upload2"></i>',
        removeIcon: '<i class="icon-cross3"></i>',
        layoutTemplates: {
            icon: '<i class="icon-file-check"></i>'
        },
        initialCaption: "No file selected"
    });
    $('.fileinput-upload-button').hide();
    $("input[name='avatar']").change(function () {
        readURL(this);
    });

    $(function () {
        // v! Simple Select and Live search select box

        $('.select2').select2();

        // Fixed width. Single select
        $('.select').select2({
            minimumResultsForSearch: Infinity,
            width: 250
        });

        $("#anytime-date").AnyTime_picker({
            format: "%Y-%m-%d",
            firstDOW: 1
        });


    });


//    function check_zipcode() {
//        $("#latitude").val('');
//        $("#longitude").val('');
//        var zipcode = $('#zipcode').val();
//        if (zipcode != '') {
//            $.ajax({
//                url: "https://maps.googleapis.com/maps/api/geocode/json?components=postal_code:" + zipcode + "&sensor=false",
//                method: "POST",
//                success: function (data) {
//                    if (data.status != 'OK') {
//                        $("#zipcode_error").html('<label class="valid-zip" for="zipcode">Zipcode is invalid.</label>');
//                    } else {
//                        $(".valid-zip").remove();
//                        latitude = data.results[0].geometry.location.lat;
//                        longitude = data.results[0].geometry.location.lng;
//                        $("#latitude").val(latitude);
//                        $("#longitude").val(longitude);
//                    }
//                }
//            });
//        }
//    }
//
//    function zip_validate() {
//        var longitude = $('#longitude').val();
//        var latitude = $('#latitude').val();
//        var zipcode = $('#zipcode').val();
//        if (zipcode != '' && (longitude == '' || latitude == '')) {
//            $("#zipcode_error").html('<label class="valid-zip" for="zipcode">Zipcode is invalid.</label>');
//            return false;
//        } else {
//            $(".valid-zip").remove();
//            return true;
//        }
//    }

    // fname ,lname
    // city country_id zipcode gender
    //---------------------- Validation -------------------
    $("#frmadmin").validate({
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        validClass: "validation-valid-label",
        errorPlacement: function (error, element) {
            if (element[0]['id'] == "country_id") {
                error.insertAfter(element.next('span'));  // select2
            } else {
                error.insertAfter(element)
            }
        },
        ignore: [],
        rules: {
            fname: {required: true},
            lname: {required: true},
            email_id: {
                required: true,
                remote: {
                    url: "<?php echo base_url() . 'admin/users/check_unique'; ?>",
                    type: "POST",
                    data: {email_id: function () {
                            return $("#email_id").val();
                        }, old_email_id: function () {
                            return '<?php echo $user_data["email_id"]; ?>';
                        }}
                }
            },

            birth_date: {required: true}
        },
        messages: {
            fname: {required: 'Please provide a First Name'},
            lname: {required: 'Please provide a Last Name'},
            email_id: {
                required: 'Please provide a Email Address',
                remote: "Email already exists. Please enter other email address"
            },

            birth_date: {required: 'Please Provide a Birthdate'},
        }
    });


</script>