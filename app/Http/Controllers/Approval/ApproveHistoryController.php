<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\Approve;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Http\Requests\ShowAllRequest;
use App\Http\Requests\ControlAllRequest;
use App\Http\Requests\SearchFormRequest;
use App\Http\Requests\SelectTypeRequest;
use App\Http\Requests\ReshowAllRequest;
use App\Models\LaboratoryLoan;
use App\Models\OpenLaboratoryLoan;
use App\Models\EquipmentBorrow;

class ApproveHistoryController extends Controller
{
    /**
     * 展示当前权限所有表单信息
     * @author yangsiqi <github.com/Double-R111>
     * @param ShowAllRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAll(ShowAllRequest $request)
    {
        $infos = Form::ysq_getAll($request);
        return $infos ?
            json_success('表单展示成功', $infos, 200) :
            json_fail('表单展示失败', null, 100);

    }

    /**
     * 通过申请人姓名和表单编号模糊查询表单
     * @author yangsiqi <github.com/Double-R111>
     * @param SearchFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchForm(SearchFormRequest $request)
    {//$data=$request['form_id'];
        $infos = Form::ysq_categoryQuery($request);
        return $infos ?
            json_success('表单查询成功', $infos, 200) :
            json_fail('表单查询失败', null, 100);
    }

    /**
     * 通过类型查找表单
     * @param $data
     * @author yangsiqi <github.com/Double-R111>
     * @param ShowAllRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectType(SelectTypeRequest $request)
    {
        $infos = Form::ysq_searchType($request);
        return $infos ?
            json_success('通过类型表单查询成功', $infos, 200) :
            json_fail('通过类型表单查询失败', null, 100);
    }

    /**
     * 分类展示表单详情
     * @param ReshowAllRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reshowAll(ReshowAllRequest $request)
    {
        $num = Form::ysq_reshowAll($request);
        $m = 0;
        if ($num == 1) {
            $m = LaboratoryLoan::ysq_reshowLab($request);
        } elseif ($num == 3) {
            $m = EquipmentBorrow::ysq_reshowIns($request);
        } elseif ($num == 5) {
            $m = OpenLaboratoryLoan::ysq_reshowOpenLab($request);
        }
        return $m ?
            json_success('分类表单展示成功', $m, 200) :
            json_fail('分类表单展示失败', null, 100);
    }
}
