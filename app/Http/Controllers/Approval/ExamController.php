<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\Form;
use Illuminate\Http\Request;
use function MongoDB\BSON\fromJSON;

class ExamController extends Controller
{
    //request还没写
    //如果request中是需要获取的页面中的表单编号 还需要required吗
    public function pass(Request $request){
        /*  先判断表单种类   以及管理权限
         *  1.调用控制器 根据表单编号 获取表单种类
            2.在根据表单种类 进行判断
         */
        $info  = getDinginfo($request['code']);
        $role = $info->role;
        $name = $info->name;
        //        借用部门负责人
        //        实验室借用管理员
        //        实验室中心主任
        //        设备管理员
        $role = '实验室中心主任';
        $name = '实验室中心主任bbbbb';
        //获取表单类型
        $form_id = $request->get('form_id');
        $form_type = Form::findType($form_id);

        //判断表单类型
        if ($form_type == 1 || $form_type == 5){
            //更改审核表中的姓名、修改时间
            Approve::updateName($form_id,$role,$name);
            Approve::updateNames($form_type,$form_id,$role,$name);
            $form_status = Form::findStatus($form_id);
            Form::updatedStatus($role,$form_id,$form_status);
            Form::updatedStatuss($form_type,$role,$form_id,$form_status);
        }else if($form_type == 3) {
            //更改审核表中的姓名、修改时间
            Approve::updateName($form_id,$role,$name);
            Approve::updateNames($form_type,$form_id,$role,$name);
            $form_status = Form::findStatus($form_id);
            Form::updatedStatus($role,$form_id,$form_status);
            Form::updatedStatuss($form_type,$role,$form_id,$form_status);
        }
        return $form_id?
            json_success('审核表单'.$form_id.'成功!',1,200) :
            json_fail('审核表单'.$form_id.'失败!',null,100);
    }

    public static function noPass(Request $request){
        $info  = getDinginfo($request['code']);
        $role = $info->role;
        $name = $info->name;
        //        借用部门负责人
        //        实验室借用管理员
        //        实验室中心主任
        //        设备管理员
        $role = '借用部门负责人';
        $name = '借用部门负责人aaaaa';

        $form_id = $request->get('form_id');
        $form_type = Form::findType($form_id);

        //获取审核不通过的原因
        $reason = $request->get('reason');
        if ($form_type == 1 || $form_type == 5){
            //审批表中
            Approve::updateName($form_id,$role,$name);
            Approve::updateNames($form_type,$form_id,$role,$name);
            //获取表单状态
            $form_status = Form::findStatus($form_id);
            Form::noUpdateStatus($role,$form_id,$form_status);
            Form::npUpdatedStatuss($form_type,$role,$form_id,$form_status);
        }else if($form_type == 3){
            Approve::updateName($form_id,$role,$name);
            Approve::updateNames($form_type,$form_id,$role,$name);
            $form_status = Form::findStatus($form_id);
            Form::noUpdateStatus($role,$form_id,$form_status);
            Form::npUpdatedStatuss($form_type,$role,$form_id,$form_status);
        }
    }
}

