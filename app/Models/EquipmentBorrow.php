<?php

namespace App\Models;


use http\Exception;

use Exception;

use Illuminate\Database\Eloquent\Model;
use \DB;

class EquipmentBorrow extends Model
{
    protected $table = "equipment_borrow";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 实验室设备借用信息存入数据库
     * @author tangshengyou
     * @param $info
     * @return trun 存储成功 null 存储失败
     */
    public static function tsy_create($info){
        try{
            self::create([
                'form_id'=>$info['form_id'],
                'borrow_department'=>$info['borrow_department'],
                'borrow_application'=>$info['borrow_application'],
                'destine_start_time'=>$info['destine_start_time'],
                'destine_end_time'=>$info['destine_end_time'],
                'borrower_name'=>$info['name'],
                'borrower_phone'=>$info['tel']

            ]);
            return true;
        }catch(Exception $e){
            logError("存入数据库失败",[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 根据表单id 查找需要的数据
     * @author tangshengyou
     * @param $form_id
     * @return $data 存储成功 null 存储失败
     */
    public static function tsy_selectId($form_id){
        try{
            $data = self::join('form','form.form_id','equipment_borrow.form_id')
                ->join('approve','approve.form_id','equipment_borrow.form_id')
                ->where('form.form_id',$form_id)
                ->select(
                    'equipment_borrow.borrow_department',
                    'equipment_borrow.borrow_application',
                    'equipment_borrow.destine_start_time',
                    'equipment_borrow.destine_end_time',
                    'equipment_borrow.borrower_name',
                    'equipment_borrow.borrower_phone',
                    'form.form_id',
                    'form.form_status',
                    'form.created_at',
                    'approve.reason'
                )
                ->first();
            return $data;
        }catch(Exception $e){
            logError("存入数据库失败",[$e->getMessage()]);
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

     * 得到近期待还设备信息
     * @author zhuxianglin <github.com/lybbor>
     * @return void
     */
    public static function zxl_getrecentwait(){
        try{
            $res=DB::table('getrecentwait')->get();
            return $res;
        }catch(Exception $e){
            logError('状态时失效！',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 得到近期借用设备
     * @author zhuxianglin <github.com/lybbor>
     * @return void 
     */
    public static function zxl_getrecentlend(){
        try{
            $res=DB::table('getrecentlend')->get();
            return $res;
        }catch(Exception $e){
            logError('状态时失效！',[$e->getMessage()]);
            return null;
        }
    }
    
    /**
     * 得到逾期未还信息
     * @author zhuxianglin <github.com/lybbor>
     * @return void
     */
    public static function zxl_getisoverdue(){
        try{
            $res=DB::table('getisoverdue')->get();
            return $res;
        }catch(Exception $e){
            logError('状态时失效！',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 得到系部借用情况
     * @author zhuxianglin <github.com/lybbor>
     * @return void
     */
    public static function zxl_getfacultylend(){
        try{
            $res=DB::table('getfacultylend')->get();
            return $res;
        }catch(Exception $e){
            logError('状态时失效！',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 获得近期借用设备单数
     * @author zhuxianglin <github.com/lybbor>
     * @return void
     */
    public static function zxl_getrecentlendnum(){
        try{
            $res=DB::table('union_num')->get();
            return $res;
        }catch(Exception $e){
            logError('状态时失效！',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 获得近期借用设备数量
     * @author zhuxianglin <github.com/lybbor>
     * @return void
     */
    public static function zxl_getrecentlendsum(){
        try{
            $res=DB::table('union_sum')->get();
            return $res;
        }catch(Exception $e){
            logError('状态时失效！',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 获得实验室教学检查情况
     * @author zhuxianglin <github.com/lybbor>
     * @return void
     */
    public static function zxl_checkedlab(){
        try{
            $res=DB::table('checkedlab')->get();
            return $res;
        }catch(Exception $e){
            logError('状态时失效！',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 获得教师检查统计情况
     * @author zhuxianglin <github.com/lybbor>
     * @return void
     */
    public static function zxl_teachercheck(){
        try{
            $res=DB::table('teacher_check')->get();
            return $res;
        }catch(Exception $e){
            logError('状态时失效！',[$e->getMessage()]);
            return null;
        }
    }


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
