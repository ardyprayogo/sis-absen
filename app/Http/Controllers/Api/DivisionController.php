<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use App\Models\Division\Division;

class DivisionController extends BaseApiController
{
    //
    private $model;
    public function __construct(Division $division) {
        $this->model = $division;
    }

    public function get(Request $request) {
        try {
            $name = isset($request->name) ? $request->name : null;
            $divisions = $this->model
                ->where('status', '00');
            if ($name != null) {
                $divisions = $divisions->where('division_name', 'like', '%'.$name.'%');
            }
            $divisions = $divisions->get();
            return $this->_responseSuccess("Success", $divisions);
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }
    
    public function create(Request $request) {
        try {
            $division = $this->model;
            $division->division_name = $request->division_name;
            $division->save();
            return $this->_responseSuccess("Success", $division);
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }

    public function update(Request $request) {
        try {
            $division = $this->model->find($request->id);
            $division->division_name = $request->division_name;
            $division->save();
            return $this->_responseSuccess("Success", $division);
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }

    public function delete(Request $request) {
        try {
            $division = $this->model->find($request->id);
            $division->status = '01';
            $division->save();
            return $this->_responseSuccess("Success", $division);
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }
}
