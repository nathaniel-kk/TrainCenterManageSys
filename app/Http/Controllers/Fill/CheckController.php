<?php

namespace App\Http\Controllers\Fill;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowAllRequest;
use App\Http\Requests\ShowOneRequest;
use App\Models\TeachingInspectionInfo;


class CheckController extends Controller{

  /*
 * 根据传入的表单编号粗略展示该表单所有信息
 * @author caiwenpin <github.com/codercwp>
 * @param ShowAllRequest $request
 *          ['form_id']=>表单编号
     * return json
 */
    public function showAll(ShowAllRequest $request){
    $data = $request->all();
    $id = $data['form_id'];
    $result = TeachingInspectionInfo::cwp_show($id);
    return $result?
        json_success('成功!',$result,200) :
        json_fail('失败!',null,100);
}

    /*
     * 根据传入的实验室编号展示详细信息
     * @author caiwenpin <github.com/codercwp>
     * @param ShowOneRequest $request
     *          ['laboratory_id']=>实验室编号
     * return json
     */
    public function showOne(ShowOneRequest $request){
        $data = $request->all();
        $id = $data['laboratory_id'];
        $result =TeachingInspectionInfo::cwp_one($id);
        return $result?
            json_success('成功!',$result,200):
            json_fail('失败!',null,100);
    }

}
