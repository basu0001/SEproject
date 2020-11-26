<?php

    use App\SmNotification;
    use App\SmParent;
    use App\User;

    if (Auth::user() == "") {
        header('location:' . url('/login'));
        exit();
    }

    $active_style = DB::table('sm_styles')->where('is_active', 1)->first();
    $styles = DB::table('sm_styles')->where('school_id',1)->get();
    $generalSetting = $config = DB::table('sm_general_settings')->first();
    $schoolSetting = $school_config = DB::table('sm_general_settings')->where('school_id',Auth::user()->school_id)->first();
    $system_date_foramt = App\SmDateFormat::find($config->date_format_id);
    $dashboard_background = DB::table('sm_background_settings')->where([['is_default', 1], ['title', 'Dashboard Background']])->first();


    if (!empty(Auth::user())) {

        $ROLE_ID = Auth::user()->role_id;

        if ($ROLE_ID != 1  && $ROLE_ID != 10) {
            $notifications = SmNotification::notifications();

        } else {
            $notifications = [];
        }
        if ($ROLE_ID == 1) {
            $notifications = SmNotification::notifications();

        }

        if (Auth::user()->role_id == 3) {

            $childrens = SmParent::myChildrens();
        }
    }



    if ($ROLE_ID == 2) {

        $LoginUser = App\SmStudent::where('user_id', Auth::user()->id)->first();
        if (empty($LoginUser)) {
            $profile = 'public/backEnd/img/admin/message-thumb.png';
        } else {
            $profile = $LoginUser->student_photo;
        }
        } elseif ($ROLE_ID == 3) {
        $LoginUser = App\SmParent::where('user_id', Auth::user()->id)->first();
        if (empty($LoginUser)) {
            $profile = 'public/backEnd/img/admin/message-thumb.png';
        } else {
            $profile = $LoginUser->fathers_photo;
        }
        } else {
        $LoginUser = App\SmStaff::where('user_id', Auth::user()->id)->first();

        if (empty($LoginUser)) {
            $profile = 'public/backEnd/img/admin/message-thumb.png';
        } else {
            $profile = $LoginUser->staff_photo;
        }
}
    if (empty($dashboard_background)) {
        $css = "background: url('/public/backEnd/img/body-bg.jpg')  no-repeat center; background-size: cover; ";
    } else {
        if (!empty($dashboard_background->image)) {
            $css = "background: url('" . url($dashboard_background->image) . "')  no-repeat center; background-size: cover; ";
        } else {
            $css = "background:" . $dashboard_background->color;
        }
    }


    if (!empty($school_config->logo)) {
        $logo = $school_config->logo;
    } else {
        $logo = 'public/uploads/settings/logo.png';
    }

    if (!empty($school_config->favicon)) {
        $fav = $school_config->favicon;
    } else {
        $fav = 'public/backEnd/img/favicon.png';
    }
    if (!empty($school_config->site_title)) {
        $site_title = $school_config->site_title;
    } else {
        $site_title = 'School Management System';
    }
    if (!empty($school_config->school_name)) {
        $school_name = $school_config->school_name;
    } else {
        $school_name = 'Infix Edu ERP';
    }

    //DATE FORMAT
    $DATE_FORMAT =  $system_date_foramt->format;

    $ttl_rtl = isset($config->ttl_rtl) ? $config->ttl_rtl : 2;

    $selected_language=App\SmLanguage::where('active_status',1)->first();
    if ($selected_language) {
        $language_universal= $selected_language->language_universal;
    } else {
        $language_universal='en';
    }

?><!DOCTYPE html>

<html lang="<?php echo e(app()->getLocale()); ?>" <?php if(isset ($ttl_rtl ) && $ttl_rtl ==1): ?> dir="rtl" class="rtl" <?php endif; ?> >
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="icon" href="<?php echo e(url('/')); ?>/<?php echo e(isset($fav)?$fav:''); ?>" type="image/png"/>
    <title><?php echo e($school_name); ?> | <?php echo e($site_title); ?></title>
    <meta name="_token" content="<?php echo csrf_token(); ?>"/>
    <!-- Bootstrap CSS -->

    <?php if(isset ($ttl_rtl ) && $ttl_rtl ==1): ?>
        <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/css/rtl/bootstrap.min.css"/>
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/bootstrap.css"/>
    <?php endif; ?>


    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/jquery-ui.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/jquery.data-tables.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/responsive.dataTables.min.css">


    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/themify-icons.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/flaticon.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/nice-select.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/magnific-popup.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/fastselect.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/toastr.min.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/js/select2/select2.css"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/vendors/css/fullcalendar.min.css">
    
    <?php echo $__env->yieldContent('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/css/loade.css')); ?>"/>
    <?php if(isset ($ttl_rtl ) && $ttl_rtl ==1): ?>
        <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/css/rtl/style.css"/>
        <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/css/rtl/infix.css"/>
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/css/<?php echo e(@$active_style->path_main_style); ?>"/>
        <link rel="stylesheet" href="<?php echo e(asset('public/backEnd/')); ?>/css/<?php echo e(@$active_style->path_infix_style); ?>"/>
    <?php endif; ?>
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover { background: <?php echo e($active_style->primary_color2); ?> !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: <?php echo e($active_style->primary_color2); ?>  !important; }
        ::placeholder { color: <?php echo e($active_style->primary_color); ?>  !important; }
        .datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom{ z-index: 99999999999 !important; background: #fff !important;        }
        .input-effect { float: left;  width: 100%; }
    </style>

    <script type="text/javascript">
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : (event.keyCode);
            if (charCode > 31 && (charCode < 48 || charCode > 57)){
                return false;
            }
            return true;
        }
    </script>

</head>
<body class="admin"
      style=" <?php if($active_style->id==1): ?> <?php echo e($css); ?> <?php else: ?> background:<?php echo e($active_style->dashboardbackground); ?> !important; <?php endif; ?> ">

        <?php
            // $tt = file_get_contents(url('/').'/'.$generalSetting->logo);
             $tt='';
        ?>
        <input type="text" hidden value="<?php echo e(base64_encode($tt)); ?>" id="logo_img">
        <input type="text" hidden value="<?php echo e($generalSetting->school_name); ?>" id="logo_title">
    <div class="main-wrapper" style="min-height: 600px">
    <!-- Sidebar  -->

    <?php if(App\SmGeneralSettings::isModule('SaasSubscription')== TRUE): ?>


        <?php if(\Modules\SaasSubscription\Entities\SmPackagePlan::isSubscriptionAutheticate()): ?>

            <?php echo $__env->make('backEnd.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php else: ?>

            <?php echo $__env->make('saassubscription::menu.SaasSubscriptionSchool_trial', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php endif; ?>

    <?php else: ?>

         <?php echo $__env->make('backEnd.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php endif; ?>

    <!-- Page Content  -->
    <div id="main-content">

    <?php echo $__env->make('backEnd.partials.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH E:\Server3\htdocs\spondon\infixedu_lv7.0_rv_4.5\resources\views/backEnd/partials/header.blade.php ENDPATH**/ ?>