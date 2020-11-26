<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmStudent extends Model
{
    public function parents()
    {
        return $this->belongsTo('App\SmParent', 'parent_id', 'id');
    }
    public function drivers()
    {
        return $this->belongsTo('App\SmStaff', 'driver_id', 'id');
    }

    public function className()
    {
        return $this->belongsTo('App\SmClass', 'class_id', 'id');
    }

    public function gender()
    {
        return $this->belongsTo('App\SmBaseSetup', 'gender_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo('App\SmSchool', 'school_id', 'id');
    }

    public function religion()
    {
        return $this->belongsTo('App\SmBaseSetup', 'religion_id', 'id');
    }

    public function bloodGroup()
    {
        return $this->belongsTo('App\SmBaseSetup', 'bloodgroup_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\SmStudentCategory', 'student_category_id', 'id');
    }

    public function session()
    {
        return $this->belongsTo('App\SmSession', 'session_id', 'id');
    }

    public function academicYear()
    {
        return $this->belongsTo('App\SmAcademicYear', 'session_id', 'id');
    }
    //student class name
    public function class()
    {
        return $this->belongsTo('App\SmClass', 'class_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo('App\SmSection', 'section_id', 'id');
    }
    public function route()
    {
        return $this->belongsTo('App\SmRoute', 'route_list_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\SmVehicle', 'vechile_id', 'id');
    }

    public function dormitory()
    {
        return $this->belongsTo('App\SmDormitoryList', 'dormitory_id', 'id');
    }


    public function sections()
    {
        return $this->hasManyThrough('App\SmSection', 'App\SmClassSection', 'class_id', 'id', 'class_id', 'section_id');
    }

    public function rooms()
    {
        return $this->hasMany('App\SmRoomList', 'dormitory_id', 'dormitory_id');
    }

    public function room()
    {
        return $this->belongsTo('App\SmRoomList', 'room_id', 'id');
    }
    public function attendanceStudents()
    {
        return $this->belongsTo('App\SmStudentAttendance');
    }
    public function forwardBalance()
    {
        return $this->belongsTo('App\SmFeesCarryForward', 'id', 'student_id');
    }
    public function meritList()
    {
        return $this->belongsTo('App\SmTemporaryMeritlist', 'id', 'student_id');
    }

    public function feesAssign()
    {
        return $this->hasMany('App\SmFeesAssign', 'student_id', 'id');
    }

    public static function totalFees($feesAssigns)
    {

        try {
            $amount = 0;
            foreach ($feesAssigns as $feesAssign) {
                $master = SmFeesMaster::select('fees_group_id', 'amount')->where('id', $feesAssign->fees_master_id)->first();
                $amount += $master->amount;
            }
            return $amount;
        } catch (\Exception $e) {
            $data = [];
            $data[0] = $e->getMessage();
            return $data;
        }
    }

    public static function totalDeposit($feesAssigns, $student_id)
    {

        try {
            $amount = 0;
            foreach ($feesAssigns as $feesAssign) {
                $fees_type = SmFeesMaster::select('fees_type_id')->where('id', $feesAssign->fees_master_id)->first();
                $amount += SmFeesPayment::where('fees_type_id', $fees_type->fees_type_id)->where('student_id', $student_id)->sum('amount');
            }
            return $amount;
        } catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }
    public static function totalDiscount($feesAssigns, $student_id)
    {

        try {
            $amount = 0;
            foreach ($feesAssigns as $feesAssign) {
                $fees_type = SmFeesMaster::select('fees_type_id')->where('id', $feesAssign->fees_master_id)->first();
                $amount += SmFeesPayment::where('fees_type_id', $fees_type->fees_type_id)->where('student_id', $student_id)->sum('discount_amount');
            }
            return $amount;
        } catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }
    public static function totalFine($feesAssigns, $student_id)
    {

        try {
            $amount = 0;
            foreach ($feesAssigns as $feesAssign) {
                $fees_type = SmFeesMaster::select('fees_type_id')->where('id', $feesAssign->fees_master_id)->first();
                $amount += SmFeesPayment::where('fees_type_id', $fees_type->fees_type_id)->where('student_id', $student_id)->sum('fine');
            }
            return $amount;
        } catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public static function marks($exam_id, $s_id)
    {

        try {
            $marks_register = SmMarksRegister::where('exam_id', $exam_id)->where('student_id', $s_id)->first();
            $marks_register_clilds = [];
            if ($marks_register != "") {
                $marks_register_clilds = SmMarksRegisterChild::where('marks_register_id', $marks_register->id)->where('active_status', 1)->get();
            }
            return $marks_register_clilds;
        } catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    public static function fullMarks($exam_id, $sb_id)
    {
        try {
            return SmExamScheduleSubject::where('exam_schedule_id', $exam_id)->where('subject_id', $sb_id)->first();
        } catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    public static function fullMarksBySubject($exam_id, $sb_id)
    {
        try {
            return SmExamSetup::where('exam_term_id', $exam_id)->where('subject_id', $sb_id)->first();
        } catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    public static function scheduleBySubject($exam_id, $sb_id, $student_detail)
    {
        try {
            $schedule = SmExamSchedule::where('exam_term_id', $exam_id)->where('subject_id', $sb_id)->where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->first();
            return $schedule;
        } catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    public function promotion()
    {
        return $this->hasMany('App\SmStudentPromotion', 'student_id', 'id');
    }

    public static function classPromote($class)
    {

        try {
            $class = SmClass::where('id', $class)->first();
            return $class->class_name;
        } catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }

    public static function sessionPromote($session)
    {

        try {
            $session = SmSession::where('id', $session)->first();
            return $session->session;
        } catch (\Exception $e) {
            $data = [];
            return $data;
        }
    }


    public static function getExamResult($exam_id, $student)
    {
        $eligible_subjects       = SmAssignSubject::where('class_id', $student->class_id)->where('section_id', $student->section_id)->where('academic_id', YearCheck::getAcademicId())->where('school_id', \Auth::user()->school_id)->get();


        foreach ($eligible_subjects as $subject) {

            $getMark = SmResultStore::where([
                ['exam_type_id',   $exam_id],
                ['class_id',       $student->class_id],
                ['section_id',     $student->section_id],
                ['student_id',     $student->id],
                ['subject_id',     $subject->subject_id]
            ])->first();

            if ($getMark == "") {
                return false;
            }


            $result = SmResultStore::where([
                ['exam_type_id',   $exam_id],
                ['class_id',       $student->class_id],
                ['section_id',     $student->section_id],
                ['student_id',     $student->id]
            ])->get();

            return $result;
        }
    }


    // public function evaluationHomework(){
    //     return $this->belongsTo('App\SmHomework', 'session_id', 'id');
    // }





}
