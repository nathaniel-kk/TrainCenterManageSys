<?php

namespace App\Http\Controllers\Fill;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentBorrowingRequest;
use App\Models\Approve;
use App\Models\Equipment;
use App\Models\EquipmentBorrow;
use App\Models\EquipmentBorrowChecklist;
use App\Models\Form;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * 表单填报
 * @author tangshengyou
 * Class DealFromController
 * @package App\Http\Controllers\Fill
 */
class DealFromController extends Controller
{
    /**
     * 实验室设备借用申请表
     * @author tangshengyou <github.com/TangSYc>
     * @param Request $request
     *  code	string 获取code
     *  borrow_department string 借用部门
     *  borrow_application string 设备用途
     *  destine_start_time date 开始时间
     *  destine_end_time date 结束时间
     *  "equipment_array"[{  json
     *  "equipment_id":   string 设备编号
     *  "number":   string  借用数量
     *  }
     *  ]
     * @return json
     */
    public function EquipmentBorrowing(EquipmentBorrowingRequest $request){
        $equipment_array = $request['equipment_array'];
        for ($i=0;$i<count($equipment_array);$i++){
            $validator = Validator::make($equipment_array[$i],[
                'equipment_name'=>'required|max:200',
                'number'=>'required'
            ]);
            if ($validator->fails()){
                throw(new HttpResponseException(json_fail('参数错误!','null' , 422)));
            }
        }
        $form_id ='C'.date('ymdis');
        $code = $request['code'];
        $res  = getDinginfo($code);
        $info['name']= $res->name;
        $info['tel'] = $res->tel;
        $info['form_id'] = $form_id;
        $info['borrow_department'] = $request['borrow_department'];
        $info['borrow_application'] = $request['borrow_application'];
        $info['destine_start_time'] = $request['destine_start_time'];
        $info['destine_end_time'] = $request['destine_end_time'];
        $res2 = Form::tsy_create($info);
        $res3 = EquipmentBorrow::tsy_create($info);

        for ($i =0;$i<count($equipment_array);$i++){
            $data = Equipment::tsy_SelectIdByName($equipment_array[$i]['equipment_name']);
            $info1['equipment_id'] =$data['equipment_id'];
            $info1['number'] = $equipment_array[$i]['number'];
            $res1 = EquipmentBorrowChecklist::tsy_create($info1,$form_id);
        }
        if ($res1 == true && $res2 == true && $res3 == true ){
            return json_fail("填报成功",null,200);
        }else{
            if ($res2==false){
                Form::tsy_delete($form_id);
            }
            if ($res3==false){
                EquipmentBorrow::tsy_delete($form_id);
            }
            return json_fail("填报失败",null,100);
        }
    }

}
