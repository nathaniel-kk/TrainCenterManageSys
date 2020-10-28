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

Route::prefix('site')->namespace('DataScreen')->group(function (){
    Route::get('/showxibu','SiteScreenController@xibuborrow');
    Route::get('/usingsite','SiteScreenController@usingsite');
    Route::get('/siteranking','SiteScreenController@siteranking');
    Route::get('/sitenumber','SiteScreenController@sitenumber');
    Route::get('/openlab','SiteScreenController@openlab');

});

Route::prefix('check')->namespace('DataScreen')->group(function (){
    Route::get('/safecheck','CheckController@SafeCheck');
    Route::get('/checkcount','CheckController@checkcount');
    Route::get('/checkstatis','CheckController@checkStatistics');
});



