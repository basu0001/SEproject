<?php

namespace App\Http\Controllers\Parent;

use Modules\RolePermission\Entities\InfixRole;
use App\Role;
use App\SmBook;
use App\SmExam;
use App\SmParent;
use App\SmHoliday;
use App\SmEvent;
use App\SmStudent;
use App\SmSubject;
use App\SmVehicle;
use App\SmWeekend;
use App\YearCheck;
use App\SmExamType;
use App\SmHomework;
use App\SmRoomList;
use App\SmRoomType;
use App\SmBookIssue;
use App\SmClassTime;
use App\SmLeaveType;
use App\SmFeesAssign;
use App\SmMarksGrade;
use App\SmOnlineExam;
use App\ApiBaseMethod;
use App\SmFeesPayment;
use App\SmLeaveDefine;
use App\SmNoticeBoard;
use App\SmAcademicYear;
use App\SmExamSchedule;
use App\SmLeaveRequest;
use App\SmAssignSubject;
use App\SmAssignVehicle;
use App\SmDormitoryList;
use App\SmLibraryMember;
use Barryvdh\DomPDF\Facade as PDF;
use App\SmStudentDocument;
use App\SmStudentTimeline;
use App\SmStudentAttendance;
use Illuminate\Http\Request;
use App\SmFeesAssignDiscount;
use App\SmStudentTakeOnlineExam;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class SmParentPanelController extends Controller
{

    public function __construct()
    {
        $this->middleware('PM');
        // User::checkAuth();
    }

    public function parentDashboard()
    {
        try {

            $holidays = SmHoliday::where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();


            $events = SmEvent::where('active_status', 1)
                ->where('academic_id', YearCheck::getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->where(function ($q) {
                    $q->where('for_whom', 'All')->orWhere('for_whom', 'Parents');
                })
                ->get();

            return view('backEnd.parentPanel.parent_dashboard', compact('holidays', 'events'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function myChildren($id)
    {
        // return $id;
        $parent_info = SmParent::where('user_id', Auth::user()->id)->first();
        // return $parent_info;
        try {
            $student_detail = SmStudent::where('id', $id)->where('parent_id', $parent_info->id)->first();
            if ($student_detail) {
                $driver = SmVehicle::where('sm_vehicles.id', $student_detail->vechile_id)
                    ->join('sm_staffs', 'sm_vehicles.driver_id', '=', 'sm_staffs.id')
                    ->where('sm_staffs.school_id', Auth::user()->school_id)
                    ->first();
                //return $driver;
                $fees_assigneds = SmFeesAssign::where('student_id', $student_detail->id)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                $fees_discounts = SmFeesAssignDiscount::where('student_id', $student_detail->id)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                $documents = SmStudentDocument::where('student_staff_id', $student_detail->id)->where('type', 'stu')->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                $timelines = SmStudentTimeline::where('staff_student_id', $student_detail->id)->where('type', 'stu')->where('academic_id', YearCheck::getAcademicId())->where('visible_to_student', 1)->where('school_id', Auth::user()->school_id)->get();
                $exams = SmExamSchedule::where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                $grades = SmMarksGrade::where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                $academic_year = SmAcademicYear::where('id', $student_detail->session_id)->first();
                $exam_terms = SmExamType::where('school_id',Auth::user()->school_id)->where('academic_id', YearCheck::getAcademicId())->get();
                // $exam_terms = [];
                return view('backEnd.parentPanel.my_children', compact('student_detail', 'fees_assigneds', 'driver', 'fees_discounts', 'exams', 'documents', 'timelines', 'grades', 'exam_terms','academic_year'));
            } else {
                Toastr::warning('Invalid Student ID', 'Invalid');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function onlineExamination($id)
    {

        try {
            // $student = Auth::user()->student;
            $student = SmStudent::findOrfail($id);
            $now = date('H:i:s');
            // ->where('start_time', '<', $now)
            $online_exams = SmOnlineExam::where('active_status', 1)->where('status', 1)->where('class_id', $student->class_id)->where('section_id', $student->section_id)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            // return $online_exams;
            $marks_assigned = [];
            foreach ($online_exams as $online_exam) {
                $exam = SmStudentTakeOnlineExam::where('online_exam_id', $online_exam->id)->where('student_id', $student->id)->where('status', 2)->where('school_id', Auth::user()->school_id)->first();
                if ($exam != "") {
                    $marks_assigned[] = $exam->online_exam_id;
                }
            }
            return view('backEnd.parentPanel.parent_online_exam', compact('online_exams', 'marks_assigned', 'now', 'student'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function parentLeave($id)
    {

        try {
            // return $id;
            $student = SmStudent::findOrfail($id);
            $apply_leaves = SmLeaveRequest::where('staff_id', '=', $student->user_id)
                ->join('sm_leave_defines', 'sm_leave_defines.id', '=', 'sm_leave_requests.leave_define_id')
                ->join('sm_leave_types', 'sm_leave_types.id', '=', 'sm_leave_defines.type_id')
                ->where('sm_leave_requests.academic_id', YearCheck::getAcademicId())
                ->where('sm_leave_requests.school_id', Auth::user()->school_id)->get();
            // return $apply_leaves;

            return view('backEnd.parentPanel.parent_leave', compact('apply_leaves', 'student'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    function leaveApply(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                $my_leaves = SmLeaveDefine::where('role_id', 2)->where('school_id', Auth::user()->school_id)->get();
                $apply_leaves = SmLeaveRequest::where('role_id', 2)->where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                $leave_types = SmLeaveDefine::where('role_id', 2)->where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            } else {
                $my_leaves = SmLeaveDefine::where('role_id', $request->role_id)->where('school_id', Auth::user()->school_id)->get();
                $apply_leaves = SmLeaveRequest::where('role_id', $request->role_id)->where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
                $leave_types = SmLeaveDefine::where('role_id', $request->role_id)->where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            }

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['my_leaves'] = $my_leaves->toArray();
                $data['apply_leaves'] = $apply_leaves->toArray();
                $data['leave_types'] = $leave_types->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.parentPanel.apply_leave', compact('apply_leaves', 'leave_types', 'my_leaves', 'user'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function leaveStore(Request $request)
    {
        // dd($request->all());
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $input = $request->all();
        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            $validator = Validator::make($input, [
                'student_id' => "required",
                'apply_date' => "required",
                'leave_type' => "required",
                'leave_from' => 'required|before_or_equal:leave_to',
                'leave_to' => "required",
                'login_id' => "required",
                'role_id' => "required"
            ]);
        } else {
            $validator = Validator::make($input, [
                'student_id' => "required",
                'apply_date' => "required",
                'leave_type' => "required",
                'leave_from' => 'required|before_or_equal:leave_to',
                'leave_to' => "required"
            ]);
        }
        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $input = $request->all();
            $fileName = "";
            if ($request->file('attach_file') != "") {
                $file = $request->file('attach_file');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/leave_request/', $fileName);
                $fileName = 'public/uploads/leave_request/' . $fileName;
            }
            $apply_leave = new SmLeaveRequest();
            $apply_leave->staff_id = $request->student_id;
            $apply_leave->role_id = 2;
            $apply_leave->apply_date = date('Y-m-d', strtotime($request->apply_date));
            $apply_leave->leave_define_id = $request->leave_type;
            $apply_leave->type_id = $request->leave_type;
            $apply_leave->leave_from = date('Y-m-d', strtotime($request->leave_from));
            $apply_leave->leave_to = date('Y-m-d', strtotime($request->leave_to));
            $apply_leave->approve_status = 'P';
            $apply_leave->reason = $request->reason;
            $apply_leave->file = $fileName;
            $apply_leave->school_id = Auth::user()->school_id;
            $apply_leave->academic_id = YearCheck::getAcademicId();
            $result = $apply_leave->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Leave Request has been created successfully.');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function viewLeaveDetails(Request $request, $id)
    {
        try {
            $leaveDetails = SmLeaveRequest::find($id);
            $apply = "";
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['leaveDetails'] = $leaveDetails->toArray();
                $data['apply'] = $apply;
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.parentPanel.viewLeaveDetails', compact('leaveDetails', 'apply'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    function leaveEdit($id)
    {
    }

    public function pendingLeave(Request $request)
    {

        try {
            $apply_leaves = SmLeaveRequest::where([['active_status', 1], ['approve_status', 'P']])->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $leave_types = SmLeaveType::where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->whereOr(['school_id', Auth::user()->school_id], ['school_id', 1])->get();
            $roles = InfixRole::where('id', 2)->where('academic_id', YearCheck::getAcademicId())->where(function ($q) {
                $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
            })->get();
            $pendingRequest = SmLeaveRequest::where('sm_leave_requests.active_status', 1)
                ->select('sm_leave_requests.id', 'full_name', 'apply_date', 'leave_from', 'leave_to', 'reason', 'file', 'sm_leave_types.type', 'approve_status')
                ->join('sm_leave_defines', 'sm_leave_requests.leave_define_id', '=', 'sm_leave_defines.id')
                ->join('sm_staffs', 'sm_leave_requests.staff_id', '=', 'sm_staffs.id')
                ->leftjoin('sm_leave_types', 'sm_leave_requests.type_id', '=', 'sm_leave_types.id')
                ->where('sm_leave_requests.approve_status', '=', 'P')
                ->where('sm_leave_requests.academic_id', YearCheck::getAcademicId())
                ->where('sm_leave_requests.school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['pending_request'] = $pendingRequest->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.parentPanel.pending_leave', compact('apply_leaves', 'leave_types', 'roles'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function parentLeaveEdit(request $request, $id)
    {

        try {
            $user = Auth::user();
            if ($user) {
                $my_leaves = SmLeaveDefine::where('role_id', 2)->where('school_id', Auth::user()->school_id)->get();
                $apply_leaves = SmLeaveRequest::where('role_id', 2)->where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                $leave_types = SmLeaveDefine::where('role_id', 2)->where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            } else {
                $my_leaves = SmLeaveDefine::where('role_id', $request->role_id)->where('school_id', Auth::user()->school_id)->get();
                $apply_leaves = SmLeaveRequest::where('role_id', $request->role_id)->where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
                $leave_types = SmLeaveDefine::where('role_id', $request->role_id)->where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            }
            $apply_leave = SmLeaveRequest::find($id);

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['my_leaves'] = $my_leaves->toArray();
                $data['apply_leaves'] = $apply_leaves->toArray();
                $data['leave_types'] = $leave_types->toArray();
                $data['apply_leave'] = $apply_leave->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.parentPanel.apply_leave', compact('apply_leave', 'apply_leaves', 'leave_types', 'my_leaves', 'user'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $input = $request->all();
        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            $validator = Validator::make($input, [
                'id' => "required",
                'apply_date' => "required",
                'leave_type' => "required",
                'leave_from' => 'required|before_or_equal:leave_to',
                'leave_to' => "required",
                'login_id' => "required",
                'role_id' => "required"
            ]);
        } else {
            $validator = Validator::make($input, [
                'apply_date' => "required",
                'leave_type' => "required",
                'leave_from' => 'required|before_or_equal:leave_to',
                'leave_to' => "required"
            ]);
        }

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $fileName = "";
            if ($request->file('file') != "") {
                $apply_leave = SmLeaveRequest::find($request->id);
                if (file_exists($apply_leave->file)) unlink($apply_leave->file);
                $file = $request->file('file');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/leave_request/', $fileName);
                $fileName = 'public/uploads/leave_request/' . $fileName;
            }

            $user = Auth()->user();
            $apply_leave = SmLeaveRequest::find($request->id);
            $apply_leave->staff_id = $request->student_id;
            $apply_leave->role_id = 2;
            $apply_leave->apply_date = date('Y-m-d', strtotime($request->apply_date));
            $apply_leave->leave_define_id = $request->leave_type;
            $apply_leave->leave_from = date('Y-m-d', strtotime($request->leave_from));
            $apply_leave->leave_to = date('Y-m-d', strtotime($request->leave_to));
            $apply_leave->approve_status = 'P';
            $apply_leave->reason = $request->reason;
            if ($fileName != "") {
                $apply_leave->file = $fileName;
            }
            $result = $apply_leave->save();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Leave Request has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect('apply-leave');
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    function DeleteLeave(Request $request, $id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        try {
            $apply_leave = SmLeaveRequest::find($id);
            if ($apply_leave->file != "") {
                if (file_exists($apply_leave->file)) unlink($apply_leave->file);
            }
            $result = $apply_leave->delete();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Request has been deleted successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect('parent-apply-leave');
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function classRoutine($id)
    {
        try {
            $student_detail = SmStudent::where('id', $id)->first();
            $class_id = $student_detail->class_id;
            $section_id = $student_detail->section_id;
            $sm_weekends = SmWeekend::orderBy('order', 'ASC')->where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $class_times = SmClassTime::where('type', 'class')->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.parentPanel.class_routine', compact('class_times', 'class_id', 'section_id', 'sm_weekends', 'student_detail'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function attendance($id)
    {
        try {
            $student_detail = SmStudent::where('id', $id)->first();
            $academic_years = SmAcademicYear::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.parentPanel.attendance', compact('student_detail', 'academic_years'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function attendanceSearch(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required'
        ]);

        try {
            $student_detail = SmStudent::where('id', $request->student_id)->first();
            $year = $request->year;
            $month = $request->month;
            $current_day = date('d');
            $days = cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year);
            //$students = SmStudent::where('class_id', $request->class)->where('section_id', $request->section)->where('school_id',Auth::user()->school_id)->get();
            // $academic_years = SmAcademicYear::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            // $attendances = SmStudentAttendance::/* where('student_id', $student_detail->id)->where('attendance_date', 'LIKE', '%'.$request->year . '-' . $request->month . '%')-> */get();
            
            $attendances = SmStudentAttendance::where('student_id', $student_detail->id)->where('academic_id', YearCheck::getAcademicId())->where('attendance_date', 'like', $request->year . '-' . $request->month . '%')->where('academic_id', YearCheck::getAcademicId())->where('school_id',Auth::user()->school_id)->get();
            $academic_years = SmAcademicYear::where('active_status', '=', 1)->where('school_id',Auth::user()->school_id)->get();
            // dd($attendances);
            return view('backEnd.parentPanel.attendance', compact('attendances', 'days', 'year', 'month', 'current_day', 'student_detail', 'academic_years'));
        } catch (\Exception $e) {
            // dd($e);
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function attendancePrint($student_id, $month, $year)
    {
        try {
            $student_detail = SmStudent::where('id', $student_id)->first();
            $current_day = date('d');
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            //$students = SmStudent::where('class_id', $request->class)->where('section_id', $request->section)->where('school_id',Auth::user()->school_id)->get();
            $attendances = SmStudentAttendance::where('student_id', $student_detail->id)->where('attendance_date', 'like', $year . '-' . $month . '%')->where('school_id', Auth::user()->school_id)->get();
            $customPaper = array(0, 0, 700.00, 1000.80);
            $pdf = PDF::loadView(
                'backEnd.parentPanel.attendance_print',
                [
                    'attendances' => $attendances,
                    'days' => $days,
                    'year' => $year,
                    'month' => $month,
                    'current_day' => $current_day,
                    'student_detail' => $student_detail
                ]
            )->setPaper('A4', 'landscape');
            return $pdf->stream('my_child_attendance.pdf');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function examinationSchedule($id)
    {

        try {
            // return $id;
            $user = Auth::user();
            $parent = SmParent::where('user_id', $user->id)->first();
            $student_detail = SmStudent::where('id', $id)->first();
            $student_id = $student_detail->id;
            // return $student_detail;
            $exam_types = SmExamType::where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            return view('backEnd.parentPanel.parent_exam_schedule', compact('exam_types', 'student_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function parentBookList()
    {

        try {
            $books = SmBook::where('active_status', 1)
                ->orderBy('id', 'DESC')
                ->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.parentPanel.parentBookList', compact('books'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function parentBookIssue()
    {
        try {
            $user = Auth::user();
            $parent_detail = SmParent::where('user_id', $user->id)->first();
            $books = SmBook::select('id', 'book_title')->where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            $subjects = SmSubject::select('id', 'subject_name')->where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            $library_member = SmLibraryMember::where('member_type', 3)->where('student_staff_id', $parent_detail->user_id)->first();
            // return $library_member;
            if (empty($library_member)) {
                Toastr::error('You are not library member ! Please contact with librarian', 'Failed');
                return redirect()->back();
                // return redirect()->back()->with('message-danger', 'You are not library member ! Please contact with librarian');
            }
            $issueBooks = SmBookIssue::where('member_id', $library_member->student_staff_id)->where('issue_status', 'I')->where('school_id', Auth::user()->school_id)->get();

            return view('backEnd.parentPanel.parentBookIssue', compact('books', 'subjects', 'issueBooks'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function examinationScheduleSearch(Request $request)
    {
        // return $request;
        $request->validate([
            'exam' => 'required',
        ]);
        try {
            $user = Auth::user();
            $parent = SmParent::where('user_id', $user->id)->first();
            $student_detail = SmStudent::where('id', $request->student_id)->first();
            $student_id = $student_detail->id;
            $assign_subjects = SmAssignSubject::where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            // return  $assign_subjects;
            if ($assign_subjects->count() == 0) {
                Toastr::error('No Subject Assigned. Please assign subjects in this class.', 'Failed');
                return redirect()->back();
                // return redirect()->back()->with('message-danger', 'No Subject Assigned. Please assign subjects in this class.');
            }

            $exams = SmExam::where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $class_id = $student_detail->class_id;
            $section_id = $student_detail->section_id;
            $exam_id = $request->exam;

            $exam_types = SmExamType::where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $exam_periods = SmClassTime::where('type', 'exam')->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $exam_schedule_subjects = "";
            $assign_subject_check = "";

            return view('backEnd.parentPanel.parent_exam_schedule', compact('exams', 'assign_subjects', 'class_id', 'section_id', 'exam_id', 'exam_schedule_subjects', 'assign_subject_check', 'exam_types', 'exam_periods', 'student_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function examination($id)
    {
        try {
            $student_detail = SmStudent::where('id', $id)->first();
            $exams = SmExamSchedule::where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->where('school_id', Auth::user()->school_id)->get();
            $grades = SmMarksGrade::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            $exam_terms = SmExamType::where('school_id', Auth::user()->school_id)->where('academic_id', YearCheck::getAcademicId())->get();

            return view('backEnd.parentPanel.student_result', compact('student_detail', 'exams', 'grades','exam_terms'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function subjects($id)
    {
        try {
            $student_detail = SmStudent::where('id', $id)->first();
            $assignSubjects = SmAssignSubject::where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.parentPanel.subject', compact('assignSubjects', 'student_detail'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function teacherList($id)
    {
        try {
            $student_detail = SmStudent::where('id', $id)->first();
            $teachers = SmAssignSubject::where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->get()->unique('teacher_id');
            return view('backEnd.parentPanel.teacher_list', compact('teachers', 'student_detail'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function transport($id)
    {
        try {
            $student_detail = SmStudent::where('id', $id)->first();
            $routes = SmAssignVehicle::join('sm_vehicles', 'sm_assign_vehicles.vehicle_id', 'sm_vehicles.id')
            ->join('sm_students', 'sm_vehicles.id', 'sm_students.vechile_id')
            ->where('sm_assign_vehicles.active_status', 1)
            ->where('sm_students.parent_id', Auth::user()->id)
            ->where('sm_assign_vehicles.school_id',Auth::user()->school_id)
            ->get();
            // $routes = SmAssignVehicle::where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.parentPanel.transport', compact('routes', 'student_detail'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function dormitory($id)
    {
        try {
            $student_detail = SmStudent::where('id', $id)->first();
            // return $student_detail;
            $room_lists = SmRoomList::where('active_status', 1)->where('id', $student_detail->room_id)->where('school_id', Auth::user()->school_id)->get();
            $room_lists = $room_lists->groupBy('dormitory_id');
            $room_types = SmRoomType::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            $dormitory_lists = SmDormitoryList::where('active_status', 1)->where('id', $student_detail->dormitory_id)->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.parentPanel.dormitory', compact('room_lists', 'room_types', 'dormitory_lists', 'student_detail'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function homework($id)
    {
        try {
            $student_detail = SmStudent::where('id', $id)->first();
            $homeworkLists = SmHomework::where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.parentPanel.homework', compact('homeworkLists', 'student_detail'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function homeworkView($class_id, $section_id, $homework_id)
    {
        try {
            $homeworkDetails = SmHomework::where('class_id', '=', $class_id)->where('section_id', '=', $section_id)->where('id', '=', $homework_id)->first();
            return view('backEnd.parentPanel.homeworkView', compact('homeworkDetails', 'homework_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function parentNoticeboard()
    {
        try {
            $allNotices = SmNoticeBoard::where('active_status', 1)->where('inform_to', 'LIKE', '%3%')
                ->orderBy('id', 'DESC')
                ->where('academic_id', YearCheck::getAcademicId())
                ->where('school_id', Auth::user()->school_id)->get();

            return view('backEnd.parentPanel.parentNoticeboard', compact('allNotices'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function childListApi(Request $request, $id)
    {
        try {
            $parent = SmParent::where('user_id', $id)->first();
            $student_info = DB::table('sm_students')
                ->join('sm_classes', 'sm_classes.id', '=', 'sm_students.class_id')
                ->join('sm_sections', 'sm_sections.id', '=', 'sm_students.section_id')
                // ->join('sm_exams','sm_exams.id','=','sm_exam_types.id' )
                // ->join('sm_subjects','sm_subjects.id','=','sm_result_stores.subject_id' )

                ->where('sm_students.parent_id', '=', $parent->id)


                ->select('sm_students.user_id', 'student_photo', 'sm_students.full_name as student_name', 'class_name', 'section_name', 'roll_no')

                ->where('sm_students.school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {


                return ApiBaseMethod::sendResponse($student_info, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function childProfileApi(Request $request, $id)
    {
        try {
            $student_detail = SmStudent::where('id', $id)->first();
            $siblings = SmStudent::where('parent_id', $student_detail->parent_id)->where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            $fees_assigneds = SmFeesAssign::where('student_id', $student_detail->id)->where('school_id', Auth::user()->school_id)->get();
            $fees_discounts = SmFeesAssignDiscount::where('student_id', $student_detail->id)->where('school_id', Auth::user()->school_id)->get();
            $documents = SmStudentDocument::where('student_staff_id', $student_detail->id)->where('type', 'stu')->where('school_id', Auth::user()->school_id)->get();
            $timelines = SmStudentTimeline::where('staff_student_id', $student_detail->id)->where('type', 'stu')->where('visible_to_student', 1)->where('school_id', Auth::user()->school_id)->get();
            $exams = SmExamSchedule::where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->where('school_id', Auth::user()->school_id)->get();
            $grades = SmMarksGrade::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['student_detail'] = $student_detail->toArray();
                $data['fees_assigneds'] = $fees_assigneds->toArray();
                $data['fees_discounts'] = $fees_discounts->toArray();
                $data['exams'] = $exams->toArray();
                $data['documents'] = $documents->toArray();
                $data['timelines'] = $timelines->toArray();
                $data['siblings'] = $siblings->toArray();
                $data['grades'] = $grades->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }

            //return view('backEnd.studentPanel.my_profile', compact('student_detail', 'fees_assigneds', 'fees_discounts', 'exams', 'documents', 'timelines', 'siblings', 'grades'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function collectFeesChildApi(Request $request, $id)
    {
        try {
            $student = SmStudent::where('id', $id)->first();
            $fees_assigneds = SmFeesAssign::where('student_id', $id)->orderBy('id', 'desc')->where('school_id', Auth::user()->school_id)->get();

            $fees_assigneds2 = DB::table('sm_fees_assigns')
                ->select('sm_fees_types.id as fees_type_id', 'sm_fees_types.name', 'sm_fees_masters.date as due_date', 'sm_fees_masters.amount as amount')
                ->join('sm_fees_masters', 'sm_fees_masters.id', '=', 'sm_fees_assigns.fees_master_id')
                ->join('sm_fees_types', 'sm_fees_types.id', '=', 'sm_fees_masters.fees_type_id')
                ->join('sm_fees_payments', 'sm_fees_payments.fees_type_id', '=', 'sm_fees_masters.fees_type_id')
                ->where('sm_fees_assigns.student_id', $student->id)
                //->where('sm_fees_payments.student_id', $student->id)
                ->where('sm_fees_assigns.school_id', Auth::user()->school_id)->get();
            $i = 0;
            return $fees_assigneds2;
            foreach ($fees_assigneds2 as $row) {
                $d[$i]['fees_name'] = $row->name;
                $d[$i]['due_date'] = $row->due_date;
                $d[$i]['amount'] = $row->amount;
                $d[$i]['paid'] = DB::table('sm_fees_payments')->where('fees_type_id', $row->fees_type_id)->sum('amount');
                $d[$i]['fine'] = DB::table('sm_fees_payments')->where('fees_type_id', $row->fees_type_id)->sum('fine');
                $d[$i]['discount_amount'] = DB::table('sm_fees_payments')->where('fees_type_id', $row->fees_type_id)->sum('discount_amount');
                $d[$i]['balance'] = ((float) $d[$i]['amount'] + (float) $d[$i]['fine'])  - ((float) $d[$i]['paid'] + (float) $d[$i]['discount_amount']);
                $i++;
            }

            //dd($fees_assigneds2);
            //, DB::raw("SUM(sm_fees_payments.amount) as total_paid where sm_fees_payments.fees_type_id==")
            $fees_discounts = SmFeesAssignDiscount::where('student_id', $id)->where('school_id', Auth::user()->school_id)->get();

            $applied_discount = [];
            foreach ($fees_discounts as $fees_discount) {
                $fees_payment = SmFeesPayment::select('fees_discount_id')->where('fees_discount_id', $fees_discount->id)->first();
                if (isset($fees_payment->fees_discount_id)) {
                    $applied_discount[] = $fees_payment->fees_discount_id;
                }
            }

            //dd($fees_discounts);


            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                // $data['student'] = $student;
                $data['fees'] = $d;
                return ApiBaseMethod::sendResponse($fees_assigneds2, null);
            }

            return view('backEnd.feesCollection.collect_fees_student_wise', compact('student', 'fees_assigneds', 'fees_discounts', 'applied_discount'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function classRoutineApi(Request $request, $id)
    {
        try {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $user_id = $id;
            } else {
                $user = Auth::user();

                if ($user) {
                    $user_id = $user->id;
                } else {
                    $user_id = $request->user_id;
                }
            }

            $student_detail = SmStudent::where('id', $id)->first();
            //return $student_detail;
            $class_id = $student_detail->class_id;
            $section_id = $student_detail->section_id;

            $sm_weekends = SmWeekend::where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->orderBy('order', 'ASC')->where('active_status', 1)->get();
            $class_times = SmClassTime::where('type', 'class')->where('school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['student_detail'] = $student_detail->toArray();
                // $data['class_id'] = $class_id;
                // $data['section_id'] = $section_id;
                // $data['sm_weekends'] = $sm_weekends->toArray();
                // $data['class_times'] = $class_times->toArray();

                $weekenD = SmWeekend::where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();

                foreach ($weekenD as $row) {
                    $data[$row->name] = DB::table('sm_class_routine_updates')
                        ->select('sm_class_times.period', 'sm_class_times.start_time', 'sm_class_times.end_time', 'sm_subjects.subject_name', 'sm_class_rooms.room_no')
                        ->join('sm_classes', 'sm_classes.id', '=', 'sm_class_routine_updates.class_id')
                        ->join('sm_sections', 'sm_sections.id', '=', 'sm_class_routine_updates.section_id')
                        ->join('sm_class_times', 'sm_class_times.id', '=', 'sm_class_routine_updates.class_period_id')
                        ->join('sm_subjects', 'sm_subjects.id', '=', 'sm_class_routine_updates.subject_id')
                        ->join('sm_class_rooms', 'sm_class_rooms.id', '=', 'sm_class_routine_updates.room_id')

                        ->where([
                            ['sm_class_routine_updates.class_id', $class_id], ['sm_class_routine_updates.section_id', $section_id], ['sm_class_routine_updates.day', $row->id],
                        ])->where('sm_classes.school_id', Auth::user()->school_id)->get();
                }

                return ApiBaseMethod::sendResponse($data, null);
            }

            //return view('backEnd.studentPanel.class_routine', compact('class_times', 'class_id', 'section_id', 'sm_weekends'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function childHomework(Request $request, $id)
    {
        try {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $student_detail = SmStudent::where('id', $id)->first();

                $class_id = $student_detail->class->id;
                $subject_list = SmAssignSubject::where([['class_id', $class_id], ['section_id', $student_detail->section_id]])->where('school_id', Auth::user()->school_id)->get();

                $i = 0;
                foreach ($subject_list as $subject) {
                    $homework_subject_list[$subject->subject->subject_name] = $subject->subject->subject_name;
                    $allList[$subject->subject->subject_name] =
                        DB::table('sm_homeworks')
                        ->select('sm_homeworks.description', 'sm_subjects.subject_name', 'sm_homeworks.homework_date', 'sm_homeworks.submission_date', 'sm_homeworks.evaluation_date', 'sm_homeworks.file', 'sm_homeworks.marks', 'sm_homework_students.complete_status as status')
                        ->leftjoin('sm_homework_students', 'sm_homework_students.homework_id', '=', 'sm_homeworks.id')
                        ->leftjoin('sm_subjects', 'sm_subjects.id', '=', 'sm_homeworks.subject_id')
                        ->where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->where('subject_id', $subject->subject_id)->where('sm_homeworks.school_id', Auth::user()->school_id)->get();
                }
                //return $h;

                $homeworkLists = SmHomework::where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->where('school_id', Auth::user()->school_id)->get();
            }
            // dd($allList);
            $data = [];

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                foreach ($allList as $r) {
                    foreach ($r as $s) {
                        $data[] = $s;
                    }
                }
                return ApiBaseMethod::sendResponse($data, null);
            }
            // return view('backEnd.studentPanel.student_homework', compact('homeworkLists', 'student_detail'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function childAttendanceAPI(Request $request, $id)
    {

        $input = $request->all();

        $validator = Validator::make($input, [
            'month' => "required",
            'year' => "required",
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $student_detail = SmStudent::where('id', $id)->first();

            $year = $request->year;
            $month = $request->month;
            if ($month < 10) {
                $month = '0' . $month;
            }
            $current_day = date('d');

            $days = cal_days_in_month(CAL_GREGORIAN, $month, $request->year);
            $days2 = cal_days_in_month(CAL_GREGORIAN, $month - 1, $request->year);
            $previous_month = $month - 1;
            $previous_date = $year . '-' . $previous_month . '-' . $days2;
            $previousMonthDetails['date'] = $previous_date;
            $previousMonthDetails['day'] = $days2;
            $previousMonthDetails['week_name'] = date('D', strtotime($previous_date));
            $attendances = SmStudentAttendance::where('student_id', $student_detail->id)
                ->where('attendance_date', 'like', '%' . $request->year . '-' . $month . '%')
                ->select('attendance_type', 'attendance_date')
                ->where('school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data['attendances'] = $attendances;
                $data['previousMonthDetails'] = $previousMonthDetails;
                $data['days'] = $days;
                $data['year'] = $year;
                $data['month'] = $month;
                $data['current_day'] = $current_day;
                $data['status'] = 'Present: P, Late: L, Absent: A, Holiday: H, Half Day: F';
                return ApiBaseMethod::sendResponse($data, null);
            }
            //Test
            //return view('backEnd.studentPanel.student_attendance', compact('attendances', 'days', 'year', 'month', 'current_day'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function aboutApi(request $request)
    {
        try {
            $about = DB::table('sm_general_settings')
                ->join('sm_languages', 'sm_general_settings.language_id', '=', 'sm_languages.id')
                ->join('sm_academic_years', 'sm_general_settings.session_id', '=', 'sm_academic_years.id')
                ->join('sm_about_pages', 'sm_general_settings.school_id', '=', 'sm_about_pages.school_id')
                ->select('main_description', 'school_name', 'site_title', 'school_code', 'address', 'phone', 'email', 'logo', 'sm_languages.language_name', 'year as session', 'copyright_text')
                ->where('sm_general_settings.school_id', Auth::user()->school_id)->first();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {

                return ApiBaseMethod::sendResponse($about, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    function StudentDownload($file_name)
    {
        try {
            $file = public_path() . '/uploads/student/timeline/' . $file_name;
            if (file_exists($file)) {
                return Response::download($file);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}