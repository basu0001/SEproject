@extends('backEnd.master')
@section('mainContent')

@php
    function showPicName($data){
        $name = explode('/', $data);
        return $name[4];
    }

    $childrens = App\SmParent::myChildrens();


    $abc = App\YearCheck::getYear();



@endphp

<section class="student-details">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-3">
            <div class="main-title">
                    <h3 class="mb-20">@lang('lang.my_children')</h3>
                </div>
            </div>
        </div>
        {{-- <div class="row"> --}}
            @foreach($childrens as $children)
             <div class="row">
            <div class="col-lg-12">
                <!-- Start Student Meta Information -->
                <div class="main-title">
                    <h3 class="mb-20"><strong> {{$children->full_name}}</strong> </h3>
                </div> 
              
    @php

        $student_detail=$children;

        $totalSubjects = App\SmAssignSubject::where('class_id', '=', $student_detail->class_id)->where('section_id', '=', $student_detail->section_id)->where('academic_id', App\YearCheck::getAcademicId())->get();

        $totalNotices = App\SmNoticeBoard::where('active_status', '=', 1)->where('is_published', '=', 1)->where('academic_id', App\YearCheck::getAcademicId())->get();

        $now = date('H:i:s');
        // $online_exams = App\SmOnlineExam::where('active_status', 1)->where('status', 1)->where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->where('date', 'like', date('Y-m-d'))->where('start_time', '<', $now)->where('end_time', '>', $now)->get();

        $online_exams = App\SmOnlineExam::where('active_status', 1)->where('status', 1
            )->where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)
            // ->where('date', 'like', date('Y-m-d'))->where('start_time', '<', $now)->where('end_time', '>', $now)
            ->where('academic_id', App\YearCheck::getAcademicId())->where('school_id',Auth::user()->school_id)->get();

        $teachers = App\SmAssignSubject::select('teacher_id')->where('class_id', $student_detail->class_id)
            ->where('section_id', $student_detail->section_id)->distinct('teacher_id')->where('academic_id', App\YearCheck::getAcademicId())->get();

        $issueBooks = App\SmBookIssue::where('member_id', $student_detail->user_id)->where('issue_status', 'I')->get();
    $exams = App\SmExamSchedule::where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->where('academic_id', App\YearCheck::getAcademicId())->get();
       
        $homeworkLists = App\SmHomework::where('class_id', $student_detail->class_id)
            ->where('section_id', $student_detail->section_id)
            ->where('evaluation_date', '=', null)
            ->where('submission_date', '>', $now)
            ->where('academic_id', App\YearCheck::getAcademicId())
            ->get();
        $month = date('m');
        $year = date('Y');
        // return $year;
        $attendances = DB::table('sm_student_attendances')->where('student_id', $student_detail->id)
            ->where('attendance_date', 'like', $year . '-' . $month . '%')
            ->where('attendance_type', '=', 'P')
            ->where('academic_id', App\YearCheck::getAcademicId())
            ->get();
            
    @endphp
            </div>
        </div>
            <div class="row">
                @if(@in_array(57, App\GlobalVariable::GlobarModuleLinks()))
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>@lang('lang.subject')</h3>
                                    <p class="mb-0">@lang('lang.total') @lang('lang.subject')</p>
                                </div>
                                <h1 class="gradient-color2">
                                   
                                     @if(isset($totalSubjects))
                                        {{count($totalSubjects)}}
                                    @endif
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
                @if(@in_array(58, App\GlobalVariable::GlobarModuleLinks()))
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>@lang('lang.notice')</h3>
                                    <p class="mb-0">@lang('lang.total') @lang('lang.notice')</p>
                                </div>
                                <h1 class="gradient-color2">
                                     @if(isset($totalNotices))
                                        {{count($totalNotices)}}
                                    @endif
                                </h1>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if(@in_array(59, App\GlobalVariable::GlobarModuleLinks()))
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>@lang('lang.exam')</h3>
                                    <p class="mb-0">@lang('lang.total') @lang('lang.exam')</p>
                                </div>
                                <h1 class="gradient-color2">
                                     @if(isset($exams))
                                        {{count($exams)}}
                                    @endif
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
                    @if(@in_array(60, App\GlobalVariable::GlobarModuleLinks()))
                <div class="col-lg-3 col-md-6">
                    <a href="{{ url('student-online-exam') }}" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>@lang('lang.online_exam')</h3>
                                    <p class="mb-0">@lang('lang.total') @lang('lang.online_exam')</p>
                                </div>
                                <h1 class="gradient-color2">
                                     @if(isset($online_exams))
                                        {{count($online_exams)}}
                                    @endif
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
                @if(@in_array(61, App\GlobalVariable::GlobarModuleLinks()))

                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>@lang('lang.teachers')</h3>
                                    <p class="mb-0">@lang('lang.total') @lang('lang.teachers')</p>
                                </div>
                                <h1 class="gradient-color2"> @if(isset($teachers))
                                        {{count($teachers)}}
                                    @endif</h1>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
                @if(@in_array(62, App\GlobalVariable::GlobarModuleLinks()))
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>@lang('lang.issued') @lang('lang.book')</h3>
                                    <p class="mb-0">@lang('lang.total') @lang('lang.issued') @lang('lang.book')</p>
                                </div>
                                <h1 class="gradient-color2">
                                     @if(isset($issueBooks))
                                        {{count($issueBooks)}}
                                    @endif
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
                @if(@in_array(63, App\GlobalVariable::GlobarModuleLinks()))
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>@lang('lang.pending') @lang('lang.home_work')</h3>
                                    <p class="mb-0">@lang('lang.total') @lang('lang.pending') @lang('lang.home_work')</p>
                                </div>
                                <h1 class="gradient-color2">
                                     @if(isset($homeworkLists))
                                        {{count($homeworkLists)}}
                                    @endif
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
                @if(@in_array(64, App\GlobalVariable::GlobarModuleLinks()))
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="d-block">
                        <div class="white-box single-summery">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3>@lang('lang.attendance_this_month')</h3>
                                    <p class="mb-0">@lang('lang.total') @lang('lang.attendance') @lang('lang.in')  @lang('lang.current_month')</p>
                                </div>
                                <h1 class="gradient-color2">
                                     @if(isset($attendances))
                                        {{count($attendances)}}
                                    @endif
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
                @endif

            </div>
            {{-- </div> --}}
            <br>
            @endforeach

            @if(@in_array(65, App\GlobalVariable::GlobarModuleLinks()))
             <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">@lang('lang.calendar')</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <div class='common-calendar'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            @endif
        </div>  
    </div>


    
</section>

<div id="fullCalModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                    <h4 id="modalTitle" class="modal-title"></h4>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="There are no image" id="image" height="150" width="auto">
                    <div id="modalBody"></div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


<?php

$count_event =0;
@$calendar_events = array();

foreach($holidays as $k => $holiday) {

    @$calendar_events[$k]['title'] = $holiday->holiday_title;
    
    $calendar_events[$k]['start'] = $holiday->from_date;
    
    $calendar_events[$k]['end'] = $holiday->to_date;

    $calendar_events[$k]['description'] = $holiday->details;

    $calendar_events[$k]['url'] = $holiday->upload_image_file;

    $count_event = $k;
    $count_event++;
    
}



foreach($events as $k => $event) {

    @$calendar_events[$count_event]['title'] = $event->event_title;
    
    $calendar_events[$count_event]['start'] = $event->from_date;
    
    $calendar_events[$count_event]['end'] = $event->to_date;
    $calendar_events[$count_event]['description'] = $event->event_des;
    $calendar_events[$count_event]['url'] = $event->uplad_image_file;
    $count_event++;
}





?>
@endsection
@section('script')

<script type="text/javascript">
    /*-------------------------------------------------------------------------------
       Full Calendar Js 
    -------------------------------------------------------------------------------*/
    if ($('.common-calendar').length) {
        $('.common-calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            eventClick:  function(event, jsEvent, view) {
                    $('#modalTitle').html(event.title);
                    $('#modalBody').html(event.description);
                    $('#image').attr('src',event.url);
                    $('#fullCalModal').modal();
                    return false;
                },
            height: 650,
            events: <?php echo json_encode($calendar_events);?> ,
        });
    }


</script>

@endsection
