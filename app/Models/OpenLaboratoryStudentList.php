<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenLaboratoryStudentList extends Model
{
    protected $table = "open_laboratory_student_list";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 开放实验室使用申请填报
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [String] $code
     * @return array
     */
    Public static function hwc_openLabUseBor($form_id,$infor){
        try {
            for ($i=0;$i<count($infor);$i++) {
                $data = self::create([
                    'form_id' => $form_id,
                    'student_name' => $infor[$i]['student_name'],
                    'student_id' => $infor[$i]['student_id'],
                    'work' => $infor[$i]['work'],
                    'phone' => $infor[$i]['phone'],
                ]);
            }
            return $data;
        } catch(\Exception $e){
            logError('开放实验室使用申请填报错误',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 开放实验室使用申请人员名单展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [String] $form_id
     * @return array
     */
    Public static function hwc_viewOpenLabManUse($form_id){
        try {
            $data = self::where('form_id',$form_id)
                ->select('student_name','student_id','phone','work')
                ->get();
            return $data;
        } catch(\Exception $e){
            logError('开放实验室使用申请人员名单展示错误',[$e->getMessage()]);
            return null;
        }
    }
}
