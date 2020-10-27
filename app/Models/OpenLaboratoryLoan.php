<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenLaboratoryLoan extends Model
{
    protected $table = "open_laboratory_loan";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 开放实验室表单详情展示
     * @param $request
     * @return false
     * @author yangsiqi <github.com/Double-R111>
     */
    public static function ysq_reshowOpenLab($form_id)
    {
        try {
            $data = OpenLaboratoryLoan::join('form', 'open_laboratory_loan.form_id', 'form.form_id')
                ->select('open_laboratory_loan.*', 'form.applicant_name', 'form.created_at')
                ->where('open_laboratory_loan.form_id', $form_id)
                ->get();
            $data2 = OpenLaboratoryStudentList::where('form_id', $form_id)
                ->get();
            $data3=Form::join('form_type', 'form.type_id', 'form_type.type_id')
                ->join('form_status','form_status.status_id','form.form_status')
                ->join('approve', 'form.form_id', 'approve.form_id')
                ->select('form_type.type_name','form_status.status_name', 'approve.reason')
                ->get();
            $data['data2'] = $data2;
            $data['data3']=$data3;
            return $data ? $data : false;
        } catch (\Exception $e) {
            logError('搜索错误', [$e->getMessage()]);
            return false;
        }
    }

}
