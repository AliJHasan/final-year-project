<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\BaseController as BaseController ;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullName' => 'required',
            'motherName' => 'required',
            'schoolName' => 'required',
            'branch' => 'required',
            'subscriptionNumber' => 'required',
            'phoneNumber' => 'required',
            'password' => 'required',
        ]);


        if ($validator->fails()) {
        return BaseController::sendError('please check your error',$validator->errors());
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('Ali')->accessToken;
        $success['name'] = $user->fullName;
        return response()->json($success,200);
    }


    public function login(Request $request)
    {

        if (Auth::attempt(['subscriptionNumber' => $request->subscriptionNumber, 'phoneNumber' => $request->phoneNumber, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('Ali')->accessToken;
            $success['name'] = $user->fullName;
            return BaseController::sendResponse($success, 'user login successfully');
        }
        else{
            return BaseController::sendError('please check your error','Unauthorised');
        }

    }
}
