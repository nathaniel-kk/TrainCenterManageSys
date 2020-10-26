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
