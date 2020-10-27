<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Http\Requests\Approval\ClassifyRequest;
use App\Http\Requests\Approval\ReShowRequest;
use App\Http\Requests\Approval\SelectRequest;
use App\Http\Requests\Approval\ShowRequest;
use App\Models\EquipmentBorrow;
use App\Models\Form;
use App\Models\OpenLaboratoryLoan;

class ApprovalController extends Controller
{
    /**
     * 展示所有待审批表单
     * @auther ZhongChun <github.com/RobbEr929>
     * @param ShowRequest $request
     * @return json
     */
    public static function show(ShowRequest $request){
        $code = $request['code'];
        $res = Form::zc_show($code);
        return $res?
            json_success('待审批表单展示成功!',$res,200):
            json_fail('待审批表单展示失败!',null,100);

    }

    /**
     * 分类查询待审批表单
     * @auther ZhongChun <github.com/RobbEr929>
     * @param ClassifyRequest $request
     * @return json
     */
    public static function classify(ClassifyRequest $request){
        $code = $request['code'];
        $type_name = $request['type_name'];
        $res = Form::zc_classify($code,$type_name);
        return $res?
            json_success('待审批表单展示成功!',$res,200):
            json_fail('待审批表单展示失败!',null,100);

    }

    /**
     * 根据表单编号和姓名模糊查询表单
     * @auther ZhongChun <github.com/RobbEr929>
     * @param SelectRequest $request
     * @return json
     */
    public static function select(SelectRequest $request){
        $code = $request['code'];
        $data = $request['data'];
        $res = Form::zc_select($code,$data);
        return $res?
            json_success('待审批表单展示成功!',$res,200):
            json_fail('待审批表单展示失败!',null,100);

    }

    /**
     * 分类回显
     * @auther ZhongChun <github.com/RobbEr929>
     * @param ReShowRequest $request
     * @return json
     */
    public static function reShow(ReShowRequest $request){
        $form_id = $request['form_id'];
        $res = Form::zc_reShow($form_id);
        $zc = 0;
        if($res==1){
            $zc = OpenLaboratoryLoan::zc_reShowSys($form_id);
        }elseif($res==5){
            $zc = OpenLaboratoryLoan::zc_reShowOpenSys($form_id);
        }elseif($res==3){
            $zc = EquipmentBorrow::zc_reShowSysIns($form_id);
        }
        return $zc?
            json_success('待审批表单展示成功!',$zc,200):
            json_fail('待审批表单展示失败!',null,100);

    }
}
