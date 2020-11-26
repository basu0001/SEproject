<?php

namespace App\Imports;

use App\StudentAttendanceBulk;
use App\SmStudentAttendanceImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class StudentAttendanceImport implements ToModel, WithStartRow, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
     
        return new StudentAttendanceBulk([
            "attendance_date" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['attendance_date'])->format('Y-m-d'),
            // "in_time" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['in_time'])->format('h:i A'),
            // "out_time" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['out_time'])->format('h:i A'),
            "attendance_type" => $row['attendance_type'],
            "note" => $row['note'],
            "student_id" => $row['student_id'],         
            "class_id" => $row['class_id'],         
            "section_id" => $row['section_id'],         
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }

}