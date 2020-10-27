<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaboratoryLoan extends Model
{

    protected $table = "laboratory_loan";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 填报实验室借用申请
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @return array
     */
    public static function hwc_fillLabBorrow($code,$form_id,$laboratory_id,$course_name,$class_id,$number,$purpose,$start_time,$end_time,$start_class,$end_class){
        try {
            $data = self::create([
                'form_id' => $form_id,
                'laboratory_id' => $laboratory_id,
                'course_name' => $course_name,
                'class_id' => $class_id,
                'number' => $number,
                'purpose' => $purpose,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'start_class' => $start_class,
                'end_class' => $end_class,
                'phone' => getDinginfo($code)->tel,
            ]);
            return $data;
        } catch(\Exception $e){
            logError('填报实验室借用申请错误',[$e->getMessage()]);
            return null;
        }
    }
}
