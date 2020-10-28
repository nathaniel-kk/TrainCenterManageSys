<?php

namespace App\Http\Controllers\Fill;

use App\Http\Controllers\Controller;
use App\Http\Requests\operationReportRequest;
use App\Http\Requests\ViewRquest;
use App\Models\Clas;
use App\Models\Form;
use App\Models\Laboratory;
use App\Models\LaboratoryOperationRecord;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\YieldFrom;

class OperationReportController extends Controller
{


    /**
     * 实验室运行记录申请表——填报
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function operationReport(operationReportRequest $request){
            $laboratory_name = $request['laboratory_name'];
            $week = $request['week'];
            $class_name = $request['class_name'];
            $clas_name = $request['clas_name'];
            $number =$request['number'];
            $class_type =$request['class_type'];
            $teacher =$request['teacher'];
            $situation =$request['situation'];
            $remark =$request['remark'];
            $code = $request['code'];
        $form_id =  'D'.date("ymdis");
        $res  = getDinginfo($code);
     $applicant_name = $res->name;
        $date = Form::lzz_from($form_id,$applicant_name);

    $data = LaboratoryOperationRecord::lzz_operationReport($form_id,$laboratory_name,$week,$class_name,$clas_name,$number,$class_type,$teacher,$situation,$remark);

        return $data&&$date?
            json_success('成功!',null,200) :
            json_fail('失败!',null,100);
    }

    /**
     * 申请人回显
     * @return \Illuminate\Http\JsonResponse
     */
    public function nameView(){
        $data = Form::lzz_nameview();
        return $data?
            json_success('成功!',$data,200) :
            json_fail('失败!',null,100);
    }

    /**
     * 专业班级下拉框
     * @return \Illuminate\Http\JsonResponse
     */
    public function classDrop(){
        $data = Clas::lzz_classDrop();
        return $data?
            json_success('成功!',$data,200) :
            json_fail('失败!',null,100);
    }

    /**
     * 实验室下拉框
     * @return \Illuminate\Http\JsonResponse
     */
    public function  laboratoryDrop(){
        $data = Laboratory::lzz_laboratoryDrop();
        return $data?
            json_success('成功!',$data,200) :
            json_fail('失败!',null,100);
    }

    /**
     * 实验室运行记录展示
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function  formView(ViewRquest $request){
        $form_id = $request['form_id'];
        $data = LaboratoryOperationRecord::lzz_formView($form_id);
        return $data?
            json_success('成功!',$data,200) :
            json_fail('失败!',null,100);
    }
}
