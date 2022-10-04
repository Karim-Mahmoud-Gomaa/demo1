<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Facades\UserFacade as User;
use App\Models\User as UserModel;

class AuthController extends Controller
{
    public $successStatus = 200;
    
    public function login(Request $request)
    { 
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $success = User::login($request->email,$request->password,$request->code);
        if ($success) {
            return response()->json(['success' => $success], $this->successStatus);
        }
        return response()->json(["error" => "Your Email Or Password is wrong.."], 401);
    }
    public function user(Request $request)
    {
        $success=$request->User();
        return response()->json(['success' => $success], 200);
    }
    public function logout(Request $request)
    {
        User::logout($request->user());
        return response()->json(['success' => 'done'], 200);
    }
    public function profileUpdate(Request $request,UserModel $user)
    {
        $request->validate([
            'name'=>'nullable|max:100',
            'password'=>'nullable',
            'email'=>'nullable|unique:users,email,'.$user->id,
        ]);
        User::update($user->id,$request);
        return response()->json(['success' => 'done'], $this->successStatus);
    }
    
}
