<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Http\Requests\Approval\ClassifyRequest;
use App\Http\Requests\Approval\ReShowRequest;
use App\Http\Requests\Approval\SelectRequest;
use App\Http\Requests\Approval\ShowRequest;
use App\Models\Form;
use Illuminate\Http\Request;
use function Couchbase\zlibCompress;

class ApprovalController extends Controller
{
    /**
     * 展示所有待审批表单
     * @auther ZhongChun <github.com/RobbEr929>
     * @param ShowRequest $request
     * @return json
     */
    public static function show(ShowRequest $request){
        $res = Form::zc_show($request);
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
        $res = Form::zc_classify($request);
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
        $res = Form::zc_select($request);
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
        $res = Form::zc_reShow($request);
        $zc = 0;
        if($res==1){
            $zc = Form::zc_reShowSys($request);
        }elseif($res==5){
            $zc = Form::zc_reShowOpenSys($request);
        }elseif($res==3){
            $zc = Form::zc_reShowSysIns($request);
        }
        return $zc?
            json_success('待审批表单展示成功!',$zc,200):
            json_fail('待审批表单展示失败!',null,100);

    }
}
