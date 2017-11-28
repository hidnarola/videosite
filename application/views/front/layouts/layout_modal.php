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
                            <input type="email" name="email_id" class="input-css" placeholder="Email" required />
                            <input type="password" name="password" class="input-css" placeholder="Password"/>
                            <div class="remember-forgat">                                
                                <a class="cursor_pointer" onclick="$('.sing_in_up').addClass('hide'); $('.re-password').removeClass('hide');">
                                    Forget password?
                                </a>
                            </div>
                            <button type="submit" name="">SIGN IN</button>
                        </form>
                    </div>
                    <div class="sign-in-r">
                        <h3>Don’t have an account?</h3>
                        <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book has survived not only five.</p>
                        <a href="javascript:void(0)" class="btn_sign_up">sign up</a>
                    </div>
                </div>
                <div class="sign-up">
                    <div class="sign-in-l">
                        <h2>
                            <big>Sign Up</big>
                            <small>Please enter your login information.</small>
                        </h2>
                        <form>
                            <input type="text" name="" class="input-css" placeholder="Name"/>
                            <input type="text" name="" class="input-css" placeholder="E-mail"/>
                            <input type="password" name="" class="input-css" placeholder="Password"/>
                            <input type="password" name="" class="input-css" placeholder="Re-Password"/>
                            <div class="remember-forgat">
                                <div class="checkbox">
                                    <input id="check2" type="checkbox" name="check" value="check2">
                                    <label for="check2">Term & Condition</label>
                                </div>
                            </div>
                            <button type="submit" name="">SIGN IN</button>
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
            <form>
                <input type="text" name="" placeholder="E-mail"/>
                <button type="submit">Submit</button>
                <a onclick="$('.sing_in_up').removeClass('hide'); $('.re-password').addClass('hide');" >cancel</a>
            </form>
        </div>
    </div>
</div>