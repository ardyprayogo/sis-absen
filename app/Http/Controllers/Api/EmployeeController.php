<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use App\Models\Employee\EmployeeRepository;
use App\Models\User;
use DB;
use Auth;
use Hash;

class EmployeeController extends BaseApiController
{
    private $repository;

    public function rules() {
        return [
            'email' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function __construct(EmployeeRepository $repo) {
        $this->repository = $repo;
    }

    public function get(Request $request) {
        try {
            $empoyee = $this->repository->listEmployee();
            return $this->_responseSuccess("Success", $empoyee);
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }

    public function create(Request $request) {
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
            $this->repository->saveEmployee($request, $user);
            DB::commit();
            return $this->_responseSuccess("Registrasi berhasil", [
                'access_token' => $accessToken,
                'expired' => $expired
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->_responseError($th->getMessage());
        }
        
    }

    public function update(Request $request) {
        try {
            $this->repository->updateEmployee($request);
            return $this->_responseSuccess("Success");
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }

    public function delete(Request $request) {
        try {
            $this->repository->deleteEmployee($request);
            return $this->_responseSuccess("Success");
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }
}
