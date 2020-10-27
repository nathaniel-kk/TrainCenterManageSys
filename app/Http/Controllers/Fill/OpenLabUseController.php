<?php

namespace App\Http\Controllers\Fill;

use App\Http\Requests\ViewLabBorrowRequest;
use App\Models\Form;
use App\Models\OpenLaboratoryLoan;
use App\Models\OpenLaboratoryStudentList;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\OpenLabuseBorRequest;

class OpenLabUseController extends Controller
{
    /**
     * 开放实验室使用申请填报
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param OpenLabUseBorRequest $request
     * @return json
     */
    Public function openLabUseBor(OpenLabUseBorRequest $request){
        $infor = $request['infor'];
        for ($i=0;$i<count($infor);$i++){
            $validator = Validator::make($infor[$i],[
                'student_name'=>'required|string',
                'student_id'=>'required|string',
                'phone'=>'required|between:11,11',
                'work'=>'required|string'
            ]);
            if ($validator->fails()){
                throw(new HttpResponseException(json_fail('参数错误!',$validator->errors()->all(), 422)));
            }
        }
        $form_id = 'E'.date("ymdis");
        $code = $request['code'];
        $reason_use = $request['reason_use'];
        $porject_name = $request['porject_name'];
        $start_time = $request['start_time'];
        $end_time = $request['end_time'];
        $data1 = Form::hwc_openLabUseBor($form_id,$code);
        $data2 = OpenLaboratoryLoan::hwc_openLabUseBor($form_id,$reason_use,$porject_name,$start_time,$end_time);
        $data3 = OpenLaboratoryStudentList::hwc_openLabUseBor($form_id,$infor);
        return $data1&&$data2&&$data3?
            json_success('开放实验室使用申请填报成功!',null,200) :
            json_fail('开放实验室使用申请填报失败!',null,100);
    }

    /**
     * 开放实验室使用申请表单展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param ViewLabBorrowRequest $request
     * form_id string 表单编号
     * @return json
     */
    Public function viewOpenLabUse(ViewLabBorrowRequest $request){
        $form_id = $request['form_id'];
        $data = OpenLaboratoryLoan::hwc_viewOpenLabUse($form_id);
        return $data?
            json_success('开放实验室使用申请表单展示成功!',$data,200) :
            json_fail('开放实验室使用申请表单展示失败!',null,100);
    }

    /**
     * 开放实验室使用申请人员名单展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param ViewLabBorrowRequest $request
     * form_id string 表单编号
     * @return json
     */
    Public function viewOpenLabManUse(ViewLabBorrowRequest $request){
        $form_id = $request['form_id'];
        $data = OpenLaboratoryStudentList::hwc_viewOpenLabManUse($form_id);
        return $data?
            json_success('开放实验室使用申请人员名单展示成功!',$data,200) :
            json_fail('开放实验室使用申请人员名单展示失败!',null,100);
    }
}
