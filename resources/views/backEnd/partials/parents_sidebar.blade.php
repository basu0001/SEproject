  @if(@in_array(56, App\GlobalVariable::GlobarModuleLinks()))
             <li>
                <a href="{{url('parent-dashboard')}}">
                    <span class="flaticon-resume"></span>
                    @lang('lang.dashboard')
                </a>
            </li>
            @endif
            @if(@in_array(66, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="#subMenuParentMyChildren" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-reading"></span>
                        @lang('lang.my_children')
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentMyChildren">
                        @foreach($childrens as $children)
                            <li>
                                <a href="{{route('my_children', [$children->id])}}">{{$children->full_name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if(@in_array(71, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="#subMenuParentFees" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-wallet"></span>
                        @lang('lang.fees')
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentFees">
                        @foreach($childrens as $children)
                        @if(App\SmGeneralSettings::isModule('FeesCollection')== false )
                            <li>
                                <a href="{{route('parent_fees', [$children->id])}}">{{$children->full_name}}</a>
                            </li>
                        @else
                            <li>
                                <a href="{{url('feescollection/parent-fee-payment', [$children->id])}}">{{$children->full_name}}</a>
                            </li>

                        @endif
                        @endforeach
                    </ul>
                </li>
            @endif
            @if(@in_array(72, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="#subMenuParentClassRoutine" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle">
                        <span class="flaticon-calendar-1"></span>
                        @lang('lang.class_routine')
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentClassRoutine">
                        @foreach($childrens as $children)
                            <li>
                                <a href="{{route('parent_class_routine', [$children->id])}}">{{$children->full_name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if(@in_array(73, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="#subMenuParentHomework" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-book"></span>
                        @lang('lang.home_work')
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentHomework">
                        @foreach($childrens as $children)
                            <li>
                                <a href="{{route('parent_homework', [$children->id])}}">{{$children->full_name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if(@in_array(75, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="#subMenuParentAttendance" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-authentication"></span>
                        @lang('lang.attendance')
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentAttendance">
                        @foreach($childrens as $children)
                            <li>
                                <a href="{{route('parent_attendance', [$children->id])}}">{{$children->full_name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if(@in_array(76, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="#subMenuParentExamination" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle">
                        <span class="flaticon-test"></span>
                        @lang('lang.exam')
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentExamination">
                        @foreach($childrens as $children)
                            @if(@in_array(77, App\GlobalVariable::GlobarModuleLinks()))
                                <li>
                                    <a href="{{route('parent_examination', [$children->id])}}">{{$children->full_name}}</a>
                                </li>
                            @endif
                            @if(@in_array(78, App\GlobalVariable::GlobarModuleLinks()))
                                <li>
                                    <a href="{{route('parent_exam_schedule', [$children->id])}}">@lang('lang.exam_schedule')</a>
                                </li>
                            @endif
                            @if(@in_array(79, App\GlobalVariable::GlobarModuleLinks()))
                                <li>
                                    <a href="{{ url('parent-online-examination', [$children->id])}}">@lang('lang.online_exam')</a>
                                </li>
                            @endif
                            <hr>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if(@in_array(80, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="#subMenuParentLeave" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle">
                        <span class="flaticon-test"></span>
                        @lang('lang.leave')
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentLeave">
                        @if(@in_array(81, App\GlobalVariable::GlobarModuleLinks()))
                            <li>
                                <a href="{{url('parent-apply-leave')}}">@lang('lang.apply_leave')</a>
                            </li>
                        @endif
                        @if(@in_array(82, App\GlobalVariable::GlobarModuleLinks()))
                            <li>
                                <a href="{{url('parent-pending-leave')}}">@lang('lang.pending_leave_request')</a>
                            </li>
                        @endif
                        <hr>
                        @foreach($childrens as $children)
                            <li>
                                <a href="{{route('parent_leave', [$children->id])}}">{{$children->full_name}}</a>
                            </li>
                        <hr>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if(@in_array(85, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="{{route('parent_noticeboard')}}">
                        <span class="flaticon-poster"></span>
                        @lang('lang.notice_board')
                    </a>
                </li>
            @endif
            @if(@in_array(86, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="#subMenuParentSubject" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-reading-1"></span>
                        @lang('lang.subjects')
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentSubject">
                        @foreach($childrens as $children)
                            <li>
                                <a href="{{route('parent_subjects', [$children->id])}}">{{$children->full_name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if(@in_array(87, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="#subMenuParentTeacher" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-professor"></span>
                        @lang('lang.teacher_list')
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentTeacher">
                        @foreach($childrens as $children)
                            <li>
                                <a href="{{route('parent_teacher_list', [$children->id])}}">{{$children->full_name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if(@in_array(88, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="#subMenuStudentLibrary" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                    href="#">
                        <span class="flaticon-book-1"></span>
                        @lang('lang.library')
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuStudentLibrary">
                        @if(@in_array(89, App\GlobalVariable::GlobarModuleLinks()))
                            <li>
                                <a href="{{route('parent_library')}}"> @lang('lang.book_list')</a>
                            </li>
                        @endif
                        @if(@in_array(90, App\GlobalVariable::GlobarModuleLinks()))
                            <li>
                                <a href="{{route('parent_book_issue')}}">@lang('lang.book_issue')</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(@in_array(91, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="#subMenuParentTransport" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-bus"></span>
                        @lang('lang.transport')
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentTransport">
                        @foreach($childrens as $children)
                            <li>
                                <a href="{{route('parent_transport', [$children->id])}}">{{$children->full_name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if(@in_array(92, App\GlobalVariable::GlobarModuleLinks()))
                <li>
                    <a href="#subMenuParentDormitory" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="flaticon-hotel"></span>
                        @lang('lang.dormitory_list')
                    </a>
                    <ul class="collapse list-unstyled" id="subMenuParentDormitory">
                        @foreach($childrens as $children)
                            <li>
                                <a href="{{route('parent_dormitory_list', [$children->id])}}">{{$children->full_name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
