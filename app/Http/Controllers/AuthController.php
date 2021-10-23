<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator= Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|max:255',
            'city' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {

            return response()->json($validator->errors(),401);
        }
        else{
        $user = new User(['name' => $request->name,
            'email' => $request->email,
            'password' =>bcrypt($request->password),
            'role' => $request->role,
            'city' => $request->city,
        ]);
        $user->save();
    }

        return response()->json("user has been Registered",200);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',

        ]);

        if ($validator->fails()) {

            return response()->json($validator->errors(), 401);
        } else {


    $credintals=request(['email','password']);
    if(!Auth::attempt($credintals)){
        return response()->json(['message'=> 'enter a valid email or password'],401);
    }
else{
    $user=$request->user();
    $tokenResult=$user->createToken('Personal Access Token');
    $token=$tokenResult->token;
    $token->expires_at=Carbon::now()->addWeeks(1);
    $token->save();

    return response()->json([
        'data'=>[
            'user'=>Auth::user(),
            'access_token'=>$tokenResult,
            'token_type'=>'Bearer',
            'expires_at'=>Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]
        ]);
    }
    }

}


    public function show(Request $request){

return response()->json(User::find($request->id));

    }

}
