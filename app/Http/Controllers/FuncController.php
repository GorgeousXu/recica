<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FuncController extends Controller
{
    public function funcTest($s = '111',$p=['s','ss']){
        $a = func_get_arg(0);
        $b = func_get_args();
        $c = get_called_class();
        echo __METHOD__."\n";
        echo __CLASS__."\n";
        echo $a."\n";
        echo $c."\n";
        var_dump($b);
//        dd($b);
    }
}
