<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaboratoryLoan extends Model
{

    protected $table = "laboratory_loan";
    public $timestamps = true;protected $guarded = [];

    /**
     * 实验室借用申请表单展示
     * @author yangsiqi <github.com/Double-R111>
     * @param $request
     * @return false
     */
    public static function ysq_reshowLab($form_id)
    {
        try {
            $data = LaboratoryLoan::join('laboratory', 'laboratory_loan.laboratory_id', 'laboratory.laboratory_id')
                ->join('class', 'laboratory_loan.class_id', 'class.class_id')
                ->join('form', 'laboratory_loan.form_id', 'form.form_id')
                ->select('laboratory_loan.*', 'laboratory.laboratory_name', 'class.class_name', 'form.applicant_name','form.created_at')
                ->where('laboratory_loan.form_id', $form_id)
                ->get();
            $data1=Form::join('form_type', 'form.type_id', 'form_type.type_id')
                ->join('form_status','form_status.status_id','form.form_status')
                ->join('approve', 'form.form_id', 'approve.form_id')
                ->select('form_type.type_name','form_status.status_name', 'approve.reason')
                ->get();
            $data['data1']=$data1;
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('实验室表单详情搜索出错', [$e->getMessage()]);
            return false;
        }
    }


}
