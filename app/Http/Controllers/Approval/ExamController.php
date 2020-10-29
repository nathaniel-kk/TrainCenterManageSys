<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamRequest;
use App\Http\Requests\IdRequest;
use App\Models\Approve;
use App\Models\Form;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    /**
     * 审核通过
     * @author Dujingwen <github.com/DJWKK>
     * @param  $request
     * @return json
     */
    public function pass(IdRequest $request){
        $info  = getDinginfo($request['code']);
        $role = $info->role;
        $name = $info->name;

        $form_id = $request->get('form_id');
        $form_type = Form::findType($form_id);

        if ($form_type == 1 || $form_type == 5){
            Approve::updateName($form_id,$role,$name);
            $form_status = Form::findStatus($form_id);
            Form::updatedStatus($role,$form_id,$form_status);
            Form::updatedStatuss($form_type,$role,$form_id,$form_status);
        }else if($form_type == 3) {
            Approve::updateName($form_id,$role,$name);
            Approve::updateNames($form_id,$role,$name);
            $form_status = Form::findStatus($form_id);
            Form::updatedStatus($role,$form_id,$form_status);
            Form::updatedStatuss($form_type,$role,$form_id,$form_status);
        }
        return $form_id?
            json_success('审核表单'.$form_id.'成功!',1,200) :
            json_fail('审核表单'.$form_id.'失败!',null,100);
    }

    /**
     * 审核通过
     * @author Dujingwen <github.com/DJWKK>
     * @param ExamRequest $request
     * @return json
     */
    public function noPass(ExamRequest $request){
        $info  = getDinginfo($request['code']);
        $role = $info->role;
        $name = $info->name;

        $form_id = $request->get('form_id');
        $form_type = Form::findType($form_id);
        $reason = $request->get('reason');
        if ($form_type == 1 || $form_type == 5){
            Approve::noUpdateName($form_id,$role,$name,$reason);
            $form_status = Form::findStatus($form_id);
            Form::noUpdateStatus($role,$form_id,$form_status);
            Form::npUpdatedStatuss($role,$form_id,$form_status);
        }else if($form_type == 3){
            Approve::noUpdateName($form_id,$role,$name,$reason);
            Approve::noUpdateNames($form_id,$role,$name,$reason);
            $form_status = Form::findStatus($form_id);
            Form::noUpdateStatus($role,$form_id,$form_status);
            Form::npUpdatedStatuss($role,$form_id,$form_status);
        }
        return $form_id?
            json_success('审核表单不通过'.$form_id.'成功!',1,200) :
            json_fail('审核表单不通过'.$form_id.'失败!',null,100);
    }
}

