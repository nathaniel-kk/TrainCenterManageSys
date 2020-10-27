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
Route::prefix('/approval')->namespace('Approval')->group(function(){
    Route::get('pass','ExamController@pass');
    Route::get('noPass','ExamController@noPass');
});



/**
 * @author yangsiqi <github.com/Double-R111>
 */
Route::prefix('approval')->namespace('Approval')->group(function () {
    Route::get('showall', 'ApproveHistoryController@showAll');
    Route::get('searchform', 'ApproveHistoryController@searchForm');
    Route::get('selecttype', 'ApproveHistoryController@selectType');
    Route::get('reshowlabloan', 'ApproveHistoryController@reshowLabLoan');
    Route::get('reshowopenlab', 'ApproveHistoryController@reshowOpenLab');
    Route::get('reshowlabins', 'ApproveHistoryController@reshowLabIns');
});


Route::get('test','TestController@test');

/*
 * @auther ZhongChun <github.com/RobbEr929>
 */
Route::prefix('approval')->namespace('Approval')->group(function () {//审批展示路由组
    Route::get('show','ApprovalController@show');//展示所有待审批表单
    Route::get('classify','ApprovalController@classify');//分类查询待审批表单
    Route::get('select','ApprovalController@select');//根据表单编号和姓名模糊查询表单
    Route::get('reshow','ApprovalController@reShow');//分类回显
    Route::get('reshowsys','ApprovalController@reShowSys');//回显实验室借用申请
    Route::get('reshowopensys','ApprovalController@reShowOpenSys');//回显开放实验室使用申请
    Route::get('reshowsysins','ApprovalController@reShowSysIns');//回显实验室仪器借用申请
});

