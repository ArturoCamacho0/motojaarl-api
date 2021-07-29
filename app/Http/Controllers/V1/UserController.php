<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request){
        $validation = Validator::make($request->all(), [
            "nickname" => "required",
            "password" => "required",
            "remember_token" => "boolean"
        ]);

        if($validation->fails()){
            return response(array(
                "message" => "The user don't exists",
                "status" => "error",
                "errors" => $validation->errors()
            ), 404);
        }

        $credentials = request(['nickname', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'user' => $user,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    public function logout()
    {
        if(auth()->user()->token()->revoke())
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
    }

    public function index()
    {
        $users = User::all();

        if(count($users) === 0){
            return response(array(
                "message" => "No users",
            ), 404);
        }
        return response(array(
            "users" => $users
        ), 200);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required",
            "surname" => "required",
            "nickname" => "required",
            "email" => "email|unique:users",
            "password" => "required"
        ]);

        if($validation->fails()){
            return response(array(
                "message" => "The user hasn't been created",
                "status" => "error",
                "errors" => $validation->errors()
            ), 400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->nickname = $request->nickname;
        $user->email = $request->email ? $request->email : null;
        $user->password = password_hash($request->password, PASSWORD_BCRYPT, ['cost' => 4]);

        if($user->save()){
            return response(array(
                "message" => "The user has been created",
                "status" => "success",
            ), 201);
        }else{
            return response(array(
                "message" => "The user hasn't been created",
                "status" => "error",
            ), 500);
        }
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required",
            "surname" => "required",
            "nickname" => "required",
            "email" => "email|unique:users,email,".$id
        ]);

        if($validation->fails()){
            return response(array(
                "message" => "The user hasn't been created",
                "status" => "error",
                "errors" => $validation->errors()
            ), 400);
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->nickname = $request->nickname;
       if($request->email)
           $user->email = $request->email;
        if($request->password)
            $user->email = password_hash($request->password, PASSWORD_BCRYPT, ['cost' => 4]);

        if($user->save()){
            return response(array(
                "message" => "The user has been updated",
                "status" => "success",
                "user" => $user
            ), 201);
        }else{
            return response(array(
                "message" => "The user hasn't been updated",
                "status" => "error",
            ), 500);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if(!isset($user))
            return response(array(
                "message" => "The user don't exists",
                "status" => "error"
            ), 404);

        if($user->delete()) {
            return response(array(
                "message" => "The user has been deleted",
                "status" => "success"
            ), 200);
        }else{
            return response(array(
                "message" => "The user hasn't been deleted",
                "status" => "error"
            ), 500);
        }
    }
}
