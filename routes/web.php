<?php

use MacsiDigital\Zoom\Facades\Zoom;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

Route::get('sendmail', function () {
    return Zoom::user()->where('status', 'active')->get()->toArray();
    // $data[] = 'dcfs';
    // Mail::send('backEnd.studentInformation.user_credential', compact('data'), function ($message) {
    //    // $settings = SmEmailSetting::find(1);
    //     $email = 'spn5@spondonit.com';
    //     $Schoolname = 'fdgfdg';
    //     $message->to('bablupub@gmail.com', $Schoolname)->subject('Login Credentials');
    //     $message->from($email, $Schoolname);
    // });
    //  return 'success';
});





Route::group(['middleware' => ['XSS']], function () {
    Route::get('update-system', 'SmSystemSettingController@UpdateSystem');
    Route::get('/verified-code', 'InstallController@verifiedCode');
    Route::post('system-verify', 'InstallController@systemVerifyPurchases')->name('systemVerifyPurchases');
    Route::get('module-verify', 'InstallController@ModuleVerify')->name('ModuleVerify');
    Route::post('module-verify-purchase', 'InstallController@ModuleverifyPurchases')->name('ModuleverifyPurchases');
    Route::get('institution-privacy-policy', 'SmFrontendController@institutionPrivacyPolicy');
    Route::get('institution-terms-service', 'SmFrontendController@institutionTermServices');

    if (Config::get('app.app_sync')) {
        Route::get('/',  'SmFrontendController@index');
        // Route::get('/', 'LandingController@index');
    } else {
        Route::get('/',  'SmFrontendController@index');
    }

    Route::get('db-upgrade',  'SmSystemSettingController@DbUpgrade');

    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::get('home',  'SmFrontendController@index');
    Route::get('about', 'SmFrontendController@about');
    Route::get('course', 'SmFrontendController@course');
    Route::get('course-Details/{id}', 'SmFrontendController@courseDetails')->where('id', '[0-9]+');
    Route::get('news-page', 'SmFrontendController@newsPage');
    Route::get('news-details/{id}', 'SmFrontendController@newsDetails')->where('id', '[0-9]+');
    Route::get('contact', 'SmFrontendController@contact');

    //USER REGISTER SECTION
    Route::get('register', 'SmFrontendController@register');
    Route::post('register', 'SmFrontendController@customer_register');


    Route::get('error-404', function () {
        return view('auth.error');
    })->name('error-404');
    Route::get('notification-api', 'SmSystemSettingController@notificationApi');
    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
     */


    /* ::::::::::::::::::::::::: START SEARCH ROUTES :::::::::::::::::::::::::: */

    Route::get('moduleAddOnsEnable/{name}', 'SmAddOnsController@moduleAddOnsEnable');
    Route::post('/search', 'SmSearchController@search')->name('search');

    /* ::::::::::::::::::::::::: START SEARCH ROUTES :::::::::::::::::::::::::: */


    Route::group(['middleware' => ['CheckUserMiddleware']], function () {





        Route::get('login', 'Auth\LoginController@loginFormTwo')->name('login');  // for demo version
        //Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');   //for codecanoyon

        Route::post('login', 'Auth\LoginController@login')->name('login');

        //forget password
        Route::get('recovery/passord', 'SmAuthController@recoveryPassord');

        Route::post('email/verify', 'SmAuthController@emailVerify');

        Route::get('/reset/password/{email}/{code}', 'SmAuthController@resetEmailConfirtmation');

        Route::post('/store/new/password', 'SmAuthController@storeNewPassword');

        Route::get('login-2', 'Auth\LoginController@loginFormTwo');

        Route::get('news', 'SmSystemSettingController@news');
    });

    Route::get('/after-login', 'HomeController@dashboard');
    Route::get('/dashboard', 'HomeController@dashboard');
    Route::get('ajax-get-login-access', 'SmAuthController@getLoginAccess');

    // Auth::routes();

    // Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    // Route::post('register', 'Auth\RegisterController@register');

    Route::get('/after-login', 'HomeController@dashboard');

    Route::get('/dashboard', 'HomeController@dashboard');


    Route::get('view/single/notification/{id}', 'SmNotificationController@viewSingleNotification')->where('id', '[0-9]+');

    Route::get('view/all/notification/{id}', 'SmNotificationController@viewAllNotification')->where('id', '[0-9]+');
    Route::get('notification-show/{id}', 'SmNotificationController@udpateNotification');

    Route::get('view/notice/{id}', 'HomeController@viewNotice')->where('id', '[0-9]+')->where('id', '[0-9]+');
    // update password

    Route::get('change-password', 'HomeController@updatePassowrd');
    Route::post('admin-change-password', 'HomeController@updatePassowrdStore'); //iiitPro Version
    // Route::post('change-password', 'HomeController@updatePassowrdStore'); //iiitPro Version
    // Route::post('change-password', 'HomeController@dashboard'); //iiitPro Version
    Route::get('download-uploaded-content/{id}/{student_id}', 'Student\SmStudentPanelController@downloadHomeWorkContent');

    Route::get('class-routine/print/{class_id}/{section_id}',  'SmClassRoutineNewController@classRoutinePrint');



    Route::post('/pay-with-paystack', 'Student\SmFeesController@redirectToGateway')->name('pay-with-paystack');

    Route::get('/payment/callback', 'Student\SmFeesController@handleGatewayCallback');

    //customer panel

    Route::group(['middleware' => ['CustomerMiddleware']], function () {
        Route::get('customer-dashboard', ['as' => 'customer_dashboard', 'uses' => 'Customer\SmCustomerPanelController@customerDashboard']);
        Route::get('customer-purchases', 'Customer\SmCustomerPanelController@customerPurchases');
    });
    Route::get('student-transport-view-modal/{r_id}/{v_id}', ['as' => 'student_transport_view_modal', 'uses' => 'Student\SmStudentPanelController@studentTransportViewModal']);




    //Install for Demo
    Route::post('/verified-code', 'InstallController@verifiedCodeStore');


    Route::get('install', 'InstallController@index');
    Route::get('system-config', 'InstallController@verify')->name('system.config');
    Route::get('Moduleverify/{name}', 'InstallController@Moduleverify')->name('Moduleverify');
    Route::get('check-purchase-verification', 'InstallController@CheckPurchaseVerificationPage');
    Route::post('check-verified-input', 'InstallController@CheckVerifiedInput');
    Route::get('check-environment', 'InstallController@checkEnvironmentPage');
    Route::any('checking-environment', 'InstallController@checkEnvironment');
    Route::get('system-setup-page', 'InstallController@systemSetupPage');
    Route::post('confirm-installing', 'InstallController@confirmInstalling');
    Route::get('confirmation', 'InstallController@confirmation');



    //for localization
    Route::get('locale/{locale}', 'SmSystemSettingController@changeLocale');
    Route::get('change-language/{id}', 'SmSystemSettingController@changeLanguage');


    /************* Verify Routes *************/
    Route::get('verify/', 'VerifyController@index');
    Route::put('/verify/storePurchasecode/{id}', 'VerifyController@storePurchasecode');
    Route::put('/verify/storePurchasecode/{id}', 'VerifyController@storePurchasecode');


    /************* Front End Settings *************/
    Route::get('/news', 'SmNewsController@index')->name('news_index');
    Route::post('/news-store', 'SmNewsController@store')->name('store_news');
    Route::post('/news-update', 'SmNewsController@update')->name('update_news');
    Route::get('newsDetails/{id}', 'SmNewsController@newsDetails');
    Route::get('for-delete-news/{id}', 'SmNewsController@forDeleteNews');
    Route::get('delete-news/{id}', 'SmNewsController@delete');
    Route::get('edit-news/{id}', 'SmNewsController@edit');


    Route::get('news-category', 'SmNewsController@newsCategory');
    Route::post('/news-category-store', 'SmNewsController@storeCategory')->name('store_news_category');
    Route::post('/news-category-update', 'SmNewsController@updateCategory')->name('update_news_category');
    Route::get('for-delete-news-category/{id}', 'SmNewsController@forDeleteNewsCategory');
    Route::get('delete-news-category/{id}', 'SmNewsController@deleteCategory');
    Route::get('edit-news-category/{id}', 'SmNewsController@editCategory');


    //For course module
    Route::get('course-list', 'SmCourseController@index');
    Route::post('/course-store', 'SmCourseController@store')->name('store_course');
    Route::post('/course-update', 'SmCourseController@update')->name('update_course');
    Route::get('for-delete-course/{id}', 'SmCourseController@forDeleteCourse');
    Route::get('delete-course/{id}', 'SmCourseController@destroy');
    Route::get('edit-course/{id}', 'SmCourseController@edit');
    Route::get('course-Details-admin/{id}', 'SmCourseController@courseDetails');


    //for testimonial

    Route::get('/testimonial', 'SmTestimonialController@index')->name('testimonial_index');
    Route::post('/testimonial-store', 'SmTestimonialController@store')->name('store_testimonial');
    Route::post('/testimonial-update', 'SmTestimonialController@update')->name('update_testimonial');
    Route::get('testimonial-details/{id}', 'SmTestimonialController@testimonialDetails');
    Route::get('for-delete-testimonial/{id}', 'SmTestimonialController@forDeleteTestimonial');
    Route::get('delete-testimonial/{id}', 'SmTestimonialController@delete');
    Route::get('edit-testimonial/{id}', 'SmTestimonialController@edit');


    // Contact us
    Route::get('contact-page', 'SmFrontendController@conpactPage');
    Route::get('contact-page/edit', 'SmFrontendController@contactPageEdit');
    Route::post('contact-page/update', 'SmFrontendController@contactPageStore');

    // contact message
    Route::get('contact-message', 'SmFrontendController@contactMessage');


    // News route start
    Route::get('news-heading-update', 'SmFrontendController@newsHeading');
    Route::post('news-heading-update', 'SmFrontendController@newsHeadingUpdate');


    // Course route start
    Route::get('course-heading-update', 'SmFrontendController@courseHeading');
    Route::post('course-heading-update', 'SmFrontendController@courseHeadingUpdate');


    Route::get('about-page', 'SmFrontendController@aboutPage');
    Route::get('about-page/edit', 'SmFrontendController@aboutPageEdit');
    Route::post('about-page/update', 'SmFrontendController@aboutPageStore');

    Route::post('send-message', 'SmFrontendController@sendMessage');


    Route::get('custom-links', 'SmSystemSettingController@customLinks');
    Route::post('custom-links-update', 'SmSystemSettingController@customLinksUpdate');


    // admin-home-page
    Route::get('admin-home-page', 'SmSystemSettingController@homePageBackend');
    Route::post('admin-home-page-update', 'SmSystemSettingController@homePageUpdate');


    // social media
    Route::get('social-media', 'SmFrontendController@socialMedia');
    Route::post('social-media-store', 'SmFrontendController@socialMediaStore');
    Route::get('social-media-edit/{id}', 'SmFrontendController@socialMediaEdit');
    Route::post('social-media-update', 'SmFrontendController@socialMediaUpdate');
    Route::get('social-media-delete/{id}', 'SmFrontendController@socialMediaDelete');


    // admin-home-page
    Route::get('admin-data-delete', 'SmSystemSettingController@tableEmpty');
    Route::post('database-delete', 'SmSystemSettingController@databaseDelete');
    Route::get('database-restore', 'SmSystemSettingController@databaseRestory');
    Route::post('database-restore', 'SmSystemSettingController@databaseRestory');

    Route::get('change-website-btn-status', 'SmSystemSettingController@changeWebsiteBtnStatus');
    Route::get('change-dashboard-btn-status', 'SmSystemSettingController@changeDashboardBtnStatus');
    Route::get('change-report-btn-status', 'SmSystemSettingController@changeReportBtnStatus');

    Route::get('change-style-btn-status', 'SmSystemSettingController@changeStyleBtnStatus');
    Route::get('change-ltl_rtl-btn-status', 'SmSystemSettingController@changeLtlRtlBtnStatus');
    Route::get('change-language-btn-status', 'SmSystemSettingController@changeLanguageBtnStatus');
    Route::post('update-website-url', 'SmSystemSettingController@updateWebsiteUrl');


    Route::get('update-created-date', 'SmSystemSettingController@updateCreatedDate');


    // manage currency

    Route::get('manage-currency', 'SmSystemSettingController@manageCurrency');
    Route::post('currency-store', 'SmSystemSettingController@storeCurrency');
    Route::post('currency-update', 'SmSystemSettingController@storeCurrencyUpdate');
    Route::get('manage-currency/edit/{id}', 'SmSystemSettingController@manageCurrencyEdit')->name('currency_edit');
    Route::get('manage-currency/delete/{id}', 'SmSystemSettingController@manageCurrencyDelete')->name('currency_delete');
    Route::get('system-destroyed-by-authorized', 'SmSystemSettingController@systemDestroyedByAuthorized')->name('systemDestroyedByAuthorized');
});