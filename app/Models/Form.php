<?php

namespace App\Models;

use http\Exception;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class Form extends Model
{
    protected $table = "form";
    public $timestamps = true;
    protected $guarded = [];

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
        }catch(Exception $e){
            logError("查找失败",[$e->getMessage()]);
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
    Public static function hwc_fillLabBorrow($form_id,$code){
        try {
            $data = self::create([
                'form_id' => $form_id,
                'applicant_name' => getDinginfo($code)->name,
                'type_id' => 1,
                'form_status' => 1,
            ]);
            return $data;
        } catch(\Exception $e){
            logError('填报实验室借用申请错误',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 实验室借用申请展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * [String] $form_id
     * @return array
     */
    public static function hwc_viewLabBorrow($form_id){
        try {
            $data = self::Join('laboratory_loan','form.form_id','=','laboratory_loan.form_id')
                ->Join('form_status','form.form_status','=','form_status.status_id')
                ->Join('laboratory','laboratory_loan.laboratory_id','=','laboratory.laboratory_id')
                ->Join('class','laboratory_loan.class_id','=','class.class_id')
                ->Join('approve','form.form_id','=','approve.form_id')
                ->where('form.form_id',$form_id)
                ->select('form_status.status_name','form.updated_at','approve.reason','laboratory.laboratory_name','laboratory.laboratory_id','laboratory_loan.course_name',
                    'class.class_name','laboratory_loan.number','laboratory_loan.purpose','laboratory_loan.start_time','laboratory_loan.end_time',
                    'laboratory_loan.start_class','laboratory_loan.end_class','form.applicant_name','laboratory_loan.phone','form.created_at')
                ->get();
            return $data;
        } catch(\Exception $e){
            logError('实验室借用申请展示错误',[$e->getMessage()]);
            return null;
        }
    }
}
