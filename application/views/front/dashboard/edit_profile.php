
    <div class="form-element">
        <h3 class="h3-title">Edit Profile</h3>
    
        <?php 
            $all_erros = validation_errors(); 
            if(!empty($all_erros)){
        ?>
            <div class="alert alert-danger"><?php echo $all_erros; ?></div>
        <?php } ?>

        <form method="post" action="" id="frmeditprofile" enctype="multipart/form-data">
            <div class="input-wrap">
                <label class="label-css">User Name </label>
                <?php $post_uname = ($_POST) ? set_value('username') : $user_data['username']; ?>
                <input type="text" name="username" id ="username" placeholder="User Name" value="<?php echo $post_uname; ?>" class="form-css" />
            </div>
            <div class="input-wrap">
                <label class="label-css">E-mail </label>
                <?php $post_email = ($_POST) ? set_value('email_id') : $user_data['email_id']; ?>
                <input type="text" name="email_id" id="email_id" placeholder="E-mail" value="<?php echo $post_email; ?>" class="form-css" disabled />
            </div>
            <div class="input-wrap">
                <label class="label-css">First Name </label>
                <?php $post_fname = ($_POST) ? set_value('fname') : $user_data['fname']; ?>
                <input type="text" name="fname" id="fname" placeholder="First Name" value="<?php echo $post_fname; ?>" class="form-css" />
            </div>
            <div class="input-wrap">
                <label class="label-css">Last Name </label>
                <?php $post_lname = ($_POST) ? set_value('lname') : $user_data['lname']; ?>
                <input type="text" name="lname" id="lname" placeholder="Last Name" value="<?php echo $post_lname; ?>" class="form-css" />
            </div>
            <div class="input-wrap">
                <label class="label-css">Designation </label>
                <?php $post_designation = ($_POST) ? set_value('designation') : $user_data['designation']; ?>
                <input type="text" name="designation" id="designation" placeholder="Designation" value="<?php echo $post_designation; ?>" class="form-css" />
            </div>

            <div class="input-wrap">
                <label class="label-css">Birth Date </label>
                <?php $post_birth_date = ($_POST) ? set_value('birth_date') : $user_data['birth_date']; ?>
                <input type="date" name="birth_date" id="birth_date" placeholder="Birth Date" value="<?php echo $post_birth_date; ?>" class="form-css"
                        data-date-format="yyyy-mm-dd"  />
            </div>
            
            
            <div class="input-wrap">
                <label class="label-css">Upload File</label>
                <div class="input-file">
                    <a data-fancybox href="<?php echo base_url().$user_data['avatar'] ?>">
                        <img src="<?php echo base_url().$user_data['avatar'] ?>" alt="" width="100px" height="100px">
                    </a>
                    <input type="text" class="form-css browse_text" readonly >
                    <label class="input-group-btn">
                        <span class="">
                            Browse <input type="file" style="display: none;" name="my_img">
                        </span>
                    </label>
                </div>
            </div>

            <div class="btn-btm">
                <button class="common-btn btn-submit" type="submit">Submit</button>
                <!-- <button class="common-btn btn-reset" type="reset">Reset</button> -->
            </div>

            
        </form>
    </div>

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
</script>
