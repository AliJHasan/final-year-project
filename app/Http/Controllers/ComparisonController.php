<?php

namespace App\Http\Controllers;

use App\Http\Resources\ComparisonResource;
use App\Models\ComparisonLiterary;
use App\Models\ComparisonScientific;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComparisonController extends Controller
{

    //show Comparison for student.
    public function show(Request $request){
        $x = $request['subscriptionNumber'];
        $user = DB::table('users')->where('subscriptionNumber', $x)->first();
        if ($user->branch=='Scientific') {
            $res = ComparisonScientific::all();
            return response()->json(ComparisonResource::collection($res));
        }
        if ($user->branch=='litterary') {
            $res = ComparisonLiterary::all();
            return response()->json(ComparisonResource::collection($res));
        }
    }
    //


    // choose language for student.
    public function choose(Request $request){
        $x = $request['subscriptionNumber'];
        $y = $request['language'];
        $user = DB::table('users')->where('subscriptionNumber', $x)->first();
        if ($user->branch=='Scientific') {
            $details = DB::table('resultscientific')->where('subscriptionNumber', $x)->first();
            if($y=='English'){
                $res = $details->sum - $details->france;
                DB::table('resultscientific')->where('subscriptionNumber',$x)->update(['final'=>$res]);
                return Response()->json('done');
            }
            if($y=='France'){
                $res = $details->sum - $details->english;
                DB::table('resultscientific')->where('subscriptionNumber',$x)->update(['final'=>$res]);
                return Response()->json('done');
            }
        }
        if ($user->branch=='litterary') {
            $details = DB::table('resultliterary')->where('subscriptionNumber', $x)->first();
            if($y=='English'){
                $res = $details->sum - $details->france;
                DB::table('resultliterary')->where('subscriptionNumber',$x)->update(['final'=>$res]);
                return Response()->json('done');
            }
            if($y=='France'){
                $res = $details->sum - $details->english;
                DB::table('resultliterary')->where('subscriptionNumber',$x)->update(['final'=>$res]);
                return Response()->json('done');
            }
        }
    }
    //


    // show desires <= student final mark.
    public function showRigester(Request $request){
        $x = $request['subscriptionNumber'];
        $y = $request['total'];
        $user = DB::table('users')->where('subscriptionNumber', $x)->first();
        if ($user->branch=='Scientific') {
            $res = ComparisonScientific::where('avg','<=',$y)->get();
            return response()->json(ComparisonResource::collection($res));
        }
        if ($user->branch=='litterary') {
            $res = ComparisonLiterary::where('avg','<=',$y)->get();
            return response()->json(ComparisonResource::collection($res));
        }
    }


    // show final mark for student.
    public function showFinalResult(Request $request){
        $x = $request['subscriptionNumber'];
        $user = DB::table('users')->where('subscriptionNumber', $x)->first();
        if ($user->branch=='Scientific') {
            $details = DB::table('resultscientific')->where('subscriptionNumber', $x)->first();
            $res['fenal'] = $details->final;
            $res['branch'] = $user->branch;
            return response()->json($res);
        }
        if ($user->branch=='litterary') {
            $details = DB::table('resultliterary')->where('subscriptionNumber', $x)->first();
            $res['fenal'] = $details->final;
            $res['branch'] = $user->branch;
            return response()->json($res);
        }
    }


    public function showDesire(Request $request){
        $input = $request->all();
        $name = DB::table('users')->where('subscriptionNumber',$input['subscriptionNumber'])->first();
        if($name->branch=='litterary'){
            $x = DB::table('comparisonresult_l')->where('subscriptionNumber',$input['subscriptionNumber'])->first();
            $y = DB::table('comparisonliterary')->where('id',$x->comparisonId)->first();
            $y->fullName = $name->fullName;
            return response()->json($y);
        }
        if($name->branch=='Scientific'){
            $x = DB::table('comparisonresult_s')->where('subscriptionNumber',$input['subscriptionNumber'])->where('status',"true")->first();
            $y = DB::table('comparisonscientific')->where('id',$x->comparisonId)->first();
            $y->fullName = $name->fullName;
            return response()->json($y);
        }
    }

    public function algorithm(){
        $students = DB::table('resultscientific')->select('subscriptionNumber','final')
        ->orderBy('final','desc')
            ->orderBy('math','desc')
            ->orderBy('arabic','desc')
            ->get();

        foreach ($students as $student){
            $desires = DB::table('comparisonresult_s')->select('comparisonId')
            ->where('subscriptionNumber',$student->subscriptionNumber)
                ->orderBy('desireId','asc')
                ->get();

            foreach ($desires as $desire){
                $mark = DB::table('comparisonscientific')->select('maxStudentsNumber')
                    ->where('id',$desire->comparisonId)
                    ->first();

                if ($mark->maxStudentsNumber > 0){
                    DB::table('comparisonscientific')->where('id',$desire->comparisonId)->update(['maxStudentsNumber'=>$mark->maxStudentsNumber-1]);
                    DB::table('comparisonresult_s')->where('subscriptionNumber',$student->subscriptionNumber)
                        ->where('comparisonId',$desire->comparisonId)
                        ->update(['status'=>"true"]);
                    break;
                }
            }
        }
        return response()->json("done");


    }
}
