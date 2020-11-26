<style>
    #livesearch a{  text-align: left; display: block; }
    .languageChange .list{    padding-top: 40px !important;}
    .infix_theme_rtl .list{    padding-top: 40px !important;}
    .infix_theme_style .list{    padding-top: 40px !important;}
    p.date {
    font-size: 11px;
}

.mr-10.text-right.bell_time {
    text-align: right !;
    margin-right: 0;
    padding-right: 0;
    position: relative;
    left: 22px;
}

.profile_single_notification i {
    margin-bottom: 20px;
}

.profile_single_notification span.ti-bell {
    font-size: 12px;
    margin-right: 5px;
    display: inline-block;
    overflow: hidden;
}

/* .dropdown-item:last-child .profile_single_notification {background: #;background: #000;} */

.profile_single_notification.d-flex.justify-content-between.align-items-center {
    /* background: red; */
    margin-bottom: 10px !important;
    margin-top: 10px !important;
}
.admin .navbar .right-navbar .dropdown .message.notification_msg {
    font-size: 12px;
    max-width: 127px;
     max-height: auto !important;
    line-height: 1.2;
     overflow: visible !important;
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
    line-height: 1.4;
        white-space: normal;

}
.admin .navbar .right-navbar .dropdown .message {
    max-height: initial !important;
}

/* sctolled_notify  */
.sctolled_notify {
    max-height: 300px;
    overflow: auto;
}
</style>

@php
    $coltroller_role=1;
@endphp
<nav class="navbar navbar-expand-lg up_navbar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class='up_dash_menu'>
                    <button type="button" id="sidebarCollapse" class="btn d-lg-none nav_icon">
                        <i class="ti-more"></i>
                    </button>

                    <ul class="nav navbar-nav mr-auto search-bar">
                        <li class="">
                            <div class="input-group" id="serching">
                            <span>
                                <i class="ti-search" aria-hidden="true" id="search-icon"></i>
                            </span>
                                <input type="text" class="form-control primary-input input-left-icon" placeholder="Search"
                                       id="search" onkeyup="showResult(this.value)"/>
                                <span class="focus-border"></span>
                            </div>
                            <div id="livesearch"></div>
                        </li>
                    </ul>

                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto nav_icon" type="button"
                            data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false"
                            aria-label="Toggle navigation">
                        {{-- <i class="ti-menu"></i> --}}
                        <div class="client_thumb_btn">
                            <img class="client_img" src="{{ file_exists(@$profile) ? asset($profile) : asset('public/uploads/staff/demo/staff.jpg') }}" alt="">
                        </div>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <ul class="nav navbar-nav mr-auto nav-buttons flex-sm-row">
                            @php
                               $settings= App\SmGeneralSettings::first();
                            @endphp

                                @if ( $settings->website_btn==1)
                                     <li class="nav-item">
                                        <a class="primary-btn white mr-10" href="{{url('/')}}/home">@lang('lang.website')</a>
                                    </li>
                                @endif


                                  @if ( $settings->dashboard_btn==1)

                                        @if (Auth::user()->role_id == $coltroller_role)
                                        <li class="nav-item">
                                            <a class="primary-btn white mr-10"
                                            href="{{url('/admin-dashboard')}}">@lang('lang.dashboard')</a>
                                        </li>
                                        @endif
                                  @endif
                                  @if ( $settings->report_btn==1)
                                  @if (Auth::user()->role_id == $coltroller_role)
                                  <li class="nav-item">
                                      <a class="primary-btn white" href="{{url('/student-report')}}">@lang('lang.reports')</a>
                                  </li>
                                  @endif
                              @endif


                    </ul>
                    @if(@$styles && Auth::user()->role_id == 1 && Auth::user()->is_administrator=='yes')
                        <style>
                            .nice-select.open .list { min-width: 200px;  left: 0;  padding: 5px; }
                            .nice-select .nice-select-search { min-width: 190px; }
                        </style>
                        @if ($settings->style_btn==1)
                        <ul class="nav navbar-nav mr-auto nav-setting flex-sm-row d-none d-lg-block colortheme">
                            <li class="nav-item active">
                                <select class="niceSelect infix_theme_style" id="infix_theme_style">
                                    <option data-display="@lang('lang.select') @lang('lang.style')" value="0">@lang('lang.select') @lang('lang.style')</option>
                                    @foreach($styles as $style)

                                        <option value="{{$style->id}}" {{$style->is_active == 1?'selected':''}}>{{$style->style_name}}</option>

                                    @endforeach
                                </select>
                            </li>
                        </ul>
                        @endif
                        <ul class="nav navbar-nav mr-auto nav-setting flex-sm-row d-none d-lg-block colortheme">
                            <li class="nav-item active">
                                <select class="niceSelect infix_session" id="infix_session">
                                    <option data-display="Academic Year" value="0">Academic Year</option>
                                    @php $academic_years = App\SmAcademicYear::where('active_status',1)->where('school_id', Auth::user()->school_id )->get(); @endphp
                                    @foreach ($academic_years as $academic_year)
                                        <option value="{{ @$academic_year->id }}" {{\App\YearCheck::getAcademicId()==@$academic_year->id?'selected':''}}>{{ @$academic_year->year }} [{{@$academic_year->title}}]</option>
                                    @endforeach

                                </select>
                            </li>
                        </ul>
                       {{-- {{dd(Auth::user())}} --}}
                        @if ($settings->ltl_rtl_btn==1 && Auth::user()->role_id==1 && Auth::user()->is_administrator=='yes')

                        <ul class="nav navbar-nav mr-auto nav-setting flex-sm-row d-none d-lg-block colortheme">
                            <li class="nav-item active">
                                <select class="niceSelect infix_theme_rtl" id="infix_theme_rtl">
                                    <option data-display="@lang('lang.select') @lang('lang.alignment')" value="0">@lang('lang.select') @lang('lang.alignment')</option>
                                    @php
                                    $school_config = App\SmGeneralSettings::where('school_id',Auth::user()->school_id)->first();
                                    $is_rtl = $school_config->ttl_rtl;

                                    @endphp
                                        <option value="2" {{$is_rtl==2?'selected':''}}>@lang('lang.ltl')</option>
                                        <option value="1" {{$is_rtl==1?'selected':''}}>@lang('lang.rtl')</option>
                                </select>
                            </li>
                        </ul>

                        @endif
                        @endif
                <!-- Start Right Navbar -->
                    <ul class="nav navbar-nav right-navbar">
                        {{-- {{dd($settings)}} --}}
                        @if ($settings->Saas==1)
                           @php $language_controller=['1']; @endphp
                        @else
                            @php $language_controller=['1']; @endphp
                        @endif
                            @if (@Auth::user()->role_id==1 && Auth::user()->is_administrator=='yes')

                                @if($settings->lang_btn==1)
                                <li class="nav-item">
                                    <select class="niceSelect languageChange" name="languageChange" id="languageChange">
                                        <option data-display="@lang('lang.select') @lang('lang.language')" value="0">@lang('lang.select') @lang('lang.language')</option>
                                        @php
                                            $languages=DB::table('sm_languages')->where('school_id',Auth::user()->school_id)->get();
                                        @endphp
                                        @foreach($languages as $lang)
                                            <option data-display="{{$lang->native}}" value="{{ $lang->language_universal}}" {{$lang->active_status == 1? 'selected':''}}>{{$lang->native}}</option>
                                        @endforeach
                                    </select>
                                </li>
                                @endif
                        @endif
                        <li class="nav-item notification-area  d-none d-lg-block">
                            <div class="dropdown">
                                <button type="button" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="badge">{{count($notifications) < 10? count($notifications):$notifications->count()}}</span>
                                    <span class="flaticon-notification"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <div class="white-box">
                                        <div class="p-h-20">
                                            <p class="notification">@lang('lang.you_have')
                                                <span>{{count($notifications) < 10? count($notifications):count($notifications)}} @lang('lang.new')</span>
                                                @lang('lang.notification')</p>
                                        </div>
                                        <div class="sctolled_notify">
                                        @foreach($notifications as $notification)
                                       
                                            <a class="dropdown-item pos-re"
                                               href="{{ url('notification-show/'.$notification->id) }}">
                                               {{-- href="{{ @$notification->url ? url($notification->url) : url('view/single/notification/'.$notification->id)}}"> --}}
                                                
                                                    <div class="profile_single_notification d-flex justify-content-between align-items-center">
                                                        <div class="mr-30">
                                                            <p class="message notification_msg"> <span class="ti-bell"></span>{{$notification->message}}</p>
                                                        </div>
                                                        <div class="text-right bell_time">
                                                            <p class="time text-uppercase">{{date("h.i a", strtotime($notification->created_at))}}</p>
                                                            <p class="date">
                                                                {{$notification->date != ""? App\SmGeneralSettings::DateConvater($notification->date):''}}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="d-flex">
                                                        <div class="col-6">
                                                            <div class="mr-30">
                                                                <p class="message"> <span class="ti-bell"></span>{{$notification->message}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mr-10 text-right bell_time">
                                                                <p class="time text-uppercase">{{date("h.i a", strtotime($notification->created_at))}}</p>
                                                                <p class="date">
                                                                    {{$notification->date != ""? App\SmGeneralSettings::DateConvater($notification->date):''}}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex align-items-center ml-10">
                                                            <div class="row">
                                                                <div class="col-lg-8">
                                                                    <div class="mr-30">
                                                                        <p class="message">{{$notification->message}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="mr-10 text-right bell_time">
                                                                        <p class="time text-uppercase">{{date("h.i a", strtotime($notification->created_at))}}</p>
                                                                        <p class="date">
                                                                            {{$notification->date != ""? App\SmGeneralSettings::DateConvater($notification->date):''}}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </a>
                                                
                                            @endforeach
                                            </div>
                                            <a href="{{url('view/all/notification/'.Auth()->user()->id)}}"
                                               class="primary-btn text-center text-uppercase mark-all-as-read">
                                                @lang('lang.mark_all_as_read')
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item setting-area">
                                <div class="dropdown">
                                    <button type="button" class="dropdown-toggle" data-toggle="dropdown">
                                        <img class="rounded-circle" src="{{ file_exists(@$profile) ? asset($profile) : asset('public/uploads/staff/demo/staff.jpg') }}" alt="">
                                    </button>
                                    <div class="dropdown-menu profile-box">
                                        <div class="white-box">
                                            <a class="dropdown-item" href="#">
                                                <div class="">
                                                    <div class="d-flex">

                                                        <img class="client_img"
                                                             src="{{ file_exists(@$profile) ? asset($profile) : asset('public/uploads/staff/demo/staff.jpg') }} "
                                                             alt="">
                                                        <div class="d-flex ml-10">
                                                            <div class="">
                                                                <h5 class="name text-uppercase">{{Auth::user()->full_name}}</h5>
                                                                <p class="message">{{Auth::user()->email}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>

                                            <ul class="list-unstyled">
                                                <li>
                                                    @if(Auth::user()->role_id == "2")
                                                        <a href="{{ url('student-profile')}}">
                                                            <span class="ti-user"></span>
                                                            @lang('lang.view_profile')
                                                        </a>
                                                    {{-- @elseif(Auth::user()->role_id == "10")
                                                        <a href="#">
                                                            <span class="ti-user"></span>
                                                            @lang('lang.view_profile')
                                                        </a> --}}

                                                    @elseif(Auth::user()->role_id != "3")
                                                        <a href="{{route('viewStaff', Auth::user()->staff->id)}}">
                                                            <span class="ti-user"></span>
                                                            @lang('lang.view_profile')
                                                        </a>
                                                    @endif
                                                </li>

                                                @if(App\SmGeneralSettings::isModule('Saas')== TRUE && Auth::user()->is_administrator=="yes" && Auth::user()->role_id==1)

                                                    <li>
                                                        <a href="{{url('view-as-superadmin')}}">
                                                            <span class="ti-key"></span>
                                                            @if(Session::get('isSchoolAdmin')==TRUE)
                                                                @lang('lang.view') as  @lang('lang.saas') @lang('lang.admin')
                                                            @else
                                                                @lang('lang.view') as  @lang('lang.school') @lang('lang.admin')
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endif

                                                <li>
                                                    <a href="{{url('change-password')}}">
                                                        <span class="ti-key"></span>
                                                        @lang('lang.password')
                                                    </a>
                                                </li>
                                                <li>

                                                    <a href="{{ Auth::user()->role_id == 2? route('student-logout'): route('logout')}}"
                                                       onclick="event.preventDefault();

                                                         document.getElementById('logout-form').submit();">
                                                        <span class="ti-unlock"></span>
                                                        logout
                                                    </a>

                                                    <form id="logout-form"
                                                          action="{{ Auth::user()->role_id == 2? route('student-logout'): route('logout') }}"
                                                          method="POST" style="display: none;">

                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <!-- End Right Navbar -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>


@section('script')


@endsection
