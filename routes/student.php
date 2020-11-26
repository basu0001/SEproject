<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['XSS']], function () {


    // student panel
    Route::group(['middleware' => ['StudentMiddleware']], function () {


        //Route::get('delete-document/{id}', ['as' => 'delete_document', 'uses' => 'SmStudentAdmissionController@deleteDocument']);
        Route::get('delete-document/{id}', ['as' => 'delete_document', 'uses' => 'SmStudentAdmissionController@deleteDocument']);
        Route::post('student_upload_document', ['as' => 'student_upload_document', 'uses' => 'SmStudentAdmissionController@studentUploadDocument']);

        Route::get('student-download-document/{file_name}', 'Student\SmStudentPanelController@DownlodStudentDocument');


        Route::post('student-logout', 'Auth\LoginController@logout')->name('student-logout');

        Route::get('student-profile',  'Student\SmStudentPanelController@studentDashboard');

        Route::get('student-dashboard',  'Student\SmStudentPanelController@studentProfile');

        Route::get('download-timeline-doc/{file_name}',  'Student\SmStudentPanelController@DownlodTimeline');



        // fees
        Route::get('student-fees', ['as' => 'student_fees', 'uses' => 'Student\SmFeesController@studentFees']);

        // Route::get('fees-payment-stripe/{fees_type}/{student_id}/{amount}', 'Student\SmFeesController@feesPaymentStripe');
        // Route::post('fees-payment-stripe-store', 'Student\SmFeesController@feesPaymentStripeStore');

        // online exam
        Route::get('student-online-exam', ['as' => 'student_online_exam', 'uses' => 'Student\SmOnlineExamController@studentOnlineExam']);
        Route::get('take-online-exam/{id}', ['as' => 'take_online_exam', 'uses' => 'Student\SmOnlineExamController@takeOnlineExam']);
        Route::post('student-online-exam-submit', ['as' => 'student_online_exam_submit', 'uses' => 'Student\SmOnlineExamController@studentOnlineExamSubmit']);

        Route::get('student_view_result', ['as' => 'student_view_result', 'uses' => 'Student\SmOnlineExamController@studentViewResult']);

        Route::get('student-answer-script/{exam_id}/{s_id}', ['as' => 'student_answer_script', 'uses' => 'Student\SmOnlineExamController@studentAnswerScript']);

        //class timetable
        Route::get('student-class-routine', ['as' => 'student_class_routine', 'uses' => 'Student\SmStudentPanelController@classRoutine']);


        //Student attendance
        Route::get('student-my-attendance', ['as' => 'student_my_attendance', 'uses' => 'Student\SmStudentPanelController@studentMyAttendance']);
        Route::post('student-my-attendance', ['as' => 'student_my_attendance', 'uses' => 'Student\SmStudentPanelController@studentMyAttendanceSearch']);

        Route::get('my-attendance/print/{month}/{year}/', 'Student\SmStudentPanelController@studentMyAttendancePrint');


        //student Result
        Route::get('student-result', ['as' => 'student_result', 'uses' => 'Student\SmStudentPanelController@studentResult']);

        //student Exam Schedule
        Route::get('student-exam-schedule', ['as' => 'student_exam_schedule', 'uses' => 'Student\SmStudentPanelController@studentExamSchedule']);
        Route::post('student-exam-schedule-search', ['as' => 'student_exam_schedule_search', 'uses' => 'Student\SmStudentPanelController@studentExamScheduleSearch']);
        Route::post('student-exam-schedule/print', ['as' => 'exam_schedule_print', 'uses' => 'SmExamRoutineController@examSchedulePrint']);

        //student Homework
        Route::get('student-homework', ['as' => 'student_homework', 'uses' => 'Student\SmStudentPanelController@studentHomework']);

        Route::get('student-homework-view/{class_id}/{section_id}/{homework}', ['as' => 'student_homework_view', 'uses' => 'Student\SmStudentPanelController@studentHomeworkView']);

        Route::get('add-homework-content/{homework}', 'Student\SmStudentPanelController@addHomeworkContent');
        Route::post('upload-homework-content', 'Student\SmStudentPanelController@uploadHomeworkContent');
        Route::get('deleteview-homework-content/{homework}', 'Student\SmStudentPanelController@deleteViewHomeworkContent');
        Route::get('delete-homework-content/{homework}', 'Student\SmStudentPanelController@deleteHomeworkContent');




        Route::get('evaluation-document/{file_name}', 'Student\SmStudentPanelController@DownlodDocument');


        // download center
        Route::get('student-assignment', ['as' => 'student_assignment', 'uses' => 'Student\SmStudentPanelController@studentAssignment']);

        Route::get('student-study-material', ['as' => 'student_study_material', 'uses' => 'Student\SmStudentPanelController@studentStudyMaterial']);

        Route::get('student-syllabus', ['as' => 'student_syllabus', 'uses' => 'Student\SmStudentPanelController@studentSyllabus']);
        Route::get('student-others-download', ['as' => 'student_others_download', 'uses' => 'Student\SmStudentPanelController@othersDownload']);

        Route::get('upload-content-document/{file_name}', 'Student\SmStudentPanelController@DownlodContent');


        //student Subject
        Route::get('student-subject', ['as' => 'student_subject', 'uses' => 'Student\SmStudentPanelController@studentSubject']);


        // online exam
        Route::get('student-answer-script/{exam_id}/{s_id}', ['as' => 'student_answer_script', 'uses' => 'Student\SmOnlineExamController@studentAnswerScript']);

        // transport route
        Route::get('student-transport', ['as' => 'student_transport', 'uses' => 'Student\SmStudentPanelController@studentTransport']);
        Route::get('student-transport-view-modal/{r_id}/{v_id}', ['as' => 'student_transport_view_modal', 'uses' => 'Student\SmStudentPanelController@studentTransportViewModal']);

        // Dormitory Rooms
        Route::get('student-dormitory', ['as' => 'student_dormitory', 'uses' => 'Student\SmStudentPanelController@studentDormitory']);
        // Student Library Book list
        Route::get('student-library', ['as' => 'student_library', 'uses' => 'Student\SmStudentPanelController@studentBookList']);
        // Student Library Book Issue
        Route::get('student-book-issue', ['as' => 'student_book_issue', 'uses' => 'Student\SmStudentPanelController@studentBookIssue']);
        // Student Noticeboard
        Route::get('student-noticeboard', ['as' => 'student_noticeboard', 'uses' => 'Student\SmStudentPanelController@studentNoticeboard']);
        // Student Teacher
        Route::get('student-teacher', ['as' => 'student_teacher', 'uses' => 'Student\SmStudentPanelController@studentTeacher']);
    });


    // Student leave

    Route::group(['middleware' => ['auth'], 'namespace' => 'Student'], function () {
        Route::get('student-apply-leave', 'SmStudentPanelController@leaveApply');
        Route::post('student-leave-store', 'SmStudentPanelController@leaveStore');
        Route::get('student-leave-edit/{id}', 'SmStudentPanelController@studentLeaveEdit');
        Route::get('student-pending-leave', 'SmStudentPanelController@pendingLeave');
        Route::put('student-leave-update/{id}', 'SmStudentPanelController@update');
    });
});
Route::get('download-uploaded-content/{id}', 'Student\SmStudentPanelController@downloadHomeWorkContent');
Route::get('download-uploaded-content/{file_name}', function ($file_name = null) {

    $file = public_path() . '/uploads/homeworkcontent/' . $file_name;
    if (file_exists($file)) {
        return Response::download($file);
    }
});


Route::get('fees-payment-stripe/{fees_type}/{student_id}/{amount}', 'Student\SmFeesController@feesPaymentStripe');
Route::post('fees-payment-stripe-store', 'Student\SmFeesController@feesPaymentStripeStore');


// student bank cheque payment 
Route::get('fees-generate-modal-child/{amount}/{student_id}/{type}', 'Student\SmFeesController@feesGenerateModalChild');
Route::post('child-bank-slip-store', 'Student\SmFeesController@childBankSlipStore');
Route::get('fees-generate-modal-child-view/{id}', 'Student\SmFeesController@feesGenerateModalChildView');
Route::post('child-bank-slip-delete', 'Student\SmFeesController@childBankSlipDelete');