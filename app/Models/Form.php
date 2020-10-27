<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class Form extends Model
{
    protected $table = "form";
    public $timestamps = true;
    protected $guarded = [];

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
