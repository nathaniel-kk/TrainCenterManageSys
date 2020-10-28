<?php

namespace App\Http\Controllers\DataScreen;

use App\Http\Controllers\Controller;
use App\Models\EquipmentBorrow;
use Illuminate\Http\Request;

class EquipmentLendController extends Controller
{

    /**
     * 近期待还设备
     * @author zhuxianglin <github.com/lybbor>
     * @return json
     */
    public function recentWait(){
        $res=EquipmentBorrow::zxl_getrecentwait();
        //dd($res);
        return $res!=null?
        json_success("获取近期待还设备信息成功!",$res,200):
        json_fail("获取近期待还设备信息失败!",null,100);
    }

    /**
     * 近期借用设备
     * @author zhuxianglin <github.com/lybbor>
     * @return json
     */
    public function recentLend(){
        $res=EquipmentBorrow::zxl_getrecentlend();
        //dd($res);
        return $res!=null?
        json_success("获取近期借用设备成功!",$res,200):
        json_fail("获取近期借用设备失败!",null,100);
    }

    /**
     * 逾期未还
     * @author zhuxianglin <github.com/lybbor>
     * @return json
     */
    public function isOverdue(){
        $res=EquipmentBorrow::zxl_getisoverdue();
        return $res!=null?
        json_success("获取逾期未归设备成功!",$res,200):
        json_fail("获取逾期未归设备失败!",null,100);
    }

    /**
     * 系部借用设备情况
     * @author zhuxianglin <github.com/lybbor>
     * @return json
     */
    public function facultyLend(){
        $res=EquipmentBorrow::zxl_getfacultylend();
        return $res != null?
        json_success("获取系部借用设备成功!",$res,200):
        json_fail("获取系部借用设备失败!",null,100);
    }

    /**
     * 近期设备借用单数
     * @author zhuxianglin <github.com/lybbor>
     * @return json
     */
    public function recentLendNum(){
        $res=EquipmentBorrow::zxl_getrecentlendnum();
        return $res!=null?
        json_success("获取近期借用设备单数成功!",$res,200):
        json_fail("获取近期借用设备单数失败!",null,100);
    }

    /**
     * 近期设备借用数量
     * @author zhuxianglin <github.com/lybbor>
     * @return json
     */
    public function recentLendSum(){
        $res=EquipmentBorrow::zxl_getrecentlendsum();
        return $res!=null?
        json_success("获取近期借用设备数量成功!",$res,200):
        json_fail("获取近期借用设备数量失败!",null,100);
    }

    /**
     * 实验室教学检查情况
     * @author zhuxianglin <github.com/lybbor>
     * @return json
     */
    public function checkedLab(){
        $res=EquipmentBorrow::zxl_checkedlab();
        return $res!=null?
        json_success("获取实验室教学检查情况成功!",$res,200):
        json_fail("获取实验室教学检查情况失败!",null,100);
    }

    /**
     * 教师检查统计
     * @author zhuxianglin <github.com/lybbor>
     * @return json
     */
    public function teacherCheck(){
        $res=EquipmentBorrow::zxl_teachercheck();
        return $res!=null?
        json_success("获取教师检查统计成功!",$res,200):
        json_fail("获取教师检查统计失败!",null,100);
    }

}
