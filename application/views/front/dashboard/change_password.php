<div class="form-element">
    <h3 class="h3-title">Edit Profile</h3>

    <?php
    $all_erros = validation_errors();
    if (!empty($all_erros))
    {
        ?>
        <div class="alert alert-danger"><?php echo $all_erros; ?></div>
<?php } ?>
    <form method="post" action="" id="frmregister" enctype="multipart/form-data">
        <div class="input-wrap">
            <label class="label-css">Old Password </label>
            <input type="password" name="old_password" id ="old_password" placeholder="Old Password" class="form-css" />
        </div>

        <div class="input-wrap">
            <label class="label-css">Password </label>
            <input type="password" name="password" id="password" class="form-css" placeholder="Password *"  >
        </div>

        <div class="input-wrap">
            <label class="label-css">Repeat Password </label>
            <input type="password" name="repeat_password" id="" class="form-css" placeholder="Repeat Password *" >
        </div>				 		
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
                <button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> Update</button>
            </div>
        </div>
    </form>
</div>