<div class="modal fade" id="login-register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    
    <div class="modal-dialog" role="document">
        <div class="modal-body">
            <div class="sing_in_up"> 
                <div class="sign-in hide">
                    <div class="sign-in-l">
                        <h2>
                            <big>Sign in</big>
                            <small>Please enter your login information.</small>
                        </h2>
                        <form id="commentForm" autocomplete="off">
                            <div class="input-wrap-div">
                                <input type="email" name="email_id" class="input-css" placeholder="Email" required />
                            </div>
                            <div class="input-wrap-div">
                                <input type="password" name="password" class="input-css" placeholder="Password"/>
                            </div>
                            <div class="remember-forgat">                                
                                <a class="cursor_pointer" onclick="$('.sing_in_up').addClass('hide'); $('.re-password').removeClass('hide');">
                                    Forgot password?
                                </a>
                            </div>
                            <button type="submit" name="">SIGN IN</button>
                        </form>
                    </div>
                    <div class="sign-in-r">
                        <h3>Don’t have an account?</h3>
                        <p>When an unknown printer took a gallery of type and scrambled it to make a type specimen book has survived not only five.</p>
                        <a href="javascript:void(0)" class="btn_sign_up">sign up</a>
                    </div>
                </div>
                <div class="sign-up">
                    <div class="sign-in-l">
                        <h2>
                            <big>Sign Up</big>
                            <small>Please enter your login information.</small>
                        </h2>
                        <form id="sign_up_form" method="post">
                            <div class="input-wrap-div">
                                <input type="text" name="username" class="input-css" placeholder="Username"/>
                            </div>    
                            <div class="input-wrap-div">
                                <input type="text" name="email_id" class="input-css" placeholder="E-mail"/>
                            </div>
                            <div class="input-wrap-div">
                                <input type="text" name="birth_date" class="form-css datepicker" placeholder="Birth Date" data-date-format="yyyy-mm-dd"/>
                            </div>
                            <div class="input-wrap-div">
                                <input type="password" name="password" class="input-css" placeholder="Password" id="password"/>
                            </div>
                            <div class="input-wrap-div">
                                <input type="password" name="repeat_password" class="input-css" placeholder="Re-Password"/>                            
                            </div>
                            <div class="remember-forgat">
                                <div class="checkbox">
                                    <input type="checkbox" name="i_agree" id="i_agree" title="Please agree to our policy!" required>
                                    <label for="i_agree">Term & Condition</label>
                                </div>
                            </div>
                            <button type="submit" >Sign up</button>
                        </form>
                    </div>
                    <div class="sign-in-r">
                        <h3>Have an account?</h3>
                        <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book has survived not only five.</p>
                        <a href="javascript:void(0)" class="btn_sign_in">sign IN</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="re-password hide">
            <h2>Forgot password</h2>
            <p>Please enter your email information.</p>
            <form id="forgotpassword">
                <div class="input-wrap-div">
                    <input type="text" name="email_id" placeholder="E-mail" required/>
                </div>
                <button type="submit">Submit</button>
                <a onclick="$('.sing_in_up').removeClass('hide'); $('.re-password').addClass('hide');" >Cancel</a>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    // $('.datepicker').datepicker();

    $(function(){
        $('.datepicker').datepicker();
    });

    var dialog = null;

    $("#commentForm").validate({
        submitHandler:function(form){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/registration/ajax_login",
                data: $(form).serialize(),
                dataType:'JSON',
                success: function (data) {

                    if(data['success'] == false){
                        var new_str = '';                               
                        new_str += '<p>'+data['email_error']+'</p>';
                        new_str += '<p>'+data['password_error']+'</p>';
                        
                        // bootbox.alert(new_str);

                        dialog = bootbox.dialog({
                            message: '<p class="text-center">'+new_str+'</p>',
                            closeButton: false
                        });
                        
                        // do something in the background
                        setTimeout(function(){
                            dialog.modal('hide');
                        },2000);                                

                    }else{
                        window.location.href="<?php echo base_url().'home'; ?>";
                    }
                    return false;
                }
            });
            return false; // required to block normal submit since you used ajax
        }
    });
    
$("#forgotpassword").validate({
        submitHandler:function(form){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/registration/ajax_forgot_password",
                data: $(form).serialize(),
                dataType:'JSON',
                success: function (data) {

                    if(data['success'] == false){
                        var new_str = '';                               
                        new_str += '<p>'+data['email_error']+'</p>';
                        // bootbox.alert(new_str);

                        dialog = bootbox.dialog({
                            message: '<p class="text-center">'+new_str+'</p>',
                            closeButton: false
                        });
                        
                        // do something in the background
                        setTimeout(function(){
                            dialog.modal('hide');
                        },2000);                                

                    }else{
                        window.location.href="<?php echo base_url().'home'; ?>";
                    }
                    return false;
                }
            });
            return false; // required to block normal submit since you used ajax
        }
    });
    $("#sign_up_form").validate({
        rules: {
            username: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 5
            },
            repeat_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            email_id : {
                required: true,
                email: true
            }
        },
        submitHandler:function(form){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/registration/user",
                data: $(form).serialize(),
                dataType:'JSON',
                beforeSend: function(){
                    dialog = bootbox.dialog({
                        message: '<p class="text-center">Please while we process</p>',
                        closeButton: false
                    });                        
                    // dialog.modal('hide');
                },
                success: function (data) {
                    
                    setTimeout(function(){
                        dialog.modal('hide');
                    },1500);

                    setTimeout(function(){                            
                        if(data['success'] == false){
                            
                            var dialog_new = bootbox.dialog({
                                message: '<p class="text-center">'+data['all_erros']+'</p>',
                                closeButton: false
                            });

                            setTimeout(function(){
                                dialog_new.modal('hide');
                            },2000);
                        }else{
                            var dialog_new = bootbox.dialog({
                                message: "<p class='text-center'>  Verification Mail has been sent to you. Please verify it in order to login your account.</p>",
                                closeButton: false
                            });

                            setTimeout(function(){
                                dialog_new.modal('hide');
                                $("#sign_up_form")[0].reset();
                                $("#commentForm")[0].reset();
                                $('#login-register').modal('hide');
                            },3000);

                            window.location.href="<?php echo base_url().'dashboard'; ?>";
                        }
                    },2000);


                }
            });
            return false; // required to block normal submit since you used ajax
        }
    });
    

    $("#login-register").on('hide.bs.modal', function () {
        $('label.error').remove();        
    });

</script>