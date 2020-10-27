<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    protected $table = "laboratory";
    public $timestamps = true;
    protected $guarded = [];

    /*
     * 把所有实验室名称给前端
     * @author caiwenpin <github.com/codercwp>
     * return $data
     */
    public static function back(){
        $data = self::select('laboratory_name')->get();
        return $data;
    }
      /*
      * 根据实验室名称返回实验室对应编号
      * @author caiwenpin <github.com/codercwp>
      * return $data
      */
    public static function move($name){
        $result = self::where('laboratory_name',$name)->first();
        $data = $result['laboratory_id'];
        return $data;
    }
    /**
     * 实验室下拉框
     * @return |null
     */
    public static function lzz_laboratoryDrop(){
     * 填报实验室借用申请实验室名称编号联动
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [String] $laboratory_name
     * @return array
     */
    Public static function hwc_fillLabBorLink($laboratory_name){
        try {
            $data = self::where('laboratory_name',$laboratory_name)
                ->select('laboratory_id')
                ->get();
            return $data;
        } catch(\Exception $e){
            logError('联动展示实验室编号错误',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 填报实验室借用申请实验室名称展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @return array
     */
    Public static function hwc_fillLabNameDis(){
        try {
            $data = self::select('laboratory_name')
                ->get();
            return $data;
        } catch(\Exception $e){
            logError('展示实验室名称错误',[$e->getMessage()]);
            return null;
        }
    }
}
