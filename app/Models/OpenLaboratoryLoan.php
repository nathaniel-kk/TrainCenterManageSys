<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenLaboratoryLoan extends Model
{
    protected $table = "open_laboratory_loan";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 开放实验室使用申请填报
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [String] $code
     * @return array
     */
    Public static function hwc_openLabUseBor($form_id,$reason_use,$porject_name,$start_time,$end_time){
        try {
            $data = self::create([
                'form_id' => $form_id,
                'reason_use' => $reason_use,
                'porject_name' => $porject_name,
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]);
            return $data;
        } catch(\Exception $e){
            logError('开放实验室使用申请填报错误',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 开放实验室使用申请表单展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [String] $form_id
     * @return array
     */
    Public static function hwc_viewOpenLabUse($form_id){
        try {
            $data = self::Join('form','open_laboratory_loan.form_id','=','form.form_id')
                ->Join('form_status','form.form_status','=','form_status.status_id')
                ->Join('approve','form.form_id','=','approve.form_id')
                ->where('form.form_id',$form_id)
                ->select('form_status.status_name','form.updated_at','approve.reason','open_laboratory_loan.reason_use','open_laboratory_loan.porject_name','open_laboratory_loan.start_time','open_laboratory_loan.end_time','form.created_at')
                ->get();
            return $data;
        } catch(\Exception $e){
            logError('开放实验室使用申请表单展示错误',[$e->getMessage()]);
            return null;
        }
    }
}
