<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OpenLaboratoryStudentList;

class OpenLaboratoryLoan extends Model
{
    protected $table = "open_laboratory_loan";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 开放实验室表单详情展示
     * @param $request
     * @return false
     * @author yangsiqi <github.com/Double-R111>
     */
    public static function ysq_reshowOpenLab($form_id, $code)
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
            $data['open_laboratory_loan'] = OpenLaboratoryLoan::join('form', 'open_laboratory_loan.form_id', 'form.form_id')
                ->select('open_laboratory_loan.*', 'form.applicant_name', 'form.created_at')
                ->where('open_laboratory_loan.form_id', $form_id)
                ->get();
            $data2 = OpenLaboratoryStudentList::where('form_id', $form_id)
                ->get();
            $data3 = Form::join('form_type', 'form.type_id', 'form_type.type_id')
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
            $data['open_laboratory_student_list'] = $data2;
            $data['other_information'] = $data3;
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }

    /**
     * 回显开放实验室使用申请
     * @auther ZhongChun <github.com/RobbEr929>
     * @param $request
     * return [string]
     */
    public static function zc_reShowOpenSys($form_id)
    {
        try {
            $res1 = OpenLaboratoryLoan::join('form', 'open_laboratory_loan.form_id', 'form.form_id')
                ->select('open_laboratory_loan.*', 'form.applicant_name')
                ->where('open_laboratory_loan.form_id', $form_id)
                ->get();
            $res2 = OpenLaboratoryStudentList::where('form_id', $form_id)
                ->get();

            $res=[
                "open_lab"=>$res1,
                "open_lab_list"=>$res2
            ];
            return $res?
            $res:
             false;

        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }


    /**
     * 回显实验室借用申请
     * @auther ZhongChun <github.com/RobbEr929>
     * @param $request
     * return [string]
     */
    public static function zc_reShowSys($form_id)
    {
        try {
            $res = LaboratoryLoan::join('laboratory', 'laboratory_loan.laboratory_id', 'laboratory.laboratory_id')
                ->join('class', 'laboratory_loan.class_id', 'class.class_id')
                ->join('form', 'laboratory_loan.form_id', 'form.form_id')
                ->select('laboratory_loan.*', 'laboratory.laboratory_name', 'class.class_name', 'form.applicant_name')
                ->where('laboratory_loan.form_id', $form_id)
                ->get();
            return $res ?
                $res :
                false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }
}
