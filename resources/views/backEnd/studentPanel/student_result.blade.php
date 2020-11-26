@extends('backEnd.master')
@section('mainContent')

@php
    function showPicName($data){
        $name = explode('/', $data);
        return $name[4];
    }
@endphp
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.examinations')</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">Examinations</a>
                <a href="{{route('student_result')}}">@lang('lang.result')</a>
            </div>
        </div>
    </div>
</section>

<section class="student-details">
    <div class="container-fluid p-0">
        <div class="row">

            <!-- Start Student Details -->
            <div class="col-lg-12">
                {{-- <div class="main-title">
                    <h3 class="mb-20">@lang('lang.exam_result')</h3>
                </div>
                    @foreach($exams as $exam)

                    <div class="white-box no-search no-paginate no-table-info mb-2">
                        <div class="main-title">
                            <h3 class="mb-0">{{(@$exam->exam)!=''?@$exam->exam->name:''}}</h3>
                        </div>
                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>@lang('lang.subject')</th>
                                    <th>@lang('lang.full_marks')</th>
                                    <th>@lang('lang.passing_marks')</th>
                                    <th>@lang('lang.obtained_marks')</th>
                                    <th>@lang('lang.results')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    @$marks = App\SmStudent::marks(@$exam->exam_id, @$student_detail->id);
                                    @$grand_total = 0;
                                    @$grand_total_marks = 0;
                                    @$result = 0;

                                @endphp
                                @foreach($marks as $mark)
                                    @php
                                        @$subject_marks = App\SmStudent::fullMarks(@$exam->id, @$mark->subject_id);
                                        @$result_subject = 0;
                                        @$grand_total_marks += @$subject_marks->full_mark;
                                        if(@$mark->abs == 0){
                                            @$grand_total += @$mark->marks;
                                            if(@$mark->marks < @$subject_marks->pass_mark){
                                               @$result_subject++;
                                               @$result++;
                                            }

                                        }else{
                                            @$result_subject++;
                                            @$result++;
                                        }
                                    @endphp
                                <tr>
                                    <td>{{@$mark->subject !=""?@$mark->subject->subject_name:""}}</td>
                                    <td>{{@$subject_marks->full_mark}}</td>
                                    <td>{{@$subject_marks->pass_mark}}</td>
                                    <td>{{@$mark->marks}}</td>
                                    <td>
                                        @if(@$result_subject == 0)
                                            <span class="primary-btn small bg-success text-white border-0">Pass</span>
                                        @else
                                            <span class="primary-btn small bg-danger text-white border-0">Fail</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            @if(count(@$marks) != "")
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Grand Total: {{@$grand_total}}/{{@$grand_total_marks}}</th>
                                    <th></th>
                                    <th>Grade: 
                                        @php
                                            if(@$result == 0){
                                                @$percent = @$grand_total/@$grand_total_marks*100;
                                                foreach($grades as $grade){
                                                   if(floor(@$percent) >= @$grade->percent_from && floor(@$percent) <= @$grade->percent_upto){
                                                       echo @$grade->grade_name;
                                                   }
                                                }
                                            }else{
                                                echo "F";
                                            }
                                        @endphp
                                    </th>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                    @endforeach --}}




                    <!-- Start Exam Profile view-->
                    @foreach($exam_terms as $exam)

                    @php

                        $get_results = App\SmStudent::getExamResult(@$exam->id, @$student_detail);


                    @endphp


                    @if($get_results)

                    <div class="main-title">
                        <h3 class="mb-0">{{@$exam->title}}</h3>
                    </div>
                    <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>@lang('lang.date')</th>
                            <th>@lang('lang.subject')</th>
                            <th>@lang('lang.full_marks')</th>
                            <th>@lang('lang.obtained_marks')</th>
                            <th>@lang('lang.grade')</th>
                            <!-- <th>@lang('lang.results')</th> -->
                        </tr>
                        </thead>

                        <tbody>
                            
                        @php
                            $grand_total = 0;
                            $grand_total_marks = 0;
                            $result = 0;
                        @endphp

                        @foreach($get_results as $mark)
                            @php
                                $subject_marks = App\SmStudent::fullMarksBySubject($exam->id, $mark->subject_id);

                                $schedule_by_subject = App\SmStudent::scheduleBySubject($exam->id, $mark->subject_id, @$student_detail);

                                $result_subject = 0;

                                $grand_total_marks += @$subject_marks->exam_mark;

                                if(@$mark->is_absent == 0){
                                    $grand_total += @$mark->total_marks;
                                    if($mark->marks < $subject_marks->pass_mark){
                                       $result_subject++;
                                       $result++;
                                    }
                                }else{
                                    $result_subject++;
                                    $result++;
                                }
                            @endphp
                            <tr>
                                <td>{{ !empty($schedule_by_subject->date)? App\SmGeneralSettings::DateConvater($schedule_by_subject->date):''}}</td>
                                <td>{{@$mark->subject->subject_name}}</td>
                                <td>{{@$subject_marks->exam_mark}}</td>
                                <td>{{@$mark->total_marks}}</td>
                                <td>{{@$mark->total_gpa_grade}}</td>
                                <!-- <td>
                                    @if($result_subject == 0)
                                        <button
                                            class="primary-btn small bg-success text-white border-0">
                                            @lang('lang.pass')
                                        </button>
                                    @else
                                        <button class="primary-btn small bg-danger text-white border-0">
                                            @lang('lang.fail')
                                        </button>
                                    @endif
                                </td> -->
                            </tr>
                        @endforeach
                        </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>@lang('lang.grand_total'): {{$grand_total}}/{{$grand_total_marks}}</th>
                                
                                <th>@lang('lang.grade'):
                                    @php
                                        if($result == 0 && $grand_total_marks != 0){
                                            $percent = $grand_total/$grand_total_marks*100;


                                            foreach($grades as $grade){
                                               if(floor($percent) >= $grade->percent_from && floor($percent) <= $grade->percent_upto){
                                                   echo $grade->grade_name;
                                               }
                                           }

                                        }else{
                                            echo "F";
                                        }
                                    @endphp
                                </th>
                            </tr>
                            </tfoot>
                    </table>

                    @endif

                    @endforeach
                </div>
                    <!-- End Exam Profile view-->
                    
            </div>
            <!-- End Student Details -->
        </div>

            
    </div>
</section>






@endsection
