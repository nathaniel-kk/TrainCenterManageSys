<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaboratoryLoan extends Model
{

    protected $table = "laboratory_loan";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 实验室借用申请表单展示
     * @author yangsiqi <github.com/Double-R111>
     * @param $request
     * @return false
     */
    public static function ysq_reshowLab($request)
    {
        try {
            $data = LaboratoryLoan::join('laboratory', 'laboratory_loan.laboratory_id', 'laboratory.laboratory_id')
                ->join('class', 'laboratory_loan.class_id', 'class.class_id')
                ->join('form', 'laboratory_loan.form_id', 'form.form_id')
                ->join('form_type', 'form.form_status', 'form_type.status_name')
                ->join('approve','form.form_id','approve.form_id')
                ->select('laboratory_loan.*', 'laboratory.laboratory_name', 'class.class_name', 'form.applicant_name','form_type.status_name','approve.reason','form.created_at')
                ->where('laboratory_loan.form_id', $request['form_id'])
                ->get();
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('实验室表单详情搜索出错', [$e->getMessage()]);
            return false;
        }
    }


}
