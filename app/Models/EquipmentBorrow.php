<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentBorrow extends Model
{
    protected $table = "equipment_borrow";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 回显开放实验室使用申请
     * @auther ZhongChun <github.com/RobbEr929>
     * @param $request
     * return [string]
     */
    public static function zc_reShowSysIns($form_id)
    {
        try {
            $res1 = EquipmentBorrow::where('form_id','=',$form_id)
                ->get();
            $res2 = EquipmentBorrowChecklist::join('equipment','equipment.equipment_id','equipment_borrow_checklist.equipment_id')
                ->where('equipment_borrow_checklist.form_id','=',$form_id)
                ->get();
            $res1['data']=$res2;
            return $res1?
                $res1:
                false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }
}
