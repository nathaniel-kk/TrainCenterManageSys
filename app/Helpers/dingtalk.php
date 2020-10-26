<?php

if (!function_exists('getDinginfo')) {
    /**
     * 获取钉钉用户信息
     * @param $code
     */
    function getDinginfo($code)
    {
        // $app = getApp();
        // $app->user->getUserByCode($code);

        $info = json_encode([
            'name'=>'汤海',
            'tel' =>'12312341234',
            'role'=>'实验室中心主任'
        ]);
        $data = json_decode($info);
        return $data;
    }
}
