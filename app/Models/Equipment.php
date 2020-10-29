<?php

namespace App\Models;

use http\Exception;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = "equipment";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 获取所有的设备信息
     * @author tangshengyou
     * @return array
     */
    public static function tsy_equipmentAll(){
        try{
            $data= self::select('equipment_id','equipment_name')
                ->get();
            return $data;
        }catch (Exception $e){
            logError("获取所有的设备信息失败",[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 通过设备id获取对应设备的详细信息
     * @author tangshengyou
     * @param
     *  $equipment_id string 设备id
     * @return array
     */
    public static function tsy_equipmentSelect($equipment_id){
        try{
            $data = self::where('equipment_id',$equipment_id)
                ->select("equipment_name",'model','annex')
                ->first();
            return $data;
        }catch (Exception $e){
            logError("查找对应的设备失败",[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 通过设备id获取对应设备的详细信息
     * @author tangshengyou
     * @param
     *  $equipment_id string 设备id
     * @return array
     */
    public static function tsy_SelectById($equipment_id){
        try{
            $data = self::where('equipment_id',$equipment_id)
                ->select("equipment_name",'model','annex','number','equipment_id')
                ->first();
            return $data;
        }catch (Exception $e){
            logError("查找对应的设备失败",[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 通过设备name获取对应设备的详细信息
     * @author tangshengyou
     * @param
     *  $equipment_id string 设备id
     * @return array
     */
    public static function tsy_SelectIdByName($equipment_name){
        try{
            $data = self::where('equipment_name',$equipment_name)
                ->select('equipment_id')
                ->first();
            return $data;
        }catch (Exception $e){
            logError("查找对应的设备失败",[$e->getMessage()]);
            return null;
        }
    }
}
