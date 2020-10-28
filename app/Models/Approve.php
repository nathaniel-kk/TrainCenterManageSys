<?php

namespace App\Models;

use http\Exception;
use Illuminate\Database\Eloquent\Model;

class Approve extends Model
{
    protected $table = "approve";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 审核不通过 更改表中的姓名（5之前 包括5）
     * @param $form_id
     * @param $role
     * @param $name
     * @return json
     */


    //更新借用部门人nam
    public static function updateName($form_id,$role,$name){
        $form_status = Form::findStatus($form_id);
        try{
            if ($form_status == 1 && $role == '借用部门负责人'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'borrowing_department_name' => $name,
                            'updated_at' => now()
                        ]
                    );
                return $data;
            }else if($form_status == 3  && $role == '实验室借用管理员'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'borrowing_manager_name' => $name,
                            'updated_at' => now()
                        ]
                    );
                return $data;
            }else if( $form_status == 5 && $role == '实验室中心主任'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'center_director_name' => $name,
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

    /**
     * 审核不通过 更改表中的姓名（5之后）
     * @param $form_id
     * @param $role
     * @param $name
     * @return json
     */
    public static function updateNames($form_id,$role,$name){
        $form_status = Form::findStatus($form_id);
        try{
            if($form_status == 7&& $role == '设备管理员'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'device_administrator_out_name' => $name,
                            'updated_at' => now()
                        ]
                    );
                return $data;
            }else if($form_status == 9 && $role == '设备管理员'){
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

    /**
     *
     * 审核不通过 更改表中的姓名以及原因（5之前 包括5）
     * @param $form_id
     * @param $role
     * @param $name
     * @param $reason
     * @return json
     */
    public static function noUpdateName($form_id,$role,$name,$reason){
        $form_status = Form::findStatus($form_id);
        try{
            if ($form_status == 1 && $role == '借用部门负责人'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'borrowing_department_name' => $name,
                            'reason' => $reason,
                            'updated_at' => now()
                        ]
                    );
                return $data;
            }else if($form_status == 3 && $role == '实验室借用管理员'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'borrowing_manager_name' => $name,
                            'reason' => $reason,
                            'updated_at' => now()
                        ]
                    );
                return $data;
            }else if( $form_status == 5 && $role == '实验室中心主任'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'center_director_name' => $name,
                            'reason' => $reason,
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

    /**
     * 审核不通过 更改表中的姓名以及原因(5之后)
     * @param $form_id
     * @param $role
     * @param $name
     * @param $reason
     * @return json
     */
    public static function noUpdateNames($form_id,$role,$name,$reason){
        $form_status = Form::findStatus($form_id);
        try{
            if($form_status == 7 && $role == '设备管理员'){
                $data = self::where('form_id', $form_id)
                    ->update(
                        [
                            'device_administrator_out_name' => $name,
                            'reason' => $reason,
                            'updated_at' => now()
                        ]
                    );
                return $data;
            }else if($form_status == 9 && $role == '设备管理员'){
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
