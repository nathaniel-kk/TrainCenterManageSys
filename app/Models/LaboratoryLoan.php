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
    /**
     * 实验室借用申请表单展示
     * @param $request
     * @return false
     * @author yangsiqi <github.com/Double-R111>
     */
    public static function ysq_reshowLab($form_id, $code)
    {
        try {
            $info = getDinginfo($code);
            $role = $info->role;
            $name = $info->name;
            if ($role == "借用部门负责人") {
                $lev = 1;
            } elseif ($role == "实验室借用管理员") {
                $lev = 3;
            } elseif ($role == "实验室中心主任") {
                $lev = 5;
            } elseif ($role == "设备管理员") {
                $lev = 7;
            }
            $data['laboratory_loan'] = LaboratoryLoan::join('laboratory', 'laboratory_loan.laboratory_id', 'laboratory.laboratory_id')
                ->join('class', 'laboratory_loan.class_id', 'class.class_id')
                ->join('form', 'laboratory_loan.form_id', 'form.form_id')
                ->select('laboratory_loan.*', 'laboratory.laboratory_name', 'class.class_name', 'form.applicant_name', 'form.created_at')
                ->where('laboratory_loan.form_id', $form_id)
                ->get();
            $data1 = Form::join('form_type', 'form.type_id', 'form_type.type_id')
                ->join('form_status', 'form_status.status_id', 'form.form_status')
                ->join('approve', 'form.form_id', 'approve.form_id')
                ->select('form_type.type_name', 'form_status.status_name', 'approve.reason')
                ->where('approve.borrowing_department_name', '=', $name)
                ->orwhere('approve.borrowing_manager_name', '=', $name)
                ->where('approve.center_director_name', '=', $name)
                ->orwhere('approve.device_administrator_out_name', '=', $name)
                ->where('approve.device_administrator_acceptance_name', '=', $name)
                ->where('form.form_status', '=', $lev)
                ->get();
            $data['other_information'] = $data1;
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('实验室表单详情搜索出错', [$e->getMessage()]);
            return false;
        }
    }
//join('approve', 'form.form_id', 'approve.form_id')
//
//

}
