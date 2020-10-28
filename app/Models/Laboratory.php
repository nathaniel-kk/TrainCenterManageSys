<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Laboratory extends Model
{
    protected $table = "laboratory";
    public $timestamps = true;
    protected $guarded = [];

    public static function ysx_showxibu(){

        try {
            $res = DB::table('xibuview')->get();
            return $res;
        } catch (\Exception $e) {
            logError('失败',[$e->getMessage()]);
            return null;
        }
    }
     public static function ysx_showusing(){

         try {
             $res = DB::table('usingsite')->get();
             return $res;
         } catch (\Exception $e) {
             logError('失败',[$e->getMessage()]);
             return null;
         }
     }

     public static function ysx_showranking(){
         try {
             $res = DB::table('siteranking')->get();
             return $res;
         } catch (\Exception $e) {
             logError('失败',[$e->getMessage()]);
             return null;
         }
     }

     public static function ysx_showopenlab(){
         try {
             $res = DB::table('openlab')->get();
             return $res;
         } catch (\Exception $e) {
             logError('失败',[$e->getMessage()]);
             return null;
         }
     }

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
