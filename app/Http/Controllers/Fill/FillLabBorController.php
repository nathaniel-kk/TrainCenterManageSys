<?php

namespace App\Http\Controllers\Fill;

use App\Http\Controllers\Controller;
use App\Http\Requests\FillLabBorLinkRequest;
use App\Http\Requests\FillLabBorrowRequest;
use App\Http\Requests\ViewLabBorrowRequest;
use App\Models\Clas;
use App\Models\Form;
use App\Models\Laboratory;
use App\Models\LaboratoryLoan;
use Illuminate\Http\Request;

class FillLabBorController extends Controller
{
    /**
     * 填报实验室借用申请实验室名称编号联动
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param FillLabBorLinkRequest $request
     * laboratory_name string 实验室名称
     * @return json
     */
    Public function fillLabBorLink(FillLabBorLinkRequest $request){
        $laboratory_name = $request['laboratory_name'];
        $data = Laboratory::hwc_fillLabBorLink($laboratory_name);
        return $data?
            json_success('联动展示实验室编号成功!',$data,200) :
            json_fail('联动展示实验室编号失败!',null,100);
    }

    /**
     * 填报实验室借用申请实验室名称展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @return json
     */
    Public function fillLabNameDis(){
        $data = Laboratory::hwc_fillLabNameDis();
        return $data?
            json_success('展示实验室名称成功!',$data,200) :
            json_fail('展示实验室名称失败!',null,100);
    }

    /**
     * 填报实验室借用申请学生班级展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @return json
     */
    Public function fillLabClassDis(){
        $data = Clas::hwc_fillLabClassDis();
        return $data?
            json_success('展示学生班级名称成功!',$data,200) :
            json_fail('展示学生班级名称失败!',null,100);
    }

    /**
     * 填报实验室借用申请
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param FillLabBorrowRequest $request
     * @return json
     */
    Public function fillLabBorrow(FillLabBorrowRequest $request){
        $code = $request['code'];
        $form_id = 'A'.date("ymdis");
        $laboratory_id = $request['laboratory_id'];
        $course_name = $request['course_name'];
        $class_name = $request['class_name'];
        $number = $request['number'];
        $purpose = $request['purpose'];
        $start_time = $request['start_time'];
        $end_time = $request['end_time'];
        $start_class = $request['start_class'];
        $end_class = $request['end_class'];
        $class_id = Clas::hwc_fillLabBorrow($class_name);
        $data1 = Form::hwc_fillLabBorrow($form_id,$code);
        $data2 = LaboratoryLoan::hwc_fillLabBorrow($code,$form_id,$laboratory_id,$course_name,$class_id,$number,$purpose,$start_time,$end_time,$start_class,$end_class);
        return $data1&&$data2?
            json_success('填报实验室借用申请成功!',null,200) :
            json_fail('填报实验室借用申请失败!',null,100);
    }

    /**
     * 实验室借用申请展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param ViewLabBorrowRequest $request
     * form_id string 表单编号
     * @return json
     */
    Public function viewLabBorrow(ViewLabBorrowRequest $request){
        $form_id = $request['form_id'];
        $data = Form::hwc_viewLabBorrow($form_id);
        return $data?
            json_success('实验室借用申请展示成功!',$data,200) :
            json_fail('实验室借用申请展示失败!',null,100);
    }
}
