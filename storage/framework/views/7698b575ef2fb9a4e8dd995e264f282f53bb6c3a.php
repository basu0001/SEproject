<?php
$setting = App\SmGeneralSettings::find(1);
if(isset($setting->copyright_text)){ $copyright_text = $setting->copyright_text; }else{ $copyright_text = 'Copyright © 2019 All rights reserved | This application is made with by Codethemes'; }
if(isset($setting->logo)) { $logo = $setting->logo; } else{ $logo = 'public/uploads/settings/logo.png'; }

if(isset($setting->favicon)) { $favicon = $setting->favicon; } else{ $favicon = 'public/backEnd/img/favicon.png'; }

$login_background = App\SmBackgroundSetting::where([['is_default',1],['title','Login Background']])->first();

if(empty($login_background)){
    $css = "";
}else{
    if(!empty($login_background->image)){
        $css = "background: url('". url($login_background->image) ."')  no-repeat center;  background-size: cover;";

    }else{
        $css = "background:".$login_background->color;
    }
}
$active_style = App\SmStyle::where('is_active', 1)->first();

$ttl_rtl = $setting->ttl_rtl;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="<?php echo e(asset($favicon)); ?>" type="image/png"/>
    <meta name="_token" content="<?php echo csrf_token(); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/login2')); ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/login2')); ?>/themify-icons.css">


    <link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/backEnd/vendors/css/nice-select.css" />
    <link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/backEnd/vendors/js/select2/select2.css" />



    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/login2')); ?>/css/style.css">
	<link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/toastr.min.css"/>
    <title><?php echo e(isset($setting)? !empty($setting->site_title) ? $setting->site_title : 'System ': 'System '); ?> | <?php echo app('translator')->get('lang.login'); ?></title>
    <style>

.loginButton {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.loginButton{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}
.singleLoginButton{
    flex: 22% 0 0;
}

.loginButton .get-login-access {
    display: block;
    width: 100%;
    border: 1px solid #fff;
    border-radius: 5px;
    margin-bottom: 20px;
    padding: 5px;
    white-space: nowrap;
}
@media (max-width: 576px) {
  .singleLoginButton{
    flex: 49% 0 0;
  }
}
@media (max-width: 576px) {
  .singleLoginButton{
    flex: 49% 0 0;
  }
  .loginButton .get-login-access {
    margin-bottom: 10px;
}
}
.create_account a {
    color: #828bb2;
    font-weight: 500;
    text-decoration: none;
}
    </style>
</head>
<body >
    <div class="in_login_part mb-40"  style="<?php echo e($css); ?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8 col-lg-5 col-xl-4 col-md-7">
					
                    <div class="in_login_content">
                        <?php if(!empty($setting->logo)): ?><img src="<?php echo e(asset($setting->logo)); ?>" alt="Login Panel"><?php endif; ?>
                        <div class="in_login_page_iner">
                            <div class="in_login_page_header">
                                <h5><?php echo app('translator')->get('lang.login'); ?> <?php echo app('translator')->get('lang.details'); ?></h5>
                            </div>
                            <form method="POST" class="loginForm" action="<?php echo e(url('/login')); ?>" id="infix_form">
                                <?php echo csrf_field(); ?>

                                <input type="hidden" name="school_id" value="1">
                                <input type="hidden" name="username" id="username-hidden">

                                <?php if(session()->has('message-danger') != ""): ?>
                                    <?php if(session()->has('message-danger')): ?>
                                    <p class="text-danger"><?php echo e(session()->get('message-danger')); ?></p>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <input type="hidden" id="url" value="<?php echo e(url('/')); ?>">

                                <div class="in_single_input">
                                    <input type="text" placeholder="<?php echo app('translator')->get('lang.enter'); ?> <?php echo app('translator')->get('lang.email'); ?>" name="email" class="<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('email')); ?>" id="email-address">
                                    <span class="addon_icon">
                                        <i class="ti-email"></i>
                                    </span>
                                    <?php if($errors->has('email')): ?>
                                        <span class="invalid-feedback text-left pl-3 d-block" role="alert">
                                            <strong><?php echo e($errors->first('email')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="in_single_input">
                                    <input type="password" placeholder="<?php echo app('translator')->get('lang.enter'); ?>  <?php echo app('translator')->get('lang.password'); ?>" name="password" class="<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('password')); ?>">
                                    <span class="addon_icon">
                                        <i class="ti-key"></i>
                                    </span>
                                    <?php if($errors->has('password')): ?>
                                        <span class="invalid-feedback text-left pl-3 d-block" role="alert">
                                            <strong><?php echo e($errors->first('password')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="in_checkbox">
                                        <div class="boxes">
                                            <input type="checkbox" id="Remember">
                                            <label for="Remember"><?php echo app('translator')->get('lang.remember_me'); ?></label>
                                        </div>
                                    </div>
                                    <div class="in_forgot_pass">
                                        <a href="<?php echo e(url('recovery/passord')); ?>"><?php echo app('translator')->get('lang.forget'); ?> <?php echo app('translator')->get('lang.password'); ?> ? </a>
                                    </div>
                                </div>
                                <div class="in_login_button text-center">
                                    <button type="submit" class="in_btn" id="btnsubmit">
                                        <span class="ti-lock"></span>
                                        <?php echo app('translator')->get('lang.login'); ?>
                                    </button>
                                </div>
                                
                            </form>
                        </div>
                    </div>

                    <?php if(Illuminate\Support\Facades\Config::get('app.app_sync')): ?>
                        <div class="row justify-content-center align-items-center" style="margin-top: 25px !important;">
                            <div class="col-lg-12 col-md-12 text-center mt-30 btn-group" id="btn-group">

                                <div class="loginButton">
                                    <?php
                                        $user =  DB::table('users')->select('email')->where('role_id',1)->first();
                                    ?>

                                    <?php if(!empty($user)): ?>
                                    <div class="singleLoginButton">

                                            <form method="POST" class="loginForm" action="<?php echo e(route('login')); ?>">
                                                <?php
                                                echo csrf_field();
                                                $user =  DB::table('users')->select('email')->where('role_id',1)->first();
                                                $email = $user->email;

                                                ?>
                                                <input type="hidden" name="school_id" value="1">
                                                <input type="hidden" name="email" value="<?php echo e($email); ?>">
                                                <input type="hidden" name="password" value="123456">
                                                <button type="submit" class="white get-login-access">Super Admin</button>
                                            </form>

                                    </div>
                                    <?php endif; ?>

                                    <?php
                                        $user =  DB::table('users')->select('email')->where('role_id',5)->first();
                                    ?>

                                    <?php if(!empty($user)): ?>


                                    <div class="singleLoginButton">

                                            <form method="POST" class="loginForm" action="<?php echo e(route('login')); ?>">
                                                <?php
                                                echo csrf_field();

                                                $email = $user->email; ?>
                                                <input type="hidden" name="school_id" value="1">
                                                <input type="hidden" name="email" value="<?php echo e($email); ?>">
                                                <input type="hidden" name="password" value="123456">

                                                <button type="submit" class="white get-login-access">Admin</button>
                                            </form>
                                    </div>
                                    <?php endif; ?>
                                    <?php
                                        $user =  DB::table('users')->select('email')->where('role_id',4)->first();
                                    ?>

                                    <?php if(!empty($user)): ?>
                                    <div class="singleLoginButton">

                                            <form method="POST" class="loginForm" action="<?php echo e(route('login')); ?>">
                                                <?php
                                                echo csrf_field();
                                                // $user =  DB::table('users')->select('email')->where('role_id',4)->first();
                                                $email = $user->email; ?>
                                                <input type="hidden" name="school_id" value="1">

                                                <input type="hidden" name="email" value="<?php echo e($email); ?>">
                                                <input type="hidden" name="password" value="123456">

                                                <button type="submit" class="white get-login-access">Teacher</button>
                                            </form>
                                    </div>
                                    <?php endif; ?>
                                    <?php
                                        $user =  DB::table('users')->select('email')->where('role_id',6)->first();
                                    ?>

                                    <?php if(!empty($user)): ?>
                                    <div class="singleLoginButton">

                                            <form method="POST" class="loginForm" action="<?php echo e(route('login')); ?>">
                                                <?php
                                                echo csrf_field();
                                                $user =  DB::table('users')->select('email')->where('role_id',6)->first();
                                                $email = $user->email; ?>
                                                <input type="hidden" name="school_id" value="1">
                                                <input type="hidden" name="email" value="<?php echo e($email); ?>">

                                                <input type="hidden" name="password" value="123456">

                                                <button type="submit" class="white get-login-access">Accountant</button>
                                            </form>
                                    </div>
                                    <?php endif; ?>
                                    <?php
                                        $user =  DB::table('users')->select('email')->where('role_id',7)->first();
                                    ?>

                                    <?php if(!empty($user)): ?>
                                    <div class="singleLoginButton">

                                            <form method="POST" class="loginForm" action="<?php echo e(route('login')); ?>">
                                                <?php
                                                echo csrf_field();
                                                $user =  DB::table('users')->select('email')->where('role_id',7)->first();
                                                $email = $user->email; ?>
                                                <input type="hidden" name="school_id" value="1">
                                                <input type="hidden" name="email" value="<?php echo e($email); ?>">
                                                <input type="hidden" name="password" value="123456">

                                                <button type="submit" class="white get-login-access">Receptionist</button>
                                            </form>
                                    </div>
                                    <?php endif; ?>
                                    <?php
                                        $user =  DB::table('users')->select('email')->where('role_id',8)->first();
                                    ?>

                                    <?php if(!empty($user)): ?>
                                    <div class="singleLoginButton">

                                            <form method="POST" class="loginForm" action="<?php echo e(route('login')); ?>">
                                                <?php
                                                echo csrf_field();
                                                $user =  DB::table('users')->select('email')->where('role_id',8)->first();
                                                $email = $user->email; ?>
                                                <input type="hidden" name="school_id" value="1">
                                                <input type="hidden" name="email" value="<?php echo e($email); ?>">
                                                <input type="hidden" name="password" value="123456">

                                                <button type="submit" class="white get-login-access">Librarian</button>
                                            </form>
                                    </div>
                                    <?php endif; ?>
                                    <?php
                                        $user =  DB::table('users')->select('email')->where('role_id',2)->first();
                                    ?>

                                    <?php if(!empty($user)): ?>
                                    <div class="singleLoginButton">

                                            <form method="POST" class="loginForm" action="<?php echo e(route('login')); ?>">
                                                <?php
                                                echo csrf_field();
                                                $user =  DB::table('users')->select('email')->where('role_id',2)->first();
                                                $email = $user->email; ?>
                                                <input type="hidden" name="school_id" value="1">
                                                <input type="hidden" name="email" value="<?php echo e($email); ?>">
                                                <input type="hidden" name="password" value="123456">

                                                <button type="submit" class="white get-login-access">Student</button>
                                            </form>
                                    </div>
                                    <?php endif; ?>
                                    <?php
                                        $user =  DB::table('users')->select('email')->where('role_id',3)->first();
                                    ?>

                                    <?php if(!empty($user)): ?>
                                    <div class="singleLoginButton">

                                            <form method="POST" class="loginForm" action="<?php echo e(route('login')); ?>">
                                                <?php
                                                echo csrf_field();
                                                $user =  DB::table('users')->select('email')->where('role_id',3)->first();
                                                $email = $user->email; ?>
                                                <input type="hidden" name="school_id" value="1">
                                                <input type="hidden" name="email" value="<?php echo e($email); ?>">
                                                <input type="hidden" name="password" value="123456">

                                                <button type="submit" class="white get-login-access">Parents</button>
                                            </form>
                                    </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!--================ Footer Area =================-->
    <footer class="footer_area min-height-10" style="margin-top: -50px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <p style="color: #828bb2"><?php echo $copyright_text; ?> </p>
                </div>
            </div>
        </div>
    </footer>


    <!--================ End Footer Area =================-->
    <script src="<?php echo e(asset('public/backEnd/login2')); ?>/js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo e(asset('public/backEnd/login2')); ?>/js/popper.min.js"></script>
	<script src="<?php echo e(asset('public/backEnd/login2')); ?>/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/toastr.min.js"></script>



	<script>
	$(document).ready(function () {

		$('#btnsubmit').on('click',function()
		{
		$(this).html('Please wait ...')
			.attr('disabled','disabled');
		$('#infix_form').submit();
		});

	 });


	$(document).ready(function() {
        $("#email-address").keyup(function(){
            $("#username-hidden").val($(this).val());
        });
    });

	 </script>



	<?php echo Toastr::message(); ?>

  </body>
</html>
<?php /**PATH E:\Server3\htdocs\spondon\infixedu_lv7.0_rv_4.5\resources\views/auth/loginCodeCanyon.blade.php ENDPATH**/ ?>