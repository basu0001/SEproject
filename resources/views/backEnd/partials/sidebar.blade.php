@php
    use App\SmGeneralSettings;
    $school_settings= SmGeneralSettings::where('school_id',Auth::user()->school_id)->first();
    if (Auth::user() == "") { header('location:' . url('/login')); exit(); }
    Session::put('permission', App\GlobalVariable::GlobarModuleLinks());
@endphp
<input type="hidden" name="url" id="url" value="{{url('/')}}">
<nav id="sidebar">
    <div class="sidebar-header update_sidebar">
        <a href="{{url('/')}}">
          <img  src="{{ file_exists(@$school_settings->logo) ? asset($school_settings->logo) : asset('public/uploads/settings/logo.png') }}" alt="logo">
        </a>
        <a id="close_sidebar" class="d-lg-none">
            <i class="ti-close"></i>
        </a>
    </div>

    {{-- {{ Auth::user()->role_id }} --}}
    <ul class="list-unstyled components">



          @if(Auth::user()->role_id != 2 && Auth::user()->role_id != 3 )
                @if(@in_array(1, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                    <li>
                        @if(SmGeneralSettings::isModule('Saas')== TRUE && Auth::user()->is_administrator=="yes" && Session::get('isSchoolAdmin')==FALSE && Auth::user()->role_id == 1)
                            <a href="{{url('superadmin-dashboard')}}" id="superadmin-dashboard">
                        @else
                            <a href="{{url('/admin-dashboard')}}" id="admin-dashboard">
                        @endif
                            <span class="flaticon-speedometer"></span>
                            @lang('lang.dashboard')
                        </a>
                    </li>
                @endif
            @endif


        @if(SmGeneralSettings::isModule('InfixBiometrics')== TRUE && Auth::user()->role_id == 1)
            @include('infixbiometrics::menu.InfixBiometrics')
        @endif

        {{-- Parent Registration Menu --}}
        @if(SmGeneralSettings::isModule('ParentRegistration')== TRUE && Auth::user()->is_administrator !="yes")
            @include('parentregistration::menu.ParentRegistration')
        @endif

        {{-- Saas Subscription Menu --}}
        @if(SmGeneralSettings::isModule('SaasSubscription')== TRUE && Auth::user()->is_administrator != "yes")
            @include('saassubscription::menu.SaasSubscriptionSchool')
        @endif

        {{-- Saas Module Menu --}}
        @if(SmGeneralSettings::isModule('Saas')== TRUE && Auth::user()->is_administrator=="yes" && Session::get('isSchoolAdmin')==FALSE && Auth::user()->role_id == 1 )
            @include('saas::menu.Saas')
        @else

            @if(Auth::user()->role_id != 2 && Auth::user()->role_id != 3 )

                {{-- admin_section --}}
                @if(@in_array(11, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuAdmin" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="flaticon-analytics"></span>
                            @lang('lang.admin_section')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuAdmin">
                            @if(@in_array(12, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('admission_query')}}">@lang('lang.admission_query')</a>
                                </li>
                            @endif
                            @if(@in_array(16, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('visitor')}}">@lang('lang.visitor_book') </a>
                                </li>
                            @endif
                            @if(@in_array(21, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('complaint')}}">@lang('lang.complaint')</a>
                                </li>
                            @endif
                            @if(@in_array(27, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('postal-receive')}}">@lang('lang.postal_receive')</a>
                                </li>
                            @endif
                            @if(@in_array(32, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('postal-dispatch')}}">@lang('lang.postal_dispatch')</a>
                                </li>
                            @endif
                            @if(@in_array(36, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('phone-call')}}">@lang('lang.phone_call_log')</a>
                                </li>
                            @endif
                            @if(@in_array(41, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('setup-admin')}}">@lang('lang.admin_setup')</a>
                                </li>
                            @endif
                            @if(@in_array(49, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('student-certificate')}}">@lang('lang.student_certificate')</a>
                                </li>
                            @endif
                            @if(@in_array(53, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('generate_certificate')}}">@lang('lang.generate_certificate')</a>
                                </li>
                            @endif
                            @if(@in_array(45, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('student-id-card')}}">@lang('lang.student_id_card')</a>
                                </li>
                            @endif
                            @if(@in_array(57, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('generate_id_card')}}">@lang('lang.generate_id_card')</a>
                                </li>
                            @endif
                        </ul>
                    </li>

                @endif


                {{-- student_information --}}
                @if(@in_array(61, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuStudent" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="flaticon-reading"></span>
                            @lang('lang.student_information')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuStudent">

                            @if(@in_array(71, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_category')}}"> @lang('lang.student_category')</a>
                                </li>
                            @endif
                            @if(@in_array(62, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                            <li>
                                <a href="{{route('student_admission')}}">@lang('lang.add') @lang('lang.student')</a>
                            </li>
                            @endif
                            {{-- @if(@in_array(64, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('student-admission')}}"> @lang('lang.add') @lang('lang.student')</a>
                                </li>
                            @endif --}}
                            @if(@in_array(64, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_list')}}"> @lang('lang.student_list')</a>
                                </li>
                            @endif


                            @if(@in_array(68, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_attendance')}}"> @lang('lang.student_attendance')</a>
                                </li>
                            @endif

                            @if(@in_array(70, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_attendance_report')}}"> @lang('lang.student_attendance_report')</a>
                                </li>
                            @endif

                            @if(@in_array(533, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('subject-wise-attendance')}}"> @lang('lang.subject') @lang('lang.wise') @lang('lang.attendance') </a>
                                </li>
                            @endif

                            @if(@in_array(535, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('subject-attendance-report')}}"> @lang('lang.subject_attendance_report') </a>
                                </li>
                            @endif

                            {{-- @if(@in_array(62, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_admission')}}">@lang('lang.student_admission')</a>
                                </li>
                            @endif --}}
                            @if(@in_array(76, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_group')}}">@lang('lang.student_group')</a>
                                </li>
                            @endif

                            @if(@in_array(81, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_promote')}}">@lang('lang.student_promote')</a>
                                </li>
                            @endif

                            @if(@in_array(83, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('disabled_student')}}">@lang('lang.disabled_student')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- academics --}}
                @if(@in_array(245, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuAcademic" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="flaticon-graduated-student"></span>
                            @lang('lang.academics')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuAcademic">


                            @if(@in_array(537, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('optional-subject')}}"> @lang('lang.optional') @lang('lang.subject') </a>
                                </li>
                            @endif
                            @if(@in_array(265, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('section')}}"> @lang('lang.section')</a>
                                </li>
                            @endif
                            @if(@in_array(261, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('class')}}"> @lang('lang.class')</a>
                                </li>
                            @endif
                            @if(@in_array(257, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('subject')}}"> @lang('lang.subjects')</a>
                                </li>
                            @endif
                            @if(@in_array(269, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('class-room')}}"> @lang('lang.class_room')</a>
                                </li>
                            @endif
                            @if(@in_array(273, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('class-time')}}"> @lang('lang.cl_ex_time_setup')</a>
                                </li>
                            @endif
                            @if(@in_array(253, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('assign-class-teacher')}}"> @lang('lang.assign_class_teacher')</a>
                                </li>
                            @endif
                            @if(@in_array(250, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('assign_subject')}}"> @lang('lang.assign_subject')</a>
                                </li>
                            @endif
                            @if(@in_array(246, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('class_routine_new')}}"> @lang('lang.class_routine')</a>

                                </li>
                            @endif

                        <!-- only for teacher -->
                            @if(Auth::user()->role_id == 4)
                                <li>
                                    <a href="{{url('view-teacher-routine')}}">@lang('lang.view') @lang('lang.class_routine')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                {{-- study_material --}}
                @if(@in_array(87, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuTeacher" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="flaticon-professor"></span>
                            @lang('lang.study_material')
                        </a>

                        <ul class="collapse list-unstyled" id="subMenuTeacher">
                            @if(@in_array(88, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('upload-content')}}"> @lang('lang.upload_content')</a>
                                </li>
                            @endif

                            @if(@in_array(92, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('assignment-list')}}">@lang('lang.assignment')</a>
                                </li>
                            @endif

                            {{-- @if(@in_array(96, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('study-metarial-list')}}">@lang('lang.study_material')</a>
                                </li>
                            @endif --}}

                            @if(@in_array(100, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('syllabus-list')}}">@lang('lang.syllabus')</a>
                                </li>
                            @endif

                            @if(@in_array(105, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('other-download-list')}}">@lang('lang.other_download')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{-- fees_collection --}}

                {{-- FeesCollection --}}
                @if(SmGeneralSettings::isModule('FeesCollection')== TRUE)
                    @include('feescollection::menu.FeesCollection')
                @else
                    @if(@in_array(108, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                        <li>
                            <a href="#subMenuFeesCollection" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle">
                                <span class="flaticon-wallet"></span>
                                @lang('lang.fees_collection')
                            </a>
                            <ul class="collapse list-unstyled" id="subMenuFeesCollection">
                                @if(@in_array(123, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{route('fees_group')}}"> @lang('lang.fees_group')</a>
                                    </li>
                                @endif
                                @if(@in_array(127, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{route('fees_type')}}"> @lang('lang.fees_type')</a>
                                    </li>
                                @endif
                                
                                @if(@in_array(118, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('fees-master')}}"> @lang('lang.fees_master')</a>
                                    </li>
                                @endif
                                @if(@in_array(131, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{route('fees_discount')}}"> @lang('lang.fees_discount')</a>
                                    </li>
                                @endif
                                @if(@in_array(109, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{route('collect_fees')}}"> @lang('lang.collect_fees')</a>
                                    </li>
                                @endif
                                @if(@in_array(113, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{route('search_fees_payment')}}"> @lang('lang.search_fees_payment')</a>
                                    </li>
                                @endif
                                @if(@in_array(116, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{route('search_fees_due')}}"> @lang('lang.search_fees_due')</a>
                                    </li>
                                @endif

                                <li>
                                    <a href="{{url('bank-payment-slip')}}"> @lang('lang.bank')  @lang('lang.payment')</a>
                                </li>


                                {{-- @if(@in_array(136, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{route('fees_forward')}}">@lang('lang.fees_forward')</a>
                                    </li>
                                @endif --}}
                            </ul>
                        </li>
                    @endif
                @endif
                {{-- check module enble or not --}}

                {{-- check module link permission --}}
                {{-- accounts --}}
                @if(@in_array(137, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuAccount" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="flaticon-accounting"></span>
                            @lang('lang.accounts')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuAccount">
                            @if(@in_array(148, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('chart-of-account')}}"> @lang('lang.chart_of_account')</a>
                                </li>
                            @endif

                            @if(@in_array(156, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('bank-account')}}"> @lang('lang.bank_account')</a>
                                </li>
                            @endif
                            @if(@in_array(139, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('add_income')}}"> @lang('lang.income')</a>
                                </li>
                            @endif
                            @if(@in_array(138, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('profit')}}"> @lang('lang.profit')</a>
                                </li>
                            @endif

                            @if(@in_array(143, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('add-expense')}}"> @lang('lang.expense')</a>
                                </li>
                            @endif
                            @if(@in_array(147, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('search_account')}}"> @lang('lang.search')</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif


                {{-- human_resource --}}
                @if(@in_array(160, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuHumanResource" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">
                            <span class="flaticon-consultation"></span>
                            @lang('lang.human_resource')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuHumanResource">
                            @if(@in_array(180, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('designation')}}"> @lang('lang.designation')</a>
                                </li>
                            @endif
                            @if(@in_array(184, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('department')}}"> @lang('lang.department')</a>
                                </li>
                            @endif
                            @if(@in_array(161, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('add-staff')}}"> @lang('lang.add')  @lang('lang.staff') </a>
                                </li>
                            @endif
                            @if(@in_array(161, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('staff_directory')}}"> @lang('lang.staff_directory')</a>
                                </li>
                            @endif
                            @if(@in_array(165, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('staff_attendance')}}"> @lang('lang.staff_attendance')</a>
                                </li>
                            @endif
                            @if(@in_array(169, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('staff_attendance_report')}}"> @lang('lang.staff_attendance_report')</a>
                                </li>
                            @endif


                            @if(@in_array(170, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('payroll')}}"> @lang('lang.payroll')</a>
                                </li>
                            @endif
                            @if(@in_array(178, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('payroll-report')}}"> @lang('lang.payroll_report')</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif



                {{-- leave --}}
                @if(@in_array(188, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuLeaveManagement" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">
                            <span class="flaticon-slumber"></span>
                            @lang('lang.leave')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuLeaveManagement">
                        @if(@in_array(203, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('leave-type')}}"> @lang('lang.leave_type')</a>
                                </li>
                            @endif
                            @if(@in_array(199, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('leave-define')}}"> @lang('lang.leave_define')</a>
                                </li>
                            @endif
                            @if(@in_array(189, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('approve-leave')}}">@lang('lang.approve_leave_request')</a>
                                </li>
                            @endif
                            @if(@in_array(196, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('pending-leave')}}">@lang('lang.pending_leave_request')</a>
                                </li>
                            @endif
                            @if(@in_array(193, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('apply-leave')}}">@lang('lang.apply_leave')</a>
                                </li>
                            @endif


                        </ul>
                    </li>
                @endif

                @if(@in_array(207, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuExam" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="flaticon-test"></span>
                            @lang('lang.examination')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuExam">
                        @if(@in_array(225, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('marks-grade')}}"> @lang('lang.marks_grade')</a>
                                </li>
                            @endif
                            @if(@in_array(208, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('exam-type')}}"> @lang('lang.add_exam_type')</a>
                                </li>
                            @endif
                            @if(@in_array(214, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('exam')}}"> @lang('lang.exam_setup')</a>
                                </li>
                            @endif


                            @if(@in_array(217, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('exam_schedule')}}"> @lang('lang.exam_schedule')</a>
                                </li>
                            @endif



                            @if(Auth::user()->role_id == 4 || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('exam_attendance')}}"> @lang('lang.exam_attendance')</a>
                                </li>
                            @endif

                            @if(Auth::user()->role_id == 4 || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('marks_register')}}"> @lang('lang.marks_register')</a>
                                </li>
                            @endif


                            @if(@in_array(229, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('send_marks_by_sms')}}"> @lang('lang.send_marks_by_sms')</a>
                                </li>
                            @endif
                            @if(@in_array(230, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('question-group')}}">@lang('lang.question_group')</a>
                                </li>
                            @endif
                            @if(@in_array(234, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('question-bank')}}">@lang('lang.question_bank')</a>
                                </li>
                            @endif
                            @if(@in_array(238, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('online-exam')}}">@lang('lang.online_exam')</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif



                @if(@in_array(277, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                    <li>
                        <a href="#subMenuHomework" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="flaticon-book"></span>
                            @lang('lang.home_work')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuHomework">
                            @if(@in_array(278, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('add-homeworks')}}"> @lang('lang.add_homework')</a>
                                </li>
                            @endif
                            @if(@in_array(280, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('homework-list')}}"> @lang('lang.homework_list')</a>
                                </li>
                            @endif
                            @if(@in_array(284, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('evaluation-report')}}"> @lang('lang.evaluation_report')</a>
                                </li>
                            @endif
                        </ul>
                    </li>

                @endif

                @if(@in_array(286, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuCommunicate" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="flaticon-email"></span>
                            @lang('lang.communicate')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuCommunicate">
                            @if(@in_array(287, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('notice-list')}}">@lang('lang.notice_board')</a>
                                </li>
                            @endif

                            @if (@$config->Saas == 1 && Auth::user()->is_administrator != "yes" )

                                <li>
                                    <a href="{{url('administrator-notice')}}">@lang('lang.administrator') @lang('lang.notice')</a>
                                </li>

                            @endif

                            {{--
                            @if(@in_array(73, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                            <li>
                                <a href="{{url('send-message')}}">@lang('lang.send_message')</a>
                            </li>
                            @endif
                            --}}
                            @if(@in_array(291, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('send-email-sms-view')}}">@lang('lang.send_email')</a>
                                </li>
                            @endif
                            @if(@in_array(293, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('email-sms-log')}}">@lang('lang.email_sms_log')</a>
                                </li>
                            @endif
                            @if(@in_array(294, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('event')}}">@lang('lang.event')</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{url('sms-template-new')}}">@lang('lang.sms_template')</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(@in_array(298, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenulibrary" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="flaticon-book-1"></span>
                            @lang('lang.library')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenulibrary">
                        @if(@in_array(304, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('book-category-list')}}"> @lang('lang.book_category')</a>
                                </li>
                            @endif

                            <li>
                                <a href="{{url('library-subject')}}"> @lang('lang.subject')</a>
                            </li>
                            @if(@in_array(299, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('add-book')}}"> @lang('lang.add_book')</a>
                                </li>
                            @endif
                            @if(@in_array(301, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('book-list')}}"> @lang('lang.book_list')</a>
                                </li>
                            @endif

                            @if(@in_array(308, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('library-member')}}"> @lang('lang.library_member')</a>
                                </li>
                            @endif
                            @if(@in_array(311, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('member-list')}}"> @lang('lang.member_list')</a>
                                </li>
                            @endif
                            @if(@in_array(314, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('all-issed-book')}}"> @lang('lang.all_issued_book')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif



                  <!--Inventory Module Start-->
                      {{-- <li>
                          <a href="#subMenuInventory" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                              <span class="flaticon-inventory"></span>
                              @lang('lang.inventory')
                          </a>
                          <ul class="collapse list-unstyled" id="subMenuInventory">
                              @if(@in_array(316, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                  <li>
                                      <a href="{{url('inventory/item-category')}}"> @lang('lang.item_category')</a>
                                  </li>
                                  @endif
                            @if(@in_array(320, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                  <li>
                                      <a href="{{url('inventory/item-list')}}"> @lang('lang.item_list')</a>
                                  </li>
                                  @endif
                                  @if(@in_array(324, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                  <li>
                                      <a href="{{url('inventory/item-store')}}"> @lang('lang.item_store')</a>
                                  </li>
                                  @endif
                                  @if(@in_array(328, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                  <li>
                                      <a href="{{url('inventory/suppliers')}}"> @lang('lang.supplier')</a>
                                  </li>
                                  @endif
                            @if(@in_array(332, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                  <li>
                                      <a href="{{url('inventory/item-receive')}}"> @lang('lang.item_receive')</a>
                                  </li>
                                  @endif
                                  @if(@in_array(334, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                  <li>
                                      <a href="{{url('inventory/item-receive-list')}}"> @lang('lang.item_receive_list')</a>
                                  </li>
                                  @endif
                                  @if(@in_array(339, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                  <li>
                                      <a href="{{url('inventory/item-sell-list')}}"> @lang('lang.item_sell')</a>
                                  </li>
                                  @endif
                            @if(@in_array(345, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                  <li>
                                      <a href="{{url('inventory/item-issue')}}"> @lang('lang.item_issue')</a>
                                  </li>

                              @endif
                          </ul>
                      </li> --}}
                      <!--Inventory Module End-->
                @if(@in_array(315, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuInventory" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="flaticon-inventory"></span>
                            @lang('lang.inventory')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuInventory">
                            @if(@in_array(316, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('item-category')}}"> @lang('lang.item_category')</a>
                                </li>
                            @endif
                            @if(@in_array(320, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('item-list')}}"> @lang('lang.item_list')</a>
                                </li>
                            @endif
                            @if(@in_array(324, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('item-store')}}"> @lang('lang.item_store')</a>
                                </li>
                            @endif
                            @if(@in_array(328, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('suppliers')}}"> @lang('lang.supplier')</a>
                                </li>
                            @endif
                            @if(@in_array(332, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('item-receive')}}"> @lang('lang.item_receive')</a>
                                </li>
                            @endif
                            @if(@in_array(334, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('item-receive-list')}}"> @lang('lang.item_receive_list')</a>
                                </li>
                            @endif
                            @if(@in_array(339, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('item-sell-list')}}"> @lang('lang.item_sell')</a>
                                </li>
                            @endif
                            @if(@in_array(345, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('item-issue')}}"> @lang('lang.item_issue')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(@in_array(348, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuTransport" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="flaticon-bus"></span>
                            @lang('lang.transport')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuTransport">
                            @if(@in_array(349, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('transport-route')}}"> @lang('lang.routes')</a>
                                </li>
                            @endif
                            @if(@in_array(353, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('vehicle')}}"> @lang('lang.vehicle')</a>
                                </li>
                            @endif
                            @if(@in_array(357, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('assign-vehicle')}}"> @lang('lang.assign_vehicle')</a>
                                </li>
                            @endif
                            @if(@in_array(361, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_transport_report')}}"> @lang('lang.student_transport_report')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(@in_array(362, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuDormitory" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="flaticon-hotel"></span>
                            @lang('lang.dormitory')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuDormitory">
                            @if(@in_array(371, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('room-type')}}"> @lang('lang.room_type')</a>
                                </li>
                            @endif
                            @if(@in_array(367, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('dormitory-list')}}"> @lang('lang.dormitory')</a>
                                </li>
                            @endif
                            @if(@in_array(363, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('room-list')}}"> @lang('lang.dormitory_rooms')</a>
                                </li>
                            @endif


                            @if(@in_array(375, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_dormitory_report')}}"> @lang('lang.student_dormitory_report')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(@in_array(376, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenusystemReports" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">
                            <span class="flaticon-analysis"></span>
                            @lang('lang.reports')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenusystemReports">
                            @if(@in_array(538, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{route('student_report')}}">@lang('lang.student_report')</a>
                                </li>
                            @endif
                            @if(@in_array(377, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('guardian_report')}}">@lang('lang.guardian_report')</a>
                                </li>
                            @endif
                            @if(@in_array(378, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_history')}}">@lang('lang.student_history')</a>
                                </li>
                            @endif
                            @if(@in_array(379, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_login_report')}}">@lang('lang.student_login_report')</a>
                                </li>
                            @endif
                            @if(@in_array(381, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('fees_statement')}}">@lang('lang.fees_statement')</a>
                                </li>
                            @endif
                            @if(@in_array(382, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('balance_fees_report')}}">@lang('lang.balance_fees_report')</a>
                                </li>
                            @endif
                            @if(@in_array(383, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('transaction_report')}}">@lang('lang.transaction_report')</a>
                                </li>
                            @endif
                            @if(@in_array(384, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('class_report')}}">@lang('lang.class_report')</a>
                                </li>
                            @endif
                            @if(@in_array(385, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('class_routine_report')}}">@lang('lang.class_routine')</a>
                                </li>
                            @endif
                            @if(@in_array(386, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('exam_routine_report')}}">@lang('lang.exam_routine')</a>
                                </li>
                            @endif
                            @if(@in_array(387, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('teacher_class_routine_report')}}">@lang('lang.teacher') @lang('lang.class_routine')</a>
                                </li>
                            @endif
                            @if(@in_array(388, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('merit_list_report')}}">@lang('lang.merit_list_report')</a>
                                </li>
                            @endif
                            @if(@in_array(388, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('custom-merit-list')}}">@lang('custom') @lang('lang.merit_list_report')</a>
                                </li>
                            @endif
                            @if(@in_array(389, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('online_exam_report')}}">@lang('lang.online_exam_report')</a>
                                </li>
                            @endif
                            @if(@in_array(390, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('mark_sheet_report_student')}}">@lang('lang.mark_sheet_report')</a>
                                </li>
                            @endif
                            @if(@in_array(391, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('tabulation_sheet_report')}}">@lang('lang.tabulation_sheet_report')</a>
                                </li>
                            @endif
                            @if(@in_array(392, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('progress_card_report')}}">@lang('lang.progress_card_report')</a>
                                </li>
                            @endif
                            @if(@in_array(392, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('custom-progress-card')}}"> @lang('lang.custom') @lang('lang.progress_card_report')</a>
                                </li>
                            @endif
                            @if(@in_array(393, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('student_fine_report')}}">@lang('lang.student_fine_report')</a>
                                </li>
                            @endif
                            @if(@in_array(394, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{route('user_log')}}">@lang('lang.user_log')</a>
                                </li>
                            @endif
                            @if(@in_array(539, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('previous-class-results')}}">@lang('lang.previous') @lang('lang.result') </a>
                                </li>
                            @endif
                            @if(@in_array(540, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('previous-record')}}">@lang('lang.previous') @lang('lang.record') </a>
                                </li>
                            @endif
                                {{-- New Client report start --}}


                        @if(Auth::user()->role_id == 1)
                            @if(SmGeneralSettings::isModule('ResultReports')== TRUE)
                                {{-- ResultReports --}}
                                <li>
                                    <a href="{{url('resultreports/cumulative-sheet-report')}}">@lang('lang.cumulative') @lang('lang.sheet') @lang('lang.report')</a>
                                </li>

                                <li>
                                    <a href="{{url('resultreports/continuous-assessment-report')}}">@lang('lang.contonuous') @lang('lang.assessment') @lang('lang.report')</a>
                                </li>
                                <li>

                                    <a href="{{url('resultreports/termly-academic-report')}}">@lang('lang.termly') @lang('lang.academic') @lang('lang.report')</a>
                                    </li>
                                <li>

                                    <a href="{{url('resultreports/academic-performance-report')}}">@lang('lang.academic') @lang('lang.performance') @lang('lang.report')</a>
                                    </li>
                                <li>

                                    <a href="{{url('resultreports/terminal-report-sheet')}}">@lang('lang.terminal') @lang('lang.report') @lang('lang.sheet')</a>
                                    </li>
                                <li>

                                    <a href="{{url('resultreports/continuous-assessment-sheet')}}">@lang('lang.continuous') @lang('lang.assessment') @lang('lang.sheet')</a>
                                    </li>
                                <li>

                                    <a href="{{url('resultreports/result-version-two')}}">@lang('lang.result') @lang('lang.version') V2</a>
                                    </li>
                                <li>

                                    <a href="{{url('resultreports/result-version-three')}}">@lang('lang.result') @lang('lang.version') V3</a>
                                </li>
                                {{--End New result result report --}}
                            @endif
                        @endif


                        </ul>
                    </li>
                @endif
                {{-- @if(App\SmGeneralSettings::isModule('Saas')== TRUE)

                @else

                @endif --}}

                @if(@in_array(398, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenusystemSettings" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">
                            <span class="flaticon-settings"></span>
                            @lang('lang.system_settings')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenusystemSettings">

                            {{-- @if(App\SmGeneralSettings::isModule('RazorPay')== TRUE && Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('razorpay/about')}}">Razorpay</a>
                                </li>
                            @endif --}}




                            {{-- @endif --}}
                            @if(App\SmGeneralSettings::isModule('Saas')== TRUE)
                                <li>
                                    <a href="{{url('school-general-settings')}}"> @lang('lang.general_settings')</a>
                                </li>
                            @else
                                @if(@in_array(405, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('general-settings')}}"> @lang('lang.general_settings')</a>
                                </li>
                            @endif
                            @endif




                            @if(@in_array(417, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('rolepermission/role')}}">@lang('lang.role')</a>
                                </li>
                            @endif


                            @if(@in_array(421, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('login-access-control')}}">@lang('lang.login_permission')</a>
                                </li>
                            @endif
                            @if(@in_array(424, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('optional-subject-setup')}}">@lang('lang.optional') @lang('lang.subject')</a>
                                </li>
                            @endif


                            @if(@in_array(121, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                {{--    <li> <a href="{{route('base_group')}}">@lang('lang.base_group')</a> </li>--}}
                            @endif
                            @php
                                $config = App\SmGeneralSettings::find(1);
                            @endphp


                            @if(@in_array(432, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('academic-year')}}">@lang('lang.academic_year')</a>
                                </li>
                            @endif
                            {{-- @if(@in_array(124, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('session')}}">@lang('lang.session')</a>
                                </li>
                            @endif --}}

                            @if(@in_array(436, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('custom-result-setting')}}">@lang('lang.custom_result_setting')</a>
                                </li>
                            @endif

                            @if(@in_array(440, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('holiday')}}">@lang('lang.holiday')</a>
                                </li>
                            @endif


                            @if(@in_array(448, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <li>
                                    <a href="{{url('weekend')}}">@lang('lang.weekend')</a>
                                </li>
                            @endif

                        @if(@in_array(152, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                            <li>
                                <a href="{{route('payment_method')}}"> @lang('lang.payment_method')</a>
                            </li>
                        @endif
                        @if(@in_array(412, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                            <li>
                                <a href="{{url('payment-method-settings')}}">@lang('lang.payment_method_settings')</a>
                            </li>
                        @endif





                    {{-- SAAS DISABLE --}}

                            @php
                                $config = App\SmGeneralSettings::find(1);
                            @endphp
                        @if(SmGeneralSettings::isModule('Saas')== FALSE   )

                        @include('backEnd/partials/without_saas_school_admin_menu')

                            @endif



                        </ul>
                    </li>
                @endif

                @if(App\SmGeneralSettings::isModule('Saas')== FALSE)
                    @if(@in_array(485, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                        <li>
                            <a href="#subMenusystemStyle" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle">
                                <span class="flaticon-settings"></span>
                                @lang('lang.style')
                            </a>
                            <ul class="collapse list-unstyled" id="subMenusystemStyle">
                                @if(in_array(486, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('background-setting')}}">@lang('lang.background_settings')</a>
                                    </li>
                                @endif
                                @if(in_array(490, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                    <li>
                                        <a href="{{url('color-style')}}">@lang('lang.color') @lang('lang.theme')</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif


            {{-- <!-- @if(in_array(20, $main_modules))

                @if(in_array(18, $modules) || Auth::user()->role_id == 1)
                    <li>
                        <a href="#subMenuApi" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">
                            <span class="flaticon-settings"></span>
                            @lang('lang.api')
                            @lang('lang.permission')
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuApi">
                            @if(in_array(117, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('api/permission')}}">@lang('lang.api') @lang('lang.permission') </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @endif --> --}}
                @if(App\SmGeneralSettings::isModule('Saas')== FALSE)
                    @if(@in_array(492, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                        <li>
                            <a href="#subMenufrontEndSettings" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle">
                                <span class="flaticon-software"></span>
                                @lang('lang.front_settings')
                            </a>
                            <ul class="collapse list-unstyled" id="subMenufrontEndSettings">
                                @if(@in_array(493, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('admin-home-page')}}"> @lang('lang.home_page') </a>
                                </li>
                                @endif
                                @if(@in_array(495, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('news')}}">@lang('lang.news_list')</a>
                                </li>
                                @endif

                                @if(@in_array(500, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('news-category')}}">@lang('lang.news') @lang('lang.category')</a>
                                </li>
                                @endif

                                @if(@in_array(504, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('testimonial')}}">@lang('lang.testimonial')</a>
                                </li>
                                @endif

                                @if(@in_array(509, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('course-list')}}">@lang('lang.course_list')</a>
                                </li>
                                @endif

                                @if(@in_array(514, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('contact-page')}}">@lang('lang.contact') @lang('lang.page') </a>
                                </li>
                                @endif

                                @if(@in_array(517, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('contact-message')}}">@lang('lang.contact') @lang('lang.message')</a>
                                </li>
                                @endif

                                @if(@in_array(520, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('about-page')}}"> @lang('lang.about_us') </a>
                                </li>
                                @endif

                                @if(@in_array(523, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('news-heading-update')}}">@lang('lang.news_heading')</a>
                                </li>
                                @endif

                                @if(@in_array(525, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('course-heading-update')}}">@lang('lang.course_heading')</a>
                                </li>
                                @endif

                                @if(@in_array(527, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('custom-links')}}"> @lang('lang.custom_links') </a>
                                </li>
                                @endif

                                @if(@in_array(529, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{url('social-media')}}"> @lang('lang.social_media') </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif

                @if(SmGeneralSettings::isModule('Saas')== TRUE  && Auth::user()->is_administrator != "yes" )

                    <li>
                        <a href="#Ticket" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="flaticon-settings"></span>
                            @lang('lang.ticket_system')
                        </a>
                        <ul class="collapse list-unstyled" id="Ticket">
                            <li><a href="{{ url('school/ticket-view') }}">@lang('lang.ticket_list')</a>
                            </li>
                        </ul>
                        </li>

                @endif
            @endif

            <!-- Student Panel -->
            @if(Auth::user()->role_id == 2)
                    <!-- Zoom Menu -->
                {{-- @if(SmGeneralSettings::isModule('Zoom') == TRUE)
                    @include('zoom::menu.Zoom')
                @endif --}}
                @include('backEnd/partials/student_sidebar')
            @endif
            <!-- End student panel -->

            <!-- Parents Panel Menu -->
            @if(Auth::user()->role_id == 3)
                @include('backEnd/partials/parents_sidebar')
            @endif
            <!-- End Parents Panel Menu -->

            <!-- Zoom Menu -->
            @if(SmGeneralSettings::isModule('Zoom') == TRUE)
                @include('zoom::menu.Zoom')
            @endif
            <!-- End Zoom Menu -->

        @endif
    </ul>
</nav>
