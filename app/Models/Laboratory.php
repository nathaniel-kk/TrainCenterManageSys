<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Laboratory extends Model
{
    protected $table = "laboratory";
    public $timestamps = true;
    protected $guarded = [];


    /**
     * 系部展示
     * @author yuanshuxin <github.com/CoderYsx>
     * @return \Illuminate\Http\JsonResponse
     */
    public static function ysx_showxibu(){

        try {
            $res = DB::table('xibuview')->get();
            return $res;
        } catch (\Exception $e) {
            logError('失败',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 使用中的场地展示
     * @author yuanshuxin <github.com/CoderYsx>
     * @return \Illuminate\Http\JsonResponse
     */
     public static function ysx_showusing(){

         try {
             $res = DB::table('usingsite')->get();
             return $res;
         } catch (\Exception $e) {
             logError('失败',[$e->getMessage()]);
             return null;
         }
     }


    /**
     * 场地排名
     * @author yuanshuxin <github.com/CoderYsx>
     * @return \Illuminate\Http\JsonResponse
     */
     public static function ysx_showranking(){
         try {
             $res = DB::table('siteranking')->get();
             return $res;
         } catch (\Exception $e) {
             logError('失败',[$e->getMessage()]);
             return null;
         }
     }
    /**
     * 开放实验室
     * @author yuanshuxin <github.com/CoderYsx>
     * @return \Illuminate\Http\JsonResponse
     */
     public static function ysx_showopenlab(){
         try {
             $res = DB::table('openlab')->get();
             return $res;
         } catch (\Exception $e) {
             logError('失败',[$e->getMessage()]);
             return null;
         }
     }
    /**
     * 场地数量
     * @author yuanshuxin <github.com/CoderYsx>
     * @return \Illuminate\Http\JsonResponse
     */
     public static function ysx_shownumber(){
         try {
             $res = DB::table('sitenumber')->get();
             return $res;
         } catch (\Exception $e) {
             logError('失败',[$e->getMessage()]);
             return null;
         }

     }
}
