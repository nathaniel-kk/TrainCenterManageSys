<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachingInspectionInfo extends Model
{
    protected $table = "teaching_inspection_info";
    public $timestamps = true;
    protected $guarded = [];
        /*
         * 展示id对应的表单
         * @author caiwenpin <github.com/codercwp>
         * @param $id
         * return result
         */
    public static function show($id){
        $data = self::where('form_id', $id)->get();
        return $data;
    }
      /*
      * 展示id对应的实验室与表单信息
      * @author caiwenpin <github.com/codercwp>
      * @param $id
      * return result
      */
    public static function one($id){
        $data1 = self::where('laboratory_id', $id)->first();
        $data2 = Laboratory::where('laboratory_id', $id)->first();

        $data['laboratory_name'] = $data2['laboratory_name'];
        $data['laboratory_id'] = $data1['laboratory_id'];
        $data['class_name'] = $data1['class_name'];
        $data['teacher'] = $data1['teacher'];
        $data['teach_operating_condition'] = $data1['teach_operating_condition'];
        $data['operating_condition'] = $data1['operating_condition'];
        $data['remark'] = $data1['remark'];
        return $data;
    }
      /*
      * 将数据存入数据库
      * @author caiwenpin <github.com/codercwp>
      * @param $id，$data
      * return result
      */
    public static function add($id, $data){
        try {
            for($i=0;$i<count($data);$i++) {
                $result = self::create([
                    'form_id' => $id,
                    'laboratory_id' => $data[$i]['laboratory_id'],
                    'class_name' => $data[$i]['class_name'],
                    'teacher' => $data[$i]['teacher'],
                    'teach_operating_condition' => $data[$i]['teach_operating_condition'],
                    'operating_condition' => $data[$i]['operating_condition'],
                    'remark' => $data[$i]['remark'],
                ]);

            }
            return $result;
        } catch (\Exception $e) {
            logError('增加错误', [$e->getMessage()]);
        }
    }

}
