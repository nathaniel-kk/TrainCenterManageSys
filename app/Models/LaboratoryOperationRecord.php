<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaboratoryOperationRecord extends Model
{
    protected $table = "laboratory_operation_records";
    public $timestamps = true;
    protected $guarded = [];


    public static function abc()
    {
        $data = self::select('*')->get();
        return $data;
    }
    /**
     * 填报入库
     * @param $form_id
     * @param $laboratory_name
     * @param $week
     * @param $class_name
     * @param $clas_name
     * @param $number
     * @param $class_type
     * @param $teacher
     * @param $situation
     * @param $remark
     * @return |null
     */
    public static function lzz_operationReport($form_id,$laboratory_name,$week,$class_name,$clas_name,$number,$class_type, $teacher,$situation,$remark){
        try {
         $class_number = Clas::where('class_name',$class_name)
             ->pluck('class_id');
    $laboratory_id = Laboratory::where('laboratory_name',$laboratory_name)
        ->pluck('laboratory_id');
        $data = LaboratoryOperationRecord::insert([
            'form_id' =>$form_id,
           'laboratory_id'=> $laboratory_id[0],
           'week' => $week,
           'class_id' => $class_number[0],
            'class_name'=>$clas_name,
            'number' => $number,
           'class_type'  => $class_type,
           'teacher' => $teacher,
           'situation' =>$situation,
            'remark' =>$remark,
            'time' => now(),
            'created_at'=>now()
        ]);
            return $data;
        } catch(\Exception $e){
            logError('实验室运行记录填报错误',[$e->getMessage()]);
            return null;
        }
    }

    /**
     *实验室运行记录展示
     * @param $form_id
     * @return |null
     */
    public static function lzz_formView($form_id){
        try {
            $date = self::where('form_id',$form_id)
                         ->pluck('class_id');
            $data = self::join('form','form.form_id','laboratory_operation_records.form_id')
                    ->join('class','class.class_id','laboratory_operation_records.class_id')
                    ->where('class.class_id',$date[0])
                     ->where('laboratory_operation_records.form_id',$form_id)
                      ->select(
                          'laboratory_operation_records.form_id',
                         'laboratory_operation_records.week',
                         'class.class_name as classname',
                          'form.applicant_name',
                          'laboratory_operation_records.number',
                          'laboratory_operation_records.class_name',
                          'laboratory_operation_records.class_type',
                          'laboratory_operation_records.teacher',
                          'laboratory_operation_records.situation',
                            'laboratory_operation_records.remark',
                            'laboratory_operation_records.created_at')
                     ->get();
            return $data;
        } catch(\Exception $e){
            logError('实验室运行记录填报错误',[$e->getMessage()]);
            return null;
        }
    }
}

