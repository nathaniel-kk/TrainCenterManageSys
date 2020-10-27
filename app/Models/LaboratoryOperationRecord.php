<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaboratoryOperationRecord extends Model
{
    protected $table = "laboratory_operation_records";
    public $timestamps = true;
    protected $guarded = [];

    public static function abc(){
        $data = self::select('*')->get();
        return $data;
    }
}
