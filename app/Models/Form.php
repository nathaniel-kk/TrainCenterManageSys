<?php

namespace App\Models;

use App\Http\Requests\ShowAllRequest;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Form extends Model
{
    protected $table = "form";
    public $timestamps = true;
    protected $guarded = [];
    public $primaryKey="form_id";

    /**
     * 得到所有表单展示数据
     * @param $request
     * @return false
     * @author yangsiqi <github.com/Double-R111>
     */
    public static function ysq_getAll($code)
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
     * 通过申请人姓名和表单编号模糊查询表单
     * @author yangsiqi <github.com/Double-R111>
     * @param $request
     * @return false
     */
    public static function ysq_Query($infos,$code)
    {
        try {
            $info = getDinginfo($code);
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
                ->select('form.form_id', 'form.applicant_name', 'form_type.type_name', 'form_status.status_name')
                ->where('form.applicant_name', '!=', $name)
                ->where('form.form_status', '=', $lev)
                ->where('form.form_id', '=', $infos)
                ->orWhere('form.applicant_name', '=', $infos)
                ->orderBy('form.created_at', 'desc')
                ->get();
            return $data ? $data : false;
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
    public static function ysq_searchType($type_name,$code)
    {
        $info = getDinginfo($code);
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
                ->join('form_status', 'form.form_status', 'form_status.status_id')
                ->select('form.applicant_name', 'form.form_id', 'form_type.type_name', 'form_status.status_name')
                ->where('form.form_status', '=', $lev)
                ->where('form.applicant_name', '!=', $name)
                ->where('type_name', '=', $type_name)
                ->orderby('form.created_at', 'desc')
                ->get();
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('类型查询表单错误'[$e->getMessage()]);
        }
    }

    /**
     * 分类查询展示各类表单详情
     * @author yangsiqi <github.com/Double-R111>
     * @param $request
     * @return false
     */
    public static function ysq_reshowAll($form_id)
    {
        try {
            $data = Form::where('form_id', '=', $form_id)
                ->value('type_id');
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('分类搜索失败', [$e->getMessage()]);
            return false;
        }
    }

}
