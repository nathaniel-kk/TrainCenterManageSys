<?php

namespace App\Models;

use App\Http\Requests\ShowAllRequest;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use App\Models\LaboratoryLoan;
use App\Models\Laboratory;
use App\Models\Clas;

class Form extends Model
{
    protected $table = "form";
    public $timestamps = true;
    protected $guarded = [];


    /**
     * 得到所有表单展示数据
     * @param $request
     * @return false
     * @author yangsiqi <github.com/Double-R111>
     */
    public static function ysq_getAll($request)
    {
        try {
            $info = getDinginfo($request['code']);
            $role = $info->role;
            $name = $info->name;
            if ($role == '借用部门负责人') {
                $lev = 1;
            } elseif ($role == '实验室借用管理员') {
                $lev = 3;
            } elseif ($role == '实验室中心主任') {
                $lev = 5;
            } elseif ($role == '设备管理员') {
                $lev = 7;
            }
            $data = Form::join('form_type', 'form.type_id', 'form_type.type_id')
                ->join('form_status', 'form.form_status', 'form_status.status_id')
                ->select('form.form_id', 'form.applicant_name', 'form_status.status_name', 'form_type.type_name')
                ->where('form.form_status', '=', $lev)
                ->where('form.applicant_name', '!=', $name)
                ->orderby('form.created_at', 'desc')
                ->get();
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('表单信息展示错误', [$e->getMessage()]);
             return false;
        }
    }



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
     * 通过申请人姓名和表单编号模糊查询表单
     * @author yangsiqi <github.com/Double-R111>
     * @param $request
     * @return false
     */
    public static function ysq_categoryQuery($request)
    {
        try {
            $num = $request['data'];
            $info = getDinginfo($request['code']);
            $role = $info->role;
            $name = $info->name;
            if ($role == '借用部门负责人') {
                $lev = 1;
            } elseif ($role == '实验室借用管理员') {
                $lev = 3;
            } elseif ($role == '实验室中心主任') {
                $lev = 5;
            } elseif ($role == '设备管理员') {
                $lev = 7;
            }
            $data = Form::join('form_type', 'form.type_id', 'form_type.type_id')
                ->join('form_status', 'form.form_status', 'form_status.status_id')
                ->select('form.form_id', 'form.applicant_name', 'form_type.type_name', '')
                ->where('form.applicant_name', '!=', $name)
                ->where('form.form_status', '=', $lev)
                ->where('form.form_id', '=', $num)
                ->orWhere('form.applicant_name', '=', $num)
                ->orderBy('form.created_at', 'desc')
                ->get();
            return $data ? $data : false;
 } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }
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

     * 通过类别查询表单详情
     * @param $request
     * @return false
     * @author yangsiqi <github.com/Double-R111>
     */
    public static function ysq_searchType($request)
    {
        $info = getDinginfo($request['code']);
        $role = $info->role;
        $name = $info->name;
        if ($role == '借用部门负责人') {
            $lev = 1;
        } elseif ($role == '实验室借用管理员') {
            $lev = 3;
        } elseif ($role == '实验室中心主任') {
            $lev = 5;
        } elseif ($role == '设备管理员') {
            $lev = 7;
        }
        try {
            $data = Form::join('form_type', 'form.type_id', 'form_type.type_id')
                ->join('form_status', 'form.form_status', 'form_status.status_name')
                ->select('form.applicant_name', 'form.form_id', 'form_type.type_name', 'form_status.status_name')
                ->where('form.form_status', '=', $lev)
                ->where('form.applicant_name', '!=', $name)
                ->where('type_name', '=', $request['type_name'])
                ->orderby('form.created_at', 'desc')
                ->get();
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('类型查询表单错误'[$e->getMessage()]);
          return false;
             }
    }

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
     * 分类查询展示各类表单详情
     * @author yangsiqi <github.com/Double-R111>
     * @param $request
     * @return false
     */
    public static function ysq_reshowAll($request)
    {
        try {
            $data = Form::where('form_id', '=', $request['form_id'])
                ->value('type_id');
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('分类搜索失败', [$e->getMessage()]);
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
}


