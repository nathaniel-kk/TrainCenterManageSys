<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test','TestController@test');
/**
 * @author tangshengyou
 * 填报 功能耶，表单列表的的回显
 */
Route::group(['namespace'=>'Fill','prefix'=>'fill'],function(){
    //登陆后根据权限显示可填写的表单
    Route::get('forminfo','ShowController@FormInfo');
    //根据类型 状态回显对应的表单列表
    Route::get('selectionform','ShowController@SelectionForm');
    //根据id查找对应的表单
    Route::get('selectform','ShowController@SelectForm');
    //点击查看按钮后 根据查看的form表单编号回显对应的表单
    Route::get('seeview','ShowController@SeeView');
    //设备借用 中下拉框中选中了对应的设备后回显数据
    Route::get('selectequipment','ShowController@SelectEquipment');

    Route::get('checkboxequipment','ShowController@CheckBoxEquipment');
    //设备借用填报
    Route::post('equipmentborrowing','DealFromController@EquipmentBorrowing');

    Route::get('adn','ShowController@adn');
});


