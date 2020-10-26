<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approve extends Model
{
    protected $table = "approve";
    public $timestamps = true;
    protected $guarded = [];

    //更新借用部门人name
    public static function updateName($form_id,$role,$name){
        $form_status = Form::findStatus($form_id);
        try{
            if (($form_status == 1 || $form_status == 2) && $role == '借用部门负责人'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'borrowing_department_name' => $name,
                            'updated_at' => now()
                        ]
                    );
                return $data;
            }else if(($form_status == 3 || $form_status == 4) && $role == '实验室借用管理员'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'borrowing_manager_name' => $name,
                            'updated_at' => now()
                        ]
                    );
                return $data;
            }
        }catch (Exception $e){
            logError('更新审核表中的姓名失败',[$e->getMessage()]);
            return null;
        }
    }

    //更改审核表中的姓名
    public static function updateNames($form_type,$form_id,$role,$name){
        $form_status = Form::findStatus($form_id);
        try{
            if (($form_type == 1 || $form_type ==5) && ($form_status == 5 || $form_status == 6)&& $role == '实验室中心主任'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'center_director_name' => $name,
                            'updated_at' => now()
                        ]
                    );
                return $data;
            }else if($form_type == 3 && ($form_status == 5 || $form_status == 6) && $role == '实验室中心主任'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'center_director_name' => $name,
                            'updated_at' => now()
                        ]
                    );
                return $data;
            }else if($form_type == 3 && ($form_status == 7 || $form_status == 8)&& $role == '设备管理员'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'device_administrator_out_name' => $name,
                            'updated_at' => now()
                        ]
                    );
                return $data;
            }else if($form_type == 3 && $form_status == 9 && $role == '设备管理员'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'device_administrator_acceptance_name' => $name,
                            'updated_at' => now()
                        ]
                    );
                return $data;
            }
        }catch (Exception $e){
            logError('更新审核表中的姓名失败',[$e->getMessage()]);
            return null;
        }
    }
}
