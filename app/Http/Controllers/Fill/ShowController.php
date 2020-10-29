<?php

namespace App\Http\Controllers\Fill;

use App\Http\Controllers\Controller;
use App\Http\Requests\CodeRequest;
use App\Http\Requests\EquipmentIdRequest;
use App\Http\Requests\FormIdRequest;
use App\Http\Requests\FormRequest;
use App\Http\Requests\FormTypeRequest;
use App\Http\Requests\IdRequest;
use App\Models\Equipment;
use App\Models\EquipmentBorrow;
use App\Models\EquipmentBorrowChecklist;
use App\Models\Form;
use App\Models\LaboratoryOperationRecord;
use Illuminate\Http\Request;


/**
 * 登陆进来后根据权限显示相应的信息以及查看表单部分
 * Class ShowController
 * @author tangshengyou
 * @package App\Http\Controllers\Fill
 */
class ShowController extends Controller
{
    /**
     * 登陆进来后根据权限显示相应的信息
     * @author tangshengyou <github.com/TangSYc>
     * @param  CodeRequest $request
     *  code string 用来获取当前用户信息
     * @return json
     */
    public function FormInfo(CodeRequest $request){
        $code = $request['code'];
        $res  = getDinginfo($code);
        $groupName  =  $res->role;
//        $groupName = "普通用户1";
        if ($groupName== "普通用户"){
            $data[0]="实验室借用申请";
            $data[1]="开放实验室使用申请";
            $data[2]="实验室仪器借用申请";
            return json_fail("显示对应可填报表单类型成功!",$data,200);
        }else if($groupName=="借用部门负责人"|| $groupName=="实验室借用管理员"|| $groupName=="实验室中心主任"|| $groupName=="设备管理员"){
            $data[0]="实验室借用申请";
            $data[1]="开放实验室使用申请";
            $data[2]="实验室仪器借用申请";
            $data[3]="期末教学记录检查";
            $data[4]="实验室运行记录检查";
            return json_fail("显示对应可填报表单类型成功!",$data,200);
        }
        return json_fail("显示对应可填报表单类型失败!",null,100);

    }

    /**
     * 根据id查找对应的表单
     * @author tangshengyou <github.com/TangSYc>
     * @param  IdRequest $request
     *  form_id string 表单编号
     *  code string 获取用户的code
     * @return json
     */
    public function SelectForm(IdRequest $request){
        $code = $request['code'];
        $res  = getDinginfo($code);
        $applicant_name= $res->name;
        $form_id = $request['form_id'];
        $data = Form::tsy_select($form_id,$applicant_name);
        if ($data==null) {
            return json_fail('查找失败',$data,100);
        }
        if ($data['form_status'] == 1 ||$data['form_status'] == 3||$data['form_status'] ==5||$data['form_status'] ==7||$data['form_status'] ==9){
            $data['form_status'] ="审批中";
        }else if ($data['form_status'] == 11){
            $data['form_status'] = "已通过";
        }else if ($data['form_status'] == 2 ||$data['form_status'] == 4||$data['form_status'] ==6||$data['form_status'] ==8){
            $data['form_status'] = "未通过";
        }
        return json_fail('查找成功',$data,200);
    }

    /**
     * 根据类型 状态回显对应的表单列表
     * @author tangshengyou <github.com/TangSYc>
     * @param  FormTypeRequest $request
     *  code string 用来获取当前用户信息
     *  type_name string 表单类型
     *  form_status string 表单状态
     * @return json
     */
    public function SelectionForm(FormTypeRequest $request){
        $type_name = $request['type_name'];
        $form_status = $request['form_status'];
        $code = $request['code'];
        $res  = getDinginfo($code);
        $name= $res->name;
        $data1 = Form::tsy_selectType($name);
        if ($data1 == null){
            return json_fail("查找失败",null,100);
        }
        for($i = 0;$i<count($data1);$i++){
            if ($data1[$i]['form_status'] == 1 || $data1[$i]['form_status'] == 3 || $data1[$i]['form_status'] ==5|| $data1[$i]['form_status'] ==7|| $data1[$i]['form_status'] ==9){
                $data1[$i]['form_status'] ="审批中";
            }else if ($data1[$i]['form_status'] == 11){
                $data1[$i]['form_status'] = "已通过";
            }else if ($data1[$i]['form_status'] == 2 ||$data1[$i]['form_status'] == 4||$data1[$i]['form_status'] ==6||$data1[$i]['form_status'] ==8){
                $data1[$i]['form_status'] = "未通过";
            }
            if ($data1[$i]['type_id'] ==1){
                $data1[$i]['type_id']="实验室借用申请表单";
            }else if ($data1[$i]['type_name'] ==2){
                $data1[$i]['type_id']="期末实验教学检查记录表";
            }else if ($data1[$i]['type_id'] ==3){
                $data1[$i]['type_id']="实验室仪器设备借用单";
            }else if ($data1[$i]['type_id'] ==4){
                $data1[$i]['type_id']="实验室运行记录";
            }else if ($data1[$i]['type_id'] ==5){
                $data1[$i]['type_id']="开放实验室使用申请单";
            }
        }
        if ($type_name ==1){
            $type_name="实验室借用申请表单";
        }else if ($type_name ==2){
            $type_name="期末实验教学检查记录表";
        }else if ($type_name ==3){
            $type_name ="实验室仪器设备借用单";
        }else if ($type_name ==4){
            $type_name="实验室运行记录";
        }else if ($type_name ==5){
            $type_name="开放实验室使用申请单";
        }else if($type_name == 0){
            $type_name="全部";
        }
        if ($form_status == 1){
            $form_status = "审批中";
        }else if($form_status == 2){
            $form_status = "未通过";
        }else if($form_status == 3){
            $form_status = "已通过";
        }else if ($form_status == 0){
            $form_status = "全部";
        }
        $j = 0;
        $data = null;
        for($i = 0;$i<count($data1);$i++){
            if($type_name == "全部" && $form_status == "全部") {
                $data = $data1;
                break;
            }else if($form_status == "全部"){
                if ($data1[$i]['type_id'] == $type_name){
                    $data[$j]['form_id']=$data1[$i]['form_id'];
                    $data[$j]['form_status']=$data1[$i]['form_status'];
                    $data[$j]['type_id']=$data1[$i]['type_id'];
                    $j++;
                }
            }else if($type_name == "全部"){
                if ($data1[$i]['form_status'] == $form_status){
                    $data[$j]['form_id']=$data1[$i]['form_id'];
                    $data[$j]['form_status']=$data1[$i]['form_status'];
                    $data[$j]['type_id']=$data1[$i]['type_id'];
                    $j++;
                }
            }else{
                if ($data1[$i]['type_name'] == $type_name && $data1[$i]['form_status'] == $form_status){
                        $data[$j]['form_id']=$data1[$i]['form_id'];
                        $data[$j]['form_status']=$data1[$i]['form_status'];
                        $data[$j]['type_id']=$data1[$i]['type_id'];
                        $j++;
                }
            }
        }

        return json_fail("查找成功",$data,200);
    }

    /**
     * 点击查看按钮后 根据查看的form表单编号回显对应的表单
     * @author tangshengyou <github.com/TangSYc>
     * @param  FormIdRequest $request
     *  form_id string 表单id
     * @return json
     */
    public function SeeView(FormIdRequest $request){
        $form_id = $request['form_id'];
        $data = EquipmentBorrow::tsy_selectId($form_id);
        $data2 = EquipmentBorrowChecklist::tsy_selectId($form_id);
        $data['equipment_array']=null;
        if ($data==null || $data2 == null){
            return json_fail("查看设备借用表失败!",null,100);
        }
        for ($i=0;$i<count($data2);$i++){
            $data1 = Equipment::tsy_equipmentSelect($data2[$i]['equipment_id']);
            $data1['equipment_number']=$data2[$i]['equipment_number'];

            $equipment_array[$i] = $data1;

        }
        $data['equipment_array']=$equipment_array;
        return json_fail("查看设备借用表成功!",$data,200);
    }

    /**
     * 设备借用 中下拉框中选中了对应的设备后回显数据
     * @author tangshengyou <github.com/TangSYc>
     * @param  EquipmentIdRequest $request
     *  equipment_id string 设备id
     * @return json
     */
    public function SelectEquipment(EquipmentIdRequest $request){
        $equipment_id = $request['equipment_id'];
        $data = Equipment::tsy_SelectById($equipment_id);
        if ($data == null){
            return json_fail("查找对应的设备失败",$data,200);
        }
        return json_fail("查找对应设备信息成功",$data,100);
    }

    /**
     * 将数据库中的所有设备名称回显在下拉框中
     * @author tangshengyou <github.com/TangSYc>
     * @return json
     */
    public function CheckBoxEquipment(){
        $data = Equipment::tsy_equipmentAll();
        if ($data == null){
            return json_fail("下拉框中回显所有设备名设备!",$data,100);
        }
        return json_fail("下拉框中回显所有设备名成功!",$data,200);
    }
}

