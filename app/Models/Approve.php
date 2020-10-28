<?php

namespace App\Models;

use http\Exception;
use Illuminate\Database\Eloquent\Model;

class Approve extends Model
{
    protected $table = "approve";
    public $timestamps = true;
    protected $guarded = [];


    /**
     * 填报后将该表单加入审批表中
     * @author tangshengyou
     * @param $form_id
     * @return |null
     */
    public static function tsy_save($form_id){
        try{
            self::create([
                'form_id'=>$form_id,
            ]);
            return true;
        }catch (Exception $e){
            logError("存入失败",[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 插入失败后删除
     * @author tangshengyou
     * @param
     *  $form_id 表单编号
     * @return array
     */
    public static function tsy_delete($form_id)
    {
        try {
            self::where('$form_id', $form_id)
                ->delate();
            return true;
        } catch (Exception $e) {
            logError("查找失败", [$e->getMessage()]);
            return false;
        }
    }
}
