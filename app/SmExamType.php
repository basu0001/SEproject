<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmExamType extends Model
{
    public static function examType($assinged_exam_type){
        try {
            return SmExamType::where('id', $assinged_exam_type)->first();
        } catch (\Exception $e) {
            $data=[];
            return $data;
        }
    }
}
