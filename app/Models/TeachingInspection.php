<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachingInspection extends Model
{

    protected $table = "teaching_inspection";
    public $timestamps = true;
    protected $guarded = [];
          /*
         * 添加表单
         * @author caiwenpin <github.com/codercwp>
         * @param $id
         * return result
         */
    public static function cwp_addId($id){
          try {
                $result = self::create([
                    'form_id' => $id,
                ]);
            return $result;
        } catch (\Exception $e) {
            logError('增加错误', [$e->getMessage()]);
        }
    }

}
