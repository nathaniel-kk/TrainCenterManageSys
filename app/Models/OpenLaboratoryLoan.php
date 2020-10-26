<?php

namespace App\Models;

use http\Env\Request;
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
    public static function ysq_reshowOpenLab($request)
    {
        try {
            $data1 = OpenLaboratoryLoan::join('form', 'open_laboratory_loan.form_id', 'form.form_id')
                ->join('form_type', 'form.form_status', 'form_type.status_name')
                ->join('approve', 'form.form_id', 'approve.form_id')
                ->select('open_laboratory_loan.*', 'form.applicant_name', 'form_type.status_name', 'approve.reason', 'form.created_at')
                ->where('open_laboratory_loan.form_id', $request['form_id'])
                ->get();
            $data2 = OpenLaboratoryStudentList::where('form_id', $request['form_id'])
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
