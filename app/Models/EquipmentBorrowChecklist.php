<?php

namespace App\Models;

use http\Exception;
use Illuminate\Database\Eloquent\Model;

class EquipmentBorrowChecklist extends Model
{
    protected $table = "equipment_borrow_checklist";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 将借用的设备编号和数量数据库中
     * @author tangshengyou
     * @param $info,$form_id
     * @return true false true 为存入成功 false 存入失败
     */
    public static function tsy_create($info,$form_id){
        try{
            self::create([
                'form_id'=>$form_id,
                'equipment_id'=>$info['equipment_id'],
                'equipment_number'=>$info['number'],
            ]);
            return true;
        }catch(Exception $e){
            logError("存入失败",[$e->getMessage()]);
            return false;
        }
    }

    /**
     * 根据表单id获取数据
     * @author tangshengyou
     * @param $form_id
     * @return true false true 为存入成功 false 存入失败
     */
    public static function tsy_selectId($form_id){
        try{
            $data = self::where('form_id',$form_id)
                ->select('equipment_id','equipment_number')
                ->get();
            return $data;
        }catch(Exception $e){
            logError("查找失败",[$e->getMessage()]);
            return null;
        }
    }
}
