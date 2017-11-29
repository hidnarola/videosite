<div class="right-panel">
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
                <label class="label-css">Birth Date </label>
                <?php $post_birth_date = ($_POST) ? set_value('birth_date') : $user_data['birth_date']; ?>
                <input type="text" name="birth_date" id="birth_date" placeholder="Birth Date" value="<?php echo $post_birth_date; ?>" class="form-css datepicker"
                        data-date-format="yyyy-mm-dd" disabled />
            </div>

            <div class="input-wrap">
                <label class="label-css">Upload File</label>
                <div class="input-file">
                    <input type="text" class="form-css" readonly>
                    <label class="input-group-btn">
                        <span class="">
                            Browse <input type="file" style="display: none;" >
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

<script type="text/javascript">    
    $('.datepicker').datepicker();
</script>