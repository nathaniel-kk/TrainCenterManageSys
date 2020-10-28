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

Route::prefix('eqlen')->namespace('DataScreen')->group(function(){
    Route::get('recentwait','EquipmentLendController@recentWait');
    Route::get('recentlend','EquipmentLendController@recentLend');
    Route::get('isoverdue','EquipmentLendController@isOverdue');
    Route::get('facultylend','EquipmentLendController@facultyLend');
    Route::get('recentlendnum','EquipmentLendController@recentLendNum');
    Route::get('recentlendsum','EquipmentLendController@recentLendSum');

});

Route::prefix('check')->namespace('DataScreen')->group(function(){
    Route::get('checkedlab','EquipmentLendController@checkedLab');
    Route::get('teachercheck','EquipmentLendController@teacherCheck');
});