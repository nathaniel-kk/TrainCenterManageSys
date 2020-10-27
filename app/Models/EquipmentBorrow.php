<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use \DB;

class EquipmentBorrow extends Model
{
    protected $table = "equipment_borrow";
    public $timestamps = true;
    protected $guarded = [];

    /**
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
}
