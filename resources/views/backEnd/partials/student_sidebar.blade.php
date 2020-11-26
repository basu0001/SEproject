
@if(@in_array(1, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="{{url('student-dashboard')}}">
            <span class="flaticon-resume"></span>
            @lang('lang.dashboard')
        </a>
    </li>
@endif
@if(@in_array(11, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="{{url('student-profile')}}">
            <span class="flaticon-resume"></span>
            @lang('lang.my_profile')
        </a>
    </li>
@endif
@if(@in_array(20, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="#subMenuStudentFeesCollection" data-toggle="collapse" aria-expanded="false"
        class="dropdown-toggle" href="#">
            <span class="flaticon-wallet"></span>
            @lang('lang.fees')
        </a>
        <ul class="collapse list-unstyled" id="subMenuStudentFeesCollection">
            @if(App\SmGeneralSettings::isModule('FeesCollection')== false )
            <li>
                <a href="{{route('student_fees')}}">@lang('lang.pay_fees')</a>
            </li>
            @else
            <li>
                <a href="{{url('feescollection/student-fees')}}">b@lang('lang.pay_fees')</a>
            </li>

            @endif
        </ul>
    </li>
@endif
@if(@in_array(22, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="{{route('student_class_routine')}}">
            <span class="flaticon-calendar-1"></span>
            @lang('lang.class_routine')
        </a>
    </li>
@endif
@if(@in_array(23, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="{{route('student_homework')}}">
            <span class="flaticon-book"></span>
            @lang('lang.home_work')
        </a>
    </li>
@endif
@if(@in_array(26, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="#subMenuDownloadCenter" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
        href="#">
            <span class="flaticon-data-storage"></span>
            @lang('lang.download_center')
        </a>
        <ul class="collapse list-unstyled" id="subMenuDownloadCenter">
            @if(@in_array(27, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="{{route('student_assignment')}}">@lang('lang.assignment')</a>
                </li>
            @endif
            @if(@in_array(29, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="{{route('student_study_material')}}">@lang('lang.student_study_material')</a>
                </li>
            @endif
            @if(@in_array(31, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="{{route('student_syllabus')}}">@lang('lang.syllabus')</a>
                </li>
            @endif
            @if(@in_array(33, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="{{route('student_others_download')}}">@lang('lang.other_download')</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if(@in_array(35, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="{{route('student_my_attendance')}}">
            <span class="flaticon-authentication"></span>
            @lang('lang.attendance')
        </a>
    </li>
@endif
@if(@in_array(36, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="#subMenuStudentExam" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
        href="#">
            <span class="flaticon-test"></span>
            @lang('lang.examinations')
        </a>
        <ul class="collapse list-unstyled" id="subMenuStudentExam">
            @if(@in_array(37, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="{{route('student_result')}}">@lang('lang.result')</a>
                </li>
            @endif
            @if(@in_array(38, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="{{route('student_exam_schedule')}}">@lang('lang.exam_schedule')</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if(@in_array(39, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="#subMenuLeaveManagement" data-toggle="collapse" aria-expanded="false"
            class="dropdown-toggle">
            <span class="flaticon-slumber"></span>
            @lang('lang.leave')
        </a>
        <ul class="collapse list-unstyled" id="subMenuLeaveManagement">

            @if(@in_array(40, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 2)

                <li>
                    <a href="{{url('student-apply-leave')}}">@lang('lang.apply_leave')</a>
                </li>
            @endif

            @if(@in_array(44, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 2)

                <li>
                        <a href="{{url('student-pending-leave')}}">@lang('lang.pending_leave_request')</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if(@in_array(45, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="#subMenuStudentOnlineExam" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
        href="#">
            <span class="flaticon-test-1"></span>
            @lang('lang.online_exam')
        </a>
        <ul class="collapse list-unstyled" id="subMenuStudentOnlineExam">
            @if(@in_array(46, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="{{route('student_online_exam')}}">@lang('lang.active_exams')</a>
                </li>
            @endif
            @if(@in_array(47, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="{{route('student_view_result')}}">@lang('lang.view_result')</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if(@in_array(48, App\GlobalVariable::GlobarModuleLinks()))

    <li>
        <a href="{{route('student_noticeboard')}}">
            <span class="flaticon-poster"></span>
            @lang('lang.notice_board')
        </a>
    </li>
@endif
@if(@in_array(49, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="{{route('student_subject')}}">
            <span class="flaticon-reading-1"></span>
            @lang('lang.subjects')
        </a>
    </li>
@endif
@if(@in_array(50, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="{{route('student_teacher')}}">
            <span class="flaticon-professor"></span>
            @lang('lang.teacher')
        </a>
    </li>
@endif
@if(@in_array(51, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="#subMenuStudentLibrary" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
        href="#">
            <span class="flaticon-book-1"></span>
            @lang('lang.library')
        </a>
        <ul class="collapse list-unstyled" id="subMenuStudentLibrary">
            @if(@in_array(52, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="{{route('student_library')}}"> @lang('lang.book_list')</a>
                </li>
            @endif
            @if(@in_array(53, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="{{route('student_book_issue')}}">@lang('lang.book_issue')</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if(@in_array(54, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="{{route('student_transport')}}">
            <span class="flaticon-bus"></span>
            @lang('lang.transport')
        </a>
    </li>
@endif
@if(@in_array(55, App\GlobalVariable::GlobarModuleLinks()))
    <li>
        <a href="{{route('student_dormitory')}}">
            <span class="flaticon-hotel"></span>
            @lang('lang.dormitory')
        </a>
    </li>
@endif
