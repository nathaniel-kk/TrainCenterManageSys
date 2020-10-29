<?php

namespace App\Http\Controllers\DataScreen;

use App\Http\Controllers\Controller;
use App\Models\TeachingInspectionInfo;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    /**
     * 实验室安全检查情况
     * @author yuanshuxin <github.com/CoderYsx>
     * @return \Illuminate\Http\JsonResponse
     */
    public function SafeCheck(){
        //echo "安全";
        $res=TeachingInspectionInfo::ysx_safecheck();
        return $res ?
            \json_success('获取成功!',$res,'200'):
            \json_fail('获取失败!',null,'100');

    }

    /**
     * 巡检数量统计
     * @author yuanshuxin <github.com/CoderYsx>
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkcount(){
        //echo "数量";
        $res=TeachingInspectionInfo::ysx_checkcount();
        return $res ?
            \json_success('获取成功!',$res,'200'):
            \json_fail('获取失败!',null,'100');
    }

    /**
     * 实验室检查统计
     * @author yuanshuxin <github.com/CoderYsx>
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStatistics(){
        //echo "统计";
        $res=TeachingInspectionInfo::ysx_checkStatistics();
        return $res ?
            \json_success('获取成功!',$res,'200'):
            \json_fail('获取失败!',null,'100');
    }
}
