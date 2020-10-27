<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentBorrow extends Model
{
    protected $table = "equipment_borrow";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 实验室设备借用信息存入数据库
     * @author tangshengyou
     * @param $info
     * @return trun 存储成功 null 存储失败
     */
    public static function tsy_create($info){
        try{
            self::create([
                'form_id'=>$info['form_id'],
                'borrow_department'=>$info['borrow_department'],
                'borrow_application'=>$info['borrow_application'],
                'destine_start_time'=>$info['destine_start_time'],
                'destine_end_time'=>$info['destine_end_time'],
                'borrower_name'=>$info['name'],
                'borrower_phone'=>$info['tel']

            ]);
            return true;
        }catch(Exception $e){
            logError("存入数据库失败",[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 根据表单id 查找需要的数据
     * @author tangshengyou
     * @param $form_id
     * @return $data 存储成功 null 存储失败
     */
    public static function tsy_selectId($form_id){
        try{
            $data = self::join('form','form.form_id','equipment_borrow.form_id')
                ->join('approve','approve.form_id','equipment_borrow.form_id')
                ->where('form.form_id',$form_id)
                ->select(
                    'equipment_borrow.borrow_department',
                    'equipment_borrow.borrow_application',
                    'equipment_borrow.destine_start_time',
                    'equipment_borrow.destine_end_time',
                    'equipment_borrow.borrower_name',
                    'equipment_borrow.borrower_phone',
                    'form.form_id',
                    'form.form_status',
                    'form.created_at',
                    'approve.reason'
                )
                ->first();
            return $data;
        }catch(Exception $e){
            logError("存入数据库失败",[$e->getMessage()]);
            return null;
        }
    }

}
