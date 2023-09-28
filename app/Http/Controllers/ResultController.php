<?php

namespace App\Http\Controllers;
use App\Models\ResultLiterary;
use App\Models\ResultScientific;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function show(Request $request)
    {
        $res = $request->all();
        $x = $res['subscriptionNumber'];
        $user = DB::table('users')->where('subscriptionNumber', $x)->first();
        if (is_null($user)) {
            $s['message'] = 'student not found';
            return response()->json($s, 404);
        }

        if ($user->branch == 'Scientific') {
            $get = DB::table('resultscientific')->where('subscriptionNumber', $x)->first();
            $get->fullName = $user->fullName;
            $get->branch = $user->branch;
            $get->schoolName = $user->schoolName;
            $get->motherName = $user->motherName;
            if (!($get->privilge)) {
                $s['message'] = "you are not allowed to access this mark now";
                return response()->json($s, 403);
            }
            return response()->json($get);
        }

        if ($user->branch == 'litterary') {
            $get = DB::table('resultliterary')->where('subscriptionNumber', $x)->first();
            $get->fullName = $user->fullName;
            $get->branch = $user->branch;
            $get->schoolName = $user->schoolName;
            $get->motherName = $user->motherName;
            if (!($get->privilge))
                return response()->json("this proccess isn't allowed now", 403);
            return response()->json($get);
        }
    }

    public function showMyMark(Request $request)
    {
        $res = $request->all();
        $x = $res['subscriptionNumber'];
        $user = DB::table('users')->where('subscriptionNumber', $x)->first();

        if (is_null($user)) {
            return response()->json('student not found', 404);
        }
        if ($user->branch == 'Scientific') {
            $get = DB::table('resultscientific')->where('subscriptionNumber', $x)->first();
            $get->fullName = $user->fullName;
            $get->branch = $user->branch;
            $get->schoolName = $user->schoolName;
            $get->motherName = $user->motherName;
            return response()->json($get);
        }

        if ($user->branch == 'litterary') {
            $get = DB::table('resultliterary')->where('subscriptionNumber', $x)->first();
            $get->fullName = $user->fullName;
            $get->branch = $user->branch;
            $get->schoolName = $user->schoolName;
            $get->motherName = $user->motherName;
            return response()->json($get);
        }

    }

    public function priviliges(Request $request)
    {
        $x = $request['status'];
        $y = $request['subscriptionNumber'];
        $user = DB::table('users')->where('subscriptionNumber', $y)->first();
        if ($user->branch=='Scientific') {
            if ($x==1){
                DB::table('resultscientific')->where('subscriptionNumber',$y)->update(['privilge'=>1]);
            }
            else{
                ResultScientific::where('subscriptionNumber',$y)->update(array('privilge'=>0));
            }
            return response()->json("done");
        }

        if ($user->branch=='litterary') {
            if ($x==1){
                DB::table('resultliterary')->where('subscriptionNumber',$y)->update(['privilge'=>1]);
            }
            else{
                ResultLiterary::where('subscriptionNumber',$y)->update(array('privilge'=>0));
            }
            return response()->json("done");
        }


    }



    public function showPriviliges(Request $request)
    {
        $x = $request['subscriptionNumber'];
        $user = DB::table('users')->where('subscriptionNumber', $x)->first();
        if ($user->branch=='Scientific') {
            $s = DB::table('resultscientific')->where('subscriptionNumber', $x)->first();
            $res['status'] = $s->privilge;
            return response()->json($res);
        }

        if ($user->branch=='litterary') {
            $s = DB::table('resultliterary')->where('subscriptionNumber', $x)->first();
            $res['status'] = $s->privilge;
            return response()->json($res);
        }


    }
}

