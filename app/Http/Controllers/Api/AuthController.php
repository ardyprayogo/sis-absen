<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\User;
use DB;
use Auth;

class AuthController extends BaseApiController
{
    public function rules() {
        return [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function register(Request $request) {
        try {
            $this->_validators($request, $this->rules());
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $token = $user->createToken('Laravel Password Grant Client');
            $accessToken = $token->accessToken;
            $expired = $token->token->expires_at->format('Y-m-d H:i:s');
            // $this->employeeRepo->saveEmployee($request, $user);
            DB::commit();
            return $this->_responseSuccess("Registrasi berhasil!", [
                'access_token' => $accessToken,
                'expired' => $expired
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->_responseError($th->getMessage());
        }
        
    }

    public function login(Request $request) {
        try {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password
            ];
            if (Auth::attempt($credentials)) {
                $token = Auth::user()->createToken('Laravel Password Grant Client');
                $accessToken = $token->accessToken;
                $expired = $token->token->expires_at->format('Y-m-d H:i:s');
                return $this->_responseSuccess("Login berhasil!", [
                    'access_token' => $accessToken,
                    'expired' => $expired
                ]);
            } else {
                return $this->_responseError("Login gagal!");
            }
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }

    public function tes(Request $request) {
        try {
            $user = Auth::user();
            return $this->_responseSuccess(Auth::user());
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
        
    }
}
