<?php

namespace App\Http\Controllers\web;

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

        if (Auth::id()) {
            return redirect('/');
        }
        if ($request->isMethod("post")) {

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

            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $this->response['message'] = 'Invailed login details';
                return response()->json($this->response, $this->response['code']);
            }

            $user = User::find(Auth::id());
            $this->response['success'] = true;
            $this->response['code'] = STATUS_OK;
            $this->response['message'] = 'Rigster Successfully.';
            $this->response['data'] = $user;

            return response()->json($this->response, $this->response['code']);
        } else {
            return view("auth.login");
        }
    }

    // register new user
    public function register(Request $request)
    {

        if (Auth::id()) {
            return redirect('/');
        }
        if ($request->isMethod("post")) {

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

            // login in web after signup
            auth()->login($user);
            
            $this->response['success'] = true;
            $this->response['code'] = STATUS_OK;
            $this->response['message'] = 'Rigster Successfully.';
            $this->response['data'] = $user;

            return response()->json($this->response, $this->response['code']);
        } else {
            return view("auth.signup");
        }
    }



    public function logout()
    {
        Auth::logout();
        return  redirect('/');
    }
}
