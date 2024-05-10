<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public $response = ['success' => false, 'message' => 'Something went wrong', 'code' => STATUS_BAD_REQUEST];
    public function login(Request $request)
    {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->response['code']);
        }

        // check authuntication

        if (!Auth::attempt(['email'=> $request->email,'password'=> $request->password])) {
            $this->response['message'] = 'Invailed login details';
            return response()->json($this->response, $this->response['code']);
        }

        $user = User::find(Auth::id());

        // create access token

        $user->access_token = $user->createToken($user->id . 'token')->plainTextToken;

        $this->response['success'] = true;
        $this->response['code'] = STATUS_OK;
        $this->response['message'] = 'Rigster Successfully.';
        $this->response['data'] = $user;

        return response()->json($this->response, $this->response['code']);
    }

    public  function register(Request $request)
    {
        $rules = [
            'name' => ['required', 'max:125'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->response['message'] = $validator->errors()->first();
            return response()->json($this->response, $this->response['code']);
        }

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        // create access token

        $user->access_token = $user->createToken($user->id . 'token')->plainTextToken;

        $this->response['success'] = true;
        $this->response['code'] = STATUS_OK;
        $this->response['message'] = 'Rigster Successfully.';
        $this->response['data'] = $user;

        return response()->json($this->response, $this->response['code']);
    }

    public function getProfile(Request $request)
    {
        $user = Auth::user();
        $this->response['success'] = true;
        $this->response['code'] = STATUS_OK;
        $this->response['message'] = 'Fetching profile info.';
        $this->response['data'] = $user;
        return response()->json($this->response, $this->response['code']);
    }

    public function logout()
    {
        $user = Auth::user();

        $user->tokens->each(function ($token,$key){
            $token->delete();
        });

        $this->response['success'] = true;
        $this->response['code'] = STATUS_OK;
        $this->response['message'] = 'Logout successfully.';
        return response()->json($this->response, $this->response['code']);
    }
}
