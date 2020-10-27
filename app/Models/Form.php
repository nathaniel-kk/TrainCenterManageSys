<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = "form";
    public $timestamps = true;
    protected $guarded = [];

    /**
     * 获取表单种类
     * @author Dujingwen <github.com/DJWKK>
     * @param $form_id
     * @return json
     *
     */
    public static function findType($form_id){
        try{
            $data = self::where('form_id',$form_id)
                ->select('type_id')
                ->get();
            return $data[0]->type_id;
        }catch(\Exception $e){
            logError('获取表单'.$form_id.'种类失败',[$e->getMessage()]);
            return null;
        }
    }


    /**
     * 获取表单状态
     * @author Dujingwen <github.com/DJWKK>
     * @param $form_id
     * @return json
     */
    public static function findStatus($form_id){
        try{
            $data = self::where('form_id',$form_id)
                ->select('form_status')
                ->get();
            return $data[0]->form_status;
        }catch(\Exception $e){
            logError('获取表单'.$form_id.'状态失败',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 审核通过 更新表单状态（5之前的状态）
     * @author Dujingwen <github.com/DJWKK>
     * @param $form_status
     * @return json
     */
    public static function updatedStatus($role,$form_id,$form_status){
        try{
            if ($form_status == 1 && $role == '借用部门负责人'){
                $data = self::where('form_id',$form_id)
                    ->increment('form_status',2);
                return $data;
            }else if( $form_status == 3 && $role == '实验室借用管理员'){
                $data = self::where('form_id',$form_id)
                    ->increment('form_status',2);
                return $data;
            }
        }catch(\Exception $e){
            logError('获取表单'.$form_status.'种类失败',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 审核通过 更新表单状态（5之后的状态）
     * @author Dujingwen <github.com/DJWKK>
     * @param $form_type
     * @param $role
     * @param $form_id
     * @param $form_status
     * @return json
     */
    public static function updatedStatuss($form_type,$role,$form_id,$form_status){
        try{
            if(($form_type == 1 || $form_type ==5)  && $form_status == 5 && $role == '实验室中心主任'){
                $data = self::where('form_id',$form_id)
                    ->increment('form_status',6);
                return $data;
            }else if($form_type == 3 && $form_status == 5 && $role == '实验室中心主任'){
                $data = self::where('form_id',$form_id)
                    ->increment('form_status',2);
                return $data;
            }else if($form_type == 3 && ($form_status == 7 || $form_status == 9)&& $role == '设备管理员'){
                $data = self::where('form_id',$form_id)
                    ->increment('form_status',2);
                return $data;
            }
        }catch(\Exception $e){
            logError('获取表单'.$form_status.'种类失败',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 审核不通过 更新表单状态（5之前的状态）
     * @author Dujingwen <github.com/DJWKK>
     * @param $role
     * @param $form_id
     * @param $form_status
     * @return json
     */
    public static function noUpdateStatus($role,$form_id,$form_status){
        try{
            if ($form_status == 1 && $role == '借用部门负责人'){
                $data = self::where('form_id',$form_id)
                    ->increment('form_status',1);
                return $data;
            }else if( $form_status == 3 && $role == '实验室借用管理员'){
                $data = self::where('form_id',$form_id)
                    ->increment('form_status',1);
                return $data;
            }else if($form_status == 5 && $role == '实验室中心主任'){
                $data = self::where('form_id',$form_id)
                    ->increment('form_status',1);
                return $data;
            }
        }catch(\Exception $e){
            logError('获取表单'.$form_status.'种类失败',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 审核不通过 更新表单状态（5之后的状态）
     * @author Dujingwen <github.com/DJWKK>
     * @param $role
     * @param $form_id
     * @param $form_status
     * @return json
     */
    public static function npUpdatedStatuss($role,$form_id,$form_status){
        try{
            if($form_status == 7 && $role == '设备管理员'){
                $data = self::where('form_id',$form_id)
                    ->increment('form_status',1);
                return $data;
            }else if($form_status == 9 && $role == '设备管理员'){
                $data = self::where('form_id',$form_id)
                    ->increment('form_status',0);
                return $data;
            }
        }catch(\Exception $e){
            logError('获取表单'.$form_status.'种类失败',[$e->getMessage()]);
            return null;
        }
    }
}
