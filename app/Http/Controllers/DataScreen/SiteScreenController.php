<?php

namespace App\Http\Controllers\DataScreen;

use App\Http\Controllers\Controller;
use App\Models\Laboratory;
use Illuminate\Http\Request;

class SiteScreenController extends Controller
{
    /**
     * 系部展示
     * @author yuanshuxin <github.com/CoderYsx>
     * @return \Illuminate\Http\JsonResponse
     */
    public function xibuborrow(){
        //echo "系部";
        $res=Laboratory::ysx_showxibu();
        return $res ?
            \json_success('获取成功!',$res,'200'):
            \json_fail('获取失败!',null,'100');

    }

    /**
     * 使用中的场地展示
     * @author yuanshuxin <github.com/CoderYsx>
     * @return \Illuminate\Http\JsonResponse
     */
    public function usingsite(){
        //echo "使用";
        $res=Laboratory::ysx_showusing();
        return $res ?
            \json_success('获取成功!',$res,'200'):
            \json_fail('获取失败!',null,'100');


    }

    /**
     * 场地使用排名
     * @author yuanshuxin <github.com/CoderYsx>
     * @return \Illuminate\Http\JsonResponse
     */
    public function siteranking(){
        //echo "排名";
        $res=Laboratory::ysx_showranking();
        return $res ?
            \json_success('获取成功!',$res,'200'):
            \json_fail('获取失败!',null,'100');

    }

    /**
     * 场地使用数量
     * @author yuanshuxin <github.com/CoderYsx>
     * @return \Illuminate\Http\JsonResponse
     */
    public function sitenumber(){
        //echo "数量";
        $res=Laboratory::ysx_shownumber();
        return $res ?
            \json_success('获取成功!',$res,'200'):
            \json_fail('获取失败!',null,'100');
    }

    /**
     * 开放实验室
     * @return \Illuminate\Http\JsonResponse
     */
    public function openlab(){
        //echo "开放";
        $res=Laboratory::ysx_showopenlab();
        return $res ?
            \json_success('获取成功!',$res,'200'):
            \json_fail('获取失败!',null,'100');
    }
}

















