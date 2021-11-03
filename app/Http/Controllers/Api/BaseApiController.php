<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseApiController extends Controller
{

    public function _validators(Request $request, $rules) {
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            throw new \Exception(implode(', ', $errors));
        }
    }

    public function _responseSuccess($successMessage, $data = null) {
        $response = [
            "success" => true,
            "message" => $successMessage,
            "data" => $data
        ];
        return response($response, 200);
    }

    public function _responseError($errorMessage, $errorCode = 422) {
        $response = [
            "success" => false,
            "message" => $errorMessage
        ];

        return response($response, $errorCode);
    }
}
