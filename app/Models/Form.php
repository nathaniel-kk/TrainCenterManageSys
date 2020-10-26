<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LaboratoryLoan;
use App\Models\Laboratory;
use App\Models\Clas;

class Form extends Model
{
    protected $table = "form";
    public $timestamps = true;
    protected $guarded = [];
    public $primaryKey = "form_id";


    /**
     * 展示所有待审批表单
     * @auther ZhongChun <github.com/RobbEr929>
     * @param $request
     * return [string]
     */
    public static function zc_show($request)
    {
        try {
            $info  = getDinginfo($request['code']);
            $role = $info->role;
            $name = $info->name;
            if($role=="借用部门负责人"){
                $rule = 1;
            }elseif($role=="实验室借用管理员"){
                $rule = 3;
            }elseif($role=="实验室中心主任"){
                $rule = 5;
            }elseif($role=="设备管理员"){
                $rule = 7;
            }
            $res = Form::join('form_type','form.type_id','form_type.type_id')
                ->select('form.form_id','form.applicant_name','form_type.type_name')
                ->where('form.applicant_name','!=',$name)
                ->where('form.form_status','=',$rule)
                ->orderBy('form.created_at','desc')
                ->get();
            return $res?
                $res:
                false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }

    /**
     * 分类查询待审批表单
     * @auther ZhongChun <github.com/RobbEr929>
     * @param $request
     * return [string]
     */
    public static function zc_classify($request)
    {
        try {
            $info  = getDinginfo($request['code']);
            $role = $info->role;
            $name = $info->name;
            if($role=="借用部门负责人"){
                $rule = 1;
            }elseif($role=="实验室借用管理员"){
                $rule = 3;
            }elseif($role=="实验室中心主任"){
                $rule = 5;
            }elseif($role=="设备管理员"){
                $rule = 7;
            }
            $res = Form::join('form_type','form.type_id','form_type.type_id')
                ->select('form.form_id','form.applicant_name','form_type.type_name')
                ->where('form.applicant_name','!=',$name)
                ->where('form.form_status','=',$rule)
                ->where('type_name','=',$request['type_name'])
                ->orderBy('form.created_at','desc')
                ->get();
            return $res?
                $res:
                false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }

    /**
     * 分类查询待审批表单
     * @auther ZhongChun <github.com/RobbEr929>
     * @param $request
     * return [string]
     */
    public static function zc_select($request)
    {
        try {
            $info  = getDinginfo($request['code']);
            $role = $info->role;
            $name = $info->name;
            if($role=="借用部门负责人"){
                $rule = 1;
            }elseif($role=="实验室借用管理员"){
                $rule = 3;
            }elseif($role=="实验室中心主任"){
                $rule = 5;
            }elseif($role=="设备管理员"){
                $rule = 7;
            }
            $data = $request['data'];
            $res = Form::join('form_type','form.type_id','form_type.type_id')
                ->select('form.form_id','form.applicant_name','form_type.type_name')
                ->where('form.applicant_name','!=',$name)
                ->where('form.form_status','=',$rule)
                ->where('form.form_id','=',$data)
                ->orWhere('form.applicant_name','=',$data)
                ->orderBy('form.created_at','desc')
                ->get();
            return $res?
                $res:
                false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }

    /**
     * 分类查询待审批表单
     * @auther ZhongChun <github.com/RobbEr929>
     * @param $request
     * return [string]
     */
    public static function zc_reShow($request)
    {
        try {
            $zc = Form::where('form_id','=',$request['form_id'])
                ->value('type_id');
            return $zc?
                $zc:
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
    public static function zc_reShowSys($request)
    {
        try {
        $res = LaboratoryLoan::join('laboratory', 'laboratory_loan.laboratory_id', 'laboratory.laboratory_id')
            ->join('class', 'laboratory_loan.class_id', 'class.class_id')
            ->join('form','laboratory_loan.form_id','form.form_id')
            ->select('laboratory_loan.*', 'laboratory.laboratory_name', 'class.class_name','form.applicant_name')
            ->where('laboratory_loan.form_id',$request['form_id'])
            ->get();
        return $res?
            $res:
            false;
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
    public static function zc_reShowOpenSys($request)
    {
        try {
            $res1 = OpenLaboratoryLoan::join('form','open_laboratory_loan.form_id','form.form_id')
                ->select('open_laboratory_loan.*','form.applicant_name')
                ->where('open_laboratory_loan.form_id',$request['form_id'])
                ->get();
            $res2 = OpenLaboratoryStudentList::where('form_id',$request['form_id'])
                ->get();
            $res1['data']=$res2;
            return $res1?
                $res1:
                false;
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
    public static function zc_reShowSysIns($request)
    {
        try {
            $res1 = EquipmentBorrow::where('form_id','=',$request['form_id'])
                ->get();
            $res2 = EquipmentBorrowChecklist::join('equipment','equipment.equipment_id','equipment_borrow_checklist.equipment_id')
                ->where('equipment_borrow_checklist.form_id','=',$request['form_id'])
                ->get();
            $res1['data']=$res2;
            return $res1?
                $res1:
                false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }
}


