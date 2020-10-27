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
    public static function zc_show($code)
    {
        try {
            $info  = getDinginfo($code);
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
    public static function zc_classify($code,$type_name)
    {
        try {
            $info  = getDinginfo($code);
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
                ->where('type_name','=',$type_name)
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
    public static function zc_select($code,$data)
    {
        try {
            $info  = getDinginfo($code);
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
    public static function zc_reShow($form_id)
    {
        try {
            $zc = Form::where('form_id','=',$form_id)
                ->value('type_id');
            return $zc?
                $zc:
                false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }
}


