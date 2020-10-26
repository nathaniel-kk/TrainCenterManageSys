<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentBorrow extends Model
{
    protected $table = "equipment_borrow";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 借用设备表单详情展示
     * @author yangsiqi <github.com/Double-R111>
     * @param $request
     * @return false
     */
    public static function ysq_reshowIns($request)
    {
        try {
            $data1 = EquipmentBorrow::join('form', 'equipment_borrow.form_id', 'form.form_id')
                ->join('form_type', 'form.type_id', 'form_type.type_id')
                ->join('form_status', 'form.form_status', 'form_status.status_name')
                ->join('approve', 'form.form_id', 'approve.form_id')
                ->select('equipment_borrow.*','approve.reason','form_status.status_name','form.created_at')
                ->where('form_id', '=', $request['form_id'])
                ->get();
            $data2 = EquipmentBorrowChecklist::join('equipment', 'equipment.equipment_id', 'equipment_borrow_checklist.equipment_id')
                ->where('equipment_borrow_checklist.form_id', '=', $request['form_id'])
                ->get();
            $data1['data'] = $data2;
            return $data1 ?
                $data1 :
                false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }
}
