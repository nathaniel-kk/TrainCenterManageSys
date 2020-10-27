<?php

namespace App\Models;

use http\Exception;
use Illuminate\Database\Eloquent\Model;

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
    public static function tsy_selectType($applicant_name){
        try{
            $data = self::where('applicant_name',$applicant_name)
                ->select('form_id','type_id','form_status')
                ->orderby('created_at')
                ->get();
            return $data;
        }catch(Exception $e){
            logError("查找失败",[$e->getMessage()]);
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
            return false;
        }
    }
}
