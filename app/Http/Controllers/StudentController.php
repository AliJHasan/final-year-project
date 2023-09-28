<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function showScientific(){
        $res = DB::table('users')->where('branch','Scientific')->get();
        return response()->json($res);
    }

    public function showLitterary(){
        $res = DB::table('users')->where('branch','litterary')->get();
        return response()->json($res);
    }
}
