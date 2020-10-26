<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(){
        $code = 'xxxxx';
        $res  = getDinginfo($code);
        $tel  =  $res->tel;
    }
}
