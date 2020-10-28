<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentBorrow extends Model
{
    protected $table = "equipment_borrow";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 借用设备表单详情展示
     * @param $request
     * @return false
     * @author yangsiqi <github.com/Double-R111>
     */
    public static function ysq_reshowIns($form_id, $code)
    {
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
        try {
            $data['equipment_borrow'] = EquipmentBorrow::join('form', 'equipment_borrow.form_id', 'form.form_id')
                ->select('equipment_borrow.*', 'form.created_at')
                ->where('equipment_borrow.form_id', '=', $form_id)
                ->get();
            $data2 = EquipmentBorrowChecklist::join('equipment', 'equipment.equipment_id', 'equipment_borrow_checklist.equipment_id')
                ->where('equipment_borrow_checklist.form_id', '=', $form_id)
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
            $data['equipment_borrow_checklist'] = $data2;
            $data['other_information'] = $data3;
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }

    /* 回显开放实验室使用申请
    * @auther ZhongChun <github.com/RobbEr929>
    * @param $request
    * return [string]
    */
    public static function zc_reShowSysIns($form_id)
    {
        try {
            $res1 = EquipmentBorrow::where('form_id', '=', $form_id)
                ->get();
            $res2 = EquipmentBorrowChecklist::join('equipment', 'equipment.equipment_id', 'equipment_borrow_checklist.equipment_id')
                ->where('equipment_borrow_checklist.form_id', '=', $form_id)
                ->get();


            $res = [
                "equ_bro"=>$res1,
                "equ_bro_list"=>$res2
            ];
            return $res?
                $res:

                false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }
}
