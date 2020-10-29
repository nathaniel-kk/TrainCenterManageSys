<?php

namespace App\Http\Controllers\Fill;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fill\WriteController\TeachAddRequest;
use App\Http\Requests\Fill\WriteController\TeachMoveRequest;
use App\Models\Laboratory;
use App\Models\TeachingInspection;
use App\Models\TeachingInspectionInfo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class WriteController extends Controller{

    /*
     * 把所有实验室名称给前端
     * @author caiwenpin <github.com/codercwp>
     * return json
     */
    public function teachBack(){
        $result = Laboratory::cwp_back();
        return $result?
            json_success('成功!',$result,200) :
            json_fail('失败!',null,100);
    }

    /*
     * 根据传入的实验室名称返回实验室id
     * @author caiwenpin <github.com/codercwp>
     * @param TeachMoveRequest $request
     *          ['laboratory_name']=>实验室名称
     * return json
     */
    public function teachMove(TeachMoveRequest $request){
        $data = $request->all();
        $name = $data['laboratory_name'];
        $result = Laboratory::cwp_move($name);
        return $result?
            json_success('成功!',$result,200) :
            json_fail('失败!',null,100);
    }


    /*
         * 根据传入的表单信息将所有数据存入数据库
         * @author caiwenpin <github.com/codercwp>
         * @param TeachAddRequest $request
         * return json
         */

    public function teachAdd(TeachAddRequest $request)
    {
        $data = $request['data'];
        for ($i = 0; $i < count($data); $i++) {
            $validator = Validator::make($data[$i], [
                'laboratory_id' => 'required|Integer',
                'class_name' => 'required|String',
                'teacher' => 'required|String',
                'teach_operating_condition' => 'required|String',
                'operating_condition' => 'required|String',
                'remark' => 'required|String',
            ]);

            if ($validator->fails()){
                throw(new HttpResponseException(json_fail('参数错误!',$validator->errors()->all(), 422)));
            }
        }
            $id = 'B' . date("ymdis");
            $res=TeachingInspection::cwp_addId($id);
            $result = TeachingInspectionInfo::cwp_add($id, $data);
            return $result&&$res?
                json_success('成功!', null, 200) :
                json_fail('失败!', null, 100);
    }
}
