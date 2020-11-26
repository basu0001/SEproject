<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['XSS']], function () {
    // parent panel
    Route::group(['middleware' => ['ParentMiddleware']], function () {
        Route::get('parent-dashboard',  'Parent\SmParentPanelController@ParentDashboard');

        Route::get('my-children/{id}', ['as' => 'my_children', 'uses' => 'Parent\SmParentPanelController@myChildren']);
        Route::get('parent-fees/{id}', ['as' => 'parent_fees', 'uses' => 'Parent\SmFeesController@childrenFees']);


        Route::get('parent-class-routine/{id}', ['as' => 'parent_class_routine', 'uses' => 'Parent\SmParentPanelController@classRoutine']);
        Route::get('parent-attendance/{id}', ['as' => 'parent_attendance', 'uses' => 'Parent\SmParentPanelController@attendance']);
        Route::get('my-child-attendance/print/{student_id}/{month}/{year}/', 'Parent\SmParentPanelController@attendancePrint');


        Route::get('parent-homework/{id}', ['as' => 'parent_homework', 'uses' => 'Parent\SmParentPanelController@homework']);
        Route::get('parent-homework-view/{class_id}/{section_id}/{homework}', ['as' => 'parent_homework_view', 'uses' => 'Parent\SmParentPanelController@homeworkView']);
        Route::get('parent-noticeboard', ['as' => 'parent_noticeboard', 'uses' => 'Parent\SmParentPanelController@parentNoticeboard']);


        Route::post('parent-attendance-search', ['as' => 'parent_attendance_search', 'uses' => 'Parent\SmParentPanelController@attendanceSearch']);
        Route::post('parent-exam-schedule/print', ['as' => 'exam_schedule_print', 'uses' => 'SmExamRoutineController@examSchedulePrint']);

        Route::get('parent-online-examination/{id}', ['as' => 'parent_online_examination', 'uses' => 'Parent\SmParentPanelController@onlineExamination']);
        Route::get('parent-leave/{id}', ['as' => 'parent_leave', 'uses' => 'Parent\SmParentPanelController@parentLeave']);

        // Leave 
        Route::get('parent-apply-leave', 'Parent\SmParentPanelController@leaveApply');
        Route::post('parent-leave-store', 'Parent\SmParentPanelController@leaveStore');
        Route::get('parent-view-leave-details-apply/{id}', 'Parent\SmParentPanelController@viewLeaveDetails');
        Route::get('parent-leave-edit/{id}', 'Parent\SmParentPanelController@parentLeaveEdit');
        Route::get('parent-pending-leave', 'Parent\SmParentPanelController@pendingLeave');
        Route::put('parent-leave-update/{id}', 'Parent\SmParentPanelController@update');
        Route::delete('parent-leave-delete/{id}', 'Parent\SmParentPanelController@DeleteLeave');
        //end

        Route::get('parent-examination/{id}', ['as' => 'parent_examination', 'uses' => 'Parent\SmParentPanelController@examination']);
        Route::get('parent-examination-schedule/{id}', ['as' => 'parent_exam_schedule', 'uses' => 'Parent\SmParentPanelController@examinationSchedule']);
        Route::post('parent-examination-schedule', ['as' => 'parent_exam_schedule_search', 'uses' => 'Parent\SmParentPanelController@examinationScheduleSearch']);

        // Student Library Book list
        Route::get('parent-library', ['as' => 'parent_library', 'uses' => 'Parent\SmParentPanelController@parentBookList']);
        // Student Library Book Issue
        Route::get('parent-book-issue', ['as' => 'parent_book_issue', 'uses' => 'Parent\SmParentPanelController@parentBookIssue']);

        Route::get('parent-subjects/{id}', ['as' => 'parent_subjects', 'uses' => 'Parent\SmParentPanelController@subjects']);
        Route::get('parent-teacher-list/{id}', ['as' => 'parent_teacher_list', 'uses' => 'Parent\SmParentPanelController@teacherList']);
        Route::get('parent-transport/{id}', ['as' => 'parent_transport', 'uses' => 'Parent\SmParentPanelController@transport']);
        Route::get('parent-dormitory/{id}', ['as' => 'parent_dormitory_list', 'uses' => 'Parent\SmParentPanelController@dormitory']);


        //dowmload 
        Route::get('parent/student-download-timeline-doc/{file_name}', ['as' => 'parent_dormitory', 'uses' => 'Parent\SmParentPanelController@StudentDownload']);
    });
});