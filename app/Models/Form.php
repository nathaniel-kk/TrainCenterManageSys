<?php

namespace App\Models;

use http\Exception;
use App\Http\Requests\ShowAllRequest;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

use Illuminate\Support\Facades\DB;

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
    /**
     * 根据表id查找表单信息
     * @author tangshengyou
     * @param
     *  $form_id 表单id
     *  $applicant_name 申请人姓名
     * @return array
     */
    public static function tsy_select($form_id,$applicant_name){
        try{
            $data = self::where('form_id',$form_id)
                ->where('applicant_name',$applicant_name)
                ->select('form_id','type_id','form_status')
                ->first();
            return $data;
        }catch(Exception $e) {
            logError("查找失败", [$e->getMessage()]);
            return null;
        }
    }



    /**
     * 获取表单种类
     * @param $form_id
     * @return json
     *
     * @author Dujingwen <github.com/DJWKK>
     */
    public static function findType($form_id)
    {
        try {
            $data = self::where('form_id', $form_id)
                ->select('type_id')
                ->get();
            return $data[0]->type_id;
        } catch (\Exception $e) {
            logError('获取表单' . $form_id . '种类失败', [$e->getMessage()]);
            return null;
        }
    }

    /**
     * 获取当前用户填报的所有表单
     * @author tangshengyou
     * @param
     *  $applicant_name 申请人姓名
     * @return array
     */
    public static function tsy_selectType($applicant_name)
    {
        try {
            $data = self::where('applicant_name', $applicant_name)
                ->select('form_id', 'type_id', 'form_status')
                ->orderby('created_at')
                ->get();
            return $data;
        } catch (Exception $e) {
            logError("查找失败", [$e->getMessage()]);
            return null;
        }
    }
    /**
     * 插入失败后删除
     * @author tangshengyou
     * @param
     *  $form_id 表单编号
     * @return array
     */
    public static function tsy_delete($form_id)
    {
        try {
            self::where('$form_id', $form_id)
                ->delate();
            return true;
        } catch (Exception $e) {
            logError("查找失败", [$e->getMessage()]);
            return false;
        }
    }
        /**
     * 填报入库
     * @param $form_id
     * @param $name
     * @return |null
     */
    public static function lzz_from($form_id,$name){
        try {
                $id = 4;
                $sta = 1;
            $data = Self::insert([
                'form_id' =>$form_id,
                'applicant_name'=>$name,
                'type_id' =>$id,
                'form_status' =>$sta,
                'created_at'=>now()
            ]);
            return $data;
        } catch(\Exception $e){
            logError('实验室运行记录填报错误',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 开放实验室使用申请填报
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [String] $code
     * @return array
     */
    Public static function hwc_openLabUseBor($form_id,$code){
        try {
            $data = self::create([
                'form_id' => $form_id,
                'applicant_name' => getDinginfo($code)->name,
                'type_id' => 5,
                'form_status' => 1,
            ]);
            return $data;
        } catch(\Exception $e){
            logError('开放实验室使用申请填报错误',[$e->getMessage()]);
            return null;
        }
    }

    /**
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
//            dd($name);
            $data = Form::join('form_type', 'form.type_id', 'form_type.type_id')

                ->join('form_status', 'form.form_status', 'form_status.status_id')
                ->join('approve', 'form.form_id', 'approve.form_id')
                ->select('form.form_id', 'form.applicant_name', 'form_status.status_name', 'form_type.type_name')
                ->where('approve.borrowing_department_name', '=', $name)
                ->orwhere('approve.borrowing_manager_name', '=', $name)
                ->where('approve.center_director_name', '=', $name)
                ->orwhere('approve.device_administrator_out_name', '=', $name)
                ->where('approve.device_administrator_acceptance_name', '=', $name)
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
     * 获取表单状态
     * @param $form_id
     * @return json
     * @author Dujingwen <github.com/DJWKK>
     */
    public static function findStatus($form_id)
    {
        try {
            $data = self::where('form_id', $form_id)
                ->select('form_status')
                ->get();
            return $data[0]->form_status;
        } catch (\Exception $e) {
            logError('获取表单' . $form_id . '状态失败', [$e->getMessage()]);
            return null;
        }
    }

    /**
     * 展示所有待审批表单
     * @auther ZhongChun <github.com/RobbEr929>
     * @param $request
     * return [string]
     */
    public static function zc_show($code)
    {
        try {
            $info = getDinginfo($code);
            $role = $info->role;
            $name = $info->name;
            if ($role == "借用部门负责人") {
                $rule = 1;
            } elseif ($role == "实验室借用管理员") {
                $rule = 3;
            } elseif ($role == "实验室中心主任") {
                $rule = 5;
            } elseif ($role == "设备管理员") {
                $rule = 7;
            }
            $res = Form::join('form_type', 'form.type_id', 'form_type.type_id')
                ->select('form.form_id', 'form.applicant_name', 'form_type.type_name')
                ->where('form.applicant_name', '!=', $name)
                ->where('form.form_status', '=', $rule)
                ->orderBy('form.created_at', 'desc')
                ->get();
            return $res ?
                $res :
                false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }

    /**
     * 审核通过 更新表单状态（5之前的状态）
     * @param $form_status
     * @return json
     * @author Dujingwen <github.com/DJWKK>
     */
    public static function updatedStatus($role, $form_id, $form_status)
    {
        try {
            if ($form_status == 1 && $role == '借用部门负责人') {
                $data = self::where('form_id', $form_id)
                    ->increment('form_status', 2);
                return $data;
            } else if ($form_status == 3 && $role == '实验室借用管理员') {
                $data = self::where('form_id', $form_id)
                    ->increment('form_status', 2);
                return $data;
            }
        } catch (\Exception $e) {
            logError('获取表单' . $form_status . '种类失败', [$e->getMessage()]);
            return null;
        }
    }

    /**
     * 审核通过 更新表单状态（5之后的状态）
     * @param $form_type
     * @param $role
     * @param $form_id
     * @param $form_status
     * @return json
     **@author Dujingwen <github.com/DJWKK>
     */
    public static function updatedStatuss($form_type, $role, $form_id, $form_status)
    {
        try {
            if (($form_type == 1 || $form_type == 5) && $form_status == 5 && $role == '实验室中心主任') {
                $data = self::where('form_id', $form_id)
                    ->increment('form_status', 6);
                return $data;
            } else if ($form_type == 3 && $form_status == 5 && $role == '实验室中心主任') {
                $data = self::where('form_id', $form_id)
                    ->increment('form_status', 2);
                return $data;
            } else if ($form_type == 3 && ($form_status == 7 || $form_status == 9) && $role == '设备管理员') {
                $data = self::where('form_id', $form_id)
                    ->increment('form_status', 2);
                return $data;
            }
        } catch (\Exception $e) {
            logError('获取表单' . $form_status . '种类失败', [$e->getMessage()]);
            return null;
        }
    }

    /**
     * 审核不通过 更新表单状态（5之前的状态）
     * @param $role
     * @param $form_id
     * @param $form_status
     * @return json
     * @author Dujingwen <github.com/DJWKK>
     */
    public static function noUpdateStatus($role, $form_id, $form_status)
    {
        try {
            if ($form_status == 1 && $role == '借用部门负责人') {
                $data = self::where('form_id', $form_id)
                    ->increment('form_status', 1);
                return $data;
            } else if ($form_status == 3 && $role == '实验室借用管理员') {
                $data = self::where('form_id', $form_id)
                    ->increment('form_status', 1);
                return $data;
            } else if ($form_status == 5 && $role == '实验室中心主任') {
                $data = self::where('form_id', $form_id)
                    ->increment('form_status', 1);
                return $data;
            }
        } catch (\Exception $e) {
            logError('获取表单' . $form_status . '种类失败', [$e->getMessage()]);
            return null;
        }
    }

    /**
     * 获取当前用户填报的所有表单
     * @author tangshengyou
     * @param $info
     * @return true false true 为存入成功 false 存入失败
     */
    public static function tsy_create($info){
        try{
            self::create([
                'form_id'=>$info['form_id'],
                'applicant_name'=>$info['name'],
                'type_id'=>3,
                'form_status'=>1
            ]);
            return true;
        }catch(Exception $e){
            logError("存入失败",[$e->getMessage()]);
            return false;
        }
    }
    /**
     * 根据表单id获取表单的所有数据
     * @author tangshengyou
     * @param $form_id
     * @return true false true 为存入成功 false 存入失败
     */
    public static function tsy_selectId($form_id){
        try{
            $data=self::where('form_id',$form_id)
                ->select('form_id','form_status','created_at')
                ->get();
            return $data;
        }catch(Exception $e){
            logError("查找失败",[$e->getMessage()]);
            return false;}
    }
    /*
     * 申请人回显
     * @return |null
     */
    public static function lzz_nameView(){
        try {
            $code = 'xxxxx';
            $res  = getDinginfo($code);
            $data = $res->name;
            return $data;
        } catch(\Exception $e){
            logError('申请人回显错误',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 填报实验室借用申请
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [String] $code , [String] $form_id
     * @return array
     */
    Public static function hwc_fillLabBorrow($form_id,$code)
    {
        try {
            $data = self::create([
                'form_id' => $form_id,
                'applicant_name' => getDinginfo($code)->name,
                'type_id' => 1,
                'form_status' => 1,
            ]);
            return $data;
        } catch (\Exception $e) {
            logError('填报实验室借用申请错误', [$e->getMessage()]);
            return null;
        }
    }
    /**
     * 审核不通过 更新表单状态（5之后的状态）
     * @param $role
     * @param $form_id
     * @param $form_status
     * @return json
     * @author Dujingwen <github.com/DJWKK>
     */
    public static function npUpdatedStatuss($role, $form_id, $form_status)
    {
        try {
            if ($form_status == 7 && $role == '设备管理员') {
                $data = self::where('form_id', $form_id)
                    ->increment('form_status', 1);
                return $data;
            } else if ($form_status == 9 && $role == '设备管理员') {
                $data = self::where('form_id', $form_id)
                    ->increment('form_status', 0);
                return $data;
            }
        } catch (\Exception $e) {
            logError('获取表单' . $form_status . '种类失败', [$e->getMessage()]);
            return null;
        }
    }

    /* 通过申请人姓名和表单编号模糊查询表单
     * @author yangsiqi <github.com/Double-R111>
     * @param $request
     * @return false
     */
    public static function ysq_Query($infos, $code)
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
                ->join('approve', 'form.form_id', 'approve.form_id')
                ->select('form.form_id', 'form.applicant_name', 'form_type.type_name', 'form_status.status_name')
                ->where('approve.borrowing_department_name', '=', $name)
                ->orwhere('approve.borrowing_manager_name', '=', $name)
                ->where('approve.center_director_name', '=', $name)
                ->orwhere('approve.device_administrator_out_name', '=', $name)
                ->where('approve.device_administrator_acceptance_name', '=', $name)
                ->where('form.applicant_name', '!=', $name)
                ->where('form.form_status', '=', $lev)
                ->where('form.form_id', '=', $infos)
                ->orWhere('form.form_id', 'like', '%' . $infos . '%')
                ->where('form.applicant_name', '=', $infos)
                ->orWhere('form.applicant_name', 'like', '%' . $infos . '%')
                ->orderBy('form.created_at', 'desc')
                ->get();
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }

    /* 分类查询待审批表单
    * @auther ZhongChun <github.com/RobbEr929>
    * @param $request
    * return [string]
    */
    public static function zc_classify($code, $type_name)
    {
        try {
            $info = getDinginfo($code);
            $role = $info->role;
            $name = $info->name;
            if ($role == "借用部门负责人") {
                $rule = 1;
            } elseif ($role == "实验室借用管理员") {
                $rule = 3;
            } elseif ($role == "实验室中心主任") {
                $rule = 5;
            } elseif ($role == "设备管理员") {
                $rule = 7;
            }
            $res = Form::join('form_type', 'form.type_id', 'form_type.type_id')
                ->select('form.form_id', 'form.applicant_name', 'form_type.type_name')
                ->where('form.applicant_name', '!=', $name)
                ->where('form.form_status', '=', $rule)
                ->where('type_name', '=', $type_name)
                ->orderBy('form.created_at', 'desc')
                ->get();
            return $res ?
                $res :
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
    public static function ysq_searchType($type_name, $code)
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
                ->join('approve', 'form.form_id', 'approve.form_id')
                ->select('form.applicant_name', 'form.form_id', 'form_type.type_name', 'form_status.status_name')
                ->where('approve.borrowing_department_name', '=', $name)
                ->orwhere('approve.borrowing_manager_name', '=', $name)
                ->where('approve.center_director_name', '=', $name)
                ->orwhere('approve.device_administrator_out_name', '=', $name)
                ->where('approve.device_administrator_acceptance_name', '=', $name)
                ->where('form.form_status', '=', $lev)
                ->where('form.applicant_name', '!=', $name)
                ->where('type_name', '=', $type_name)
                ->orderby('form.created_at', 'desc')
                ->get();
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('类型查询表单错误'[$e->getMessage()]);
            return false;
        }
    }

    /* 分类查询待审批表单
    * @auther ZhongChun <github.com/RobbEr929>
    * @param $request
    * return [string]
    */
    public static function zc_select($code, $data)
    {
        try {
            $info = getDinginfo($code);
            $role = $info->role;
            $name = $info->name;
            if ($role == "借用部门负责人") {
                $rule = 1;
            } elseif ($role == "实验室借用管理员") {
                $rule = 3;
            } elseif ($role == "实验室中心主任") {
                $rule = 5;
            } elseif ($role == "设备管理员") {
                $rule = 7;
            }

            $res = Form::join('form_type','form.type_id','form_type.type_id')
                ->select('form.form_id','form.applicant_name','form_type.type_name')
                ->where('form.applicant_name','!=',$name)
                ->where('form.form_status','=',$rule)
                ->where('form.form_id','=',$data)
                ->orWhere('form.form_id','like','%'.$data.'%')
                ->where('form.applicant_name','=',$data)
                ->orWhere('form.applicant_name','like','%'.$data.'%')
                ->orderBy('form.created_at','desc')
                ->get();
            return $res ?
                $res :
                false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;

        }
    }

    /**
     * 分类查询展示各类表单详情
     * @param $request
     * @return false
     * @author yangsiqi <github.com/Double-R111>
     */
    public static function ysq_reshowAll($form_id)
    {
        try {

            $data = Form::where('form_id', '=', $form_id)
                ->value('type_id');
//            dd($data);
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('分类搜索失败', [$e->getMessage()]);
            return false;
        }
    }

    /**
     * 实验室借用申请展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * [String] $form_id
     * @return array
     */
    public static function hwc_viewLabBorrow($form_id)
    {
        try {
            $data = self::Join('laboratory_loan', 'form.form_id', '=', 'laboratory_loan.form_id')
                ->Join('form_status', 'form.form_status', '=', 'form_status.status_id')
                ->Join('laboratory', 'laboratory_loan.laboratory_id', '=', 'laboratory.laboratory_id')
                ->Join('class', 'laboratory_loan.class_id', '=', 'class.class_id')
                ->Join('approve', 'form.form_id', '=', 'approve.form_id')
                ->where('form.form_id', $form_id)
                ->select('form_status.status_name', 'form.updated_at', 'approve.reason', 'laboratory.laboratory_name', 'laboratory.laboratory_id', 'laboratory_loan.course_name',
                    'class.class_name', 'laboratory_loan.number', 'laboratory_loan.purpose', 'laboratory_loan.start_time', 'laboratory_loan.end_time',
                    'laboratory_loan.start_class', 'laboratory_loan.end_class', 'form.applicant_name', 'laboratory_loan.phone', 'form.created_at')
                ->get();
            return $data;
        } catch (\Exception $e) {
            logError('实验室借用申请展示错误', [$e->getMessage()]);
            return null;
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
            $zc = Form::where('form_id', '=', $form_id)
                ->value('type_id');
            return $zc ?
                $zc :
                false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }
}


