<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clas extends Model
{
    protected $table = "class";
    public $timestamps = true;
    protected $guarded = [];

    /**
     *
     * @return |null
     */
    public static function lzz_classDrop(){
        try {
            $data = self::select('class_name')
                        ->get();
            return $data;
        } catch(\Exception $e){
            logError('专业班级下拉框错误',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 填报实验室借用申请学生班级展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @return array
     */
    Public static function hwc_fillLabClassDis(){
        try {
            $data = Clas::select('class_name')
                ->get();
            return $data;
        } catch(\Exception $e){
            logError('展示学生班级名称错误',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 填报实验室借用申请 取班级名称
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @return array
     */
    Public static function hwc_fillLabBorrow($class_name){
        try {
            $data = self::where('class_name',$class_name)
                ->pluck('class_id')[0];
            return $data;
        } catch(\Exception $e){
            logError('报实验室借用申请取班级名称错误',[$e->getMessage()]);
            return null;
        }
    }
}
