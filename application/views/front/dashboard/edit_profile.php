<?php echo validation_errors(); ?>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/validation/validate.min.js"; ?>"></script>
<div class="right-panel">
    <div class="form-element">
        <h3 class="h3-title">Edit Profile</h3>
        <form method="post" action="" id="frmeditprofile" enctype="multipart/form-data">
            <div class="input-wrap">
                <label class="label-css">User Name </label>
                <?php $post_uname = ($_POST) ? set_value('username') : $user_data['username']; ?>
                <input type="text" name="username" id ="username" placeholder="User Name" value="<?php echo $user_data['username']; ?>" class="form-css" />
            </div>
            <div class="input-wrap">
                <label class="label-css">E-mail </label>
                <input type="text" name="email_id" id="email_id" placeholder="E-mail" value="<?php echo $user_data['email_id']; ?>" class="form-css" disabled />
            </div>
            <div class="input-wrap">
                <label class="label-css">First Name </label>
                <input type="text" name="fname" id="fname" placeholder="First Name" value="<?php echo $user_data['fname']; ?>" class="form-css" />
            </div>
            <div class="input-wrap">
                <label class="label-css">Last Name </label>
                <input type="text" name="lname" id="lname" placeholder="Last Name" value="<?php echo $user_data['lname']; ?>" class="form-css" />
            </div>
            <div class="input-wrap">
                <label class="label-css">Birth Date </label>
                <input type="text" name="birth_date" id="birth_date" placeholder="Birth Date" value="<?php echo $user_data['birth_date']; ?>" class="form-css" />
            </div>

            <div class="input-wrap">
                <label class="label-css">Upload File</label>
                <div class="input-file">
                    <input type="text" class="form-css" readonly>
                    <label class="input-group-btn">
                        <span class="">
                            Browse <input type="file" style="display: none;" multiple>
                        </span>
                    </label>

                </div>
            </div>

            <div class="btn-btm">
                <button class="common-btn btn-submit" type="submit">Submit</button>
                <button class="common-btn btn-reset" type="reset">Reset</button>
            </div>


        </form>
    </div>


</div>
<script>
    $("#frmeditprofile").validate({
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
            username: {
                required: true,
            },
            fname: {
                required: true,
            },
            lname: {
                required: true,
            },
            birth_date:{
                required: true,
            }

        },
        messages: {
            username: {
                required: "Please provide a User Name",
            },
            fname: {
               required: "Please provide a First Name",
            },
            lname: {
                required: "Please provide a Last Name",
            },
            birth_date:{
                required: "Please provide a Birth Date"
            }
        }
    });
</script>