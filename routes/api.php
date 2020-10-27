<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
 * @author HuWeiChen <github.com/nathaniel-kk>
 */
Route::prefix('fill')->namespace('Fill')->group(function () {
    Route::get('filllabborlink', 'FillLabBorController@fillLabBorLink'); //填报实验室借用申请实验室名称编号联动
    Route::get('filllabnamedis', 'FillLabBorController@fillLabNameDis'); //填报实验室借用申请实验室名称展示
    Route::get('filllabclassdis', 'FillLabBorController@fillLabClassDis'); //填报实验室借用申请学生班级展示
    Route::post('filllabborrow', 'FillLabBorController@fillLabBorrow'); //填报实验室借用申请
    Route::get('viewlabborrow', 'FillLabBorController@viewLabBorrow'); //实验室借用申请展示
});

/**
 * @author HuWeiChen <github.com/nathaniel-kk>
 */
Route::prefix('fill')->namespace('Fill')->group(function () {
    Route::post('openlabusebor', 'OpenLabUseController@openLabUseBor'); //开放实验室使用申请填报
    Route::get('viewopenlabuse', 'OpenLabUseController@viewOpenLabUse'); //开放实验室使用申请表单展示
    Route::get('viewopenlabmanuse', 'OpenLabUseController@viewOpenLabManUse'); //开放实验室使用申请人员名单展示
});
