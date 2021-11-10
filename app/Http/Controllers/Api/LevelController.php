<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use App\Models\Level\Level;

class LevelController extends BaseApiController
{
    //
    private $model;

    public function __construct(Level $level) {
        $this->model = $level;
    }

    public function get(Request $request) {
        try {
            $levels = $this->model->where('status', '00')->get();
            return $this->_responseSuccess("Success", $levels);
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }
    
    public function create(Request $request) {
        try {
            $level = $this->model;
            $level->level_name = $request->level_name;
            $level->save();
            return $this->_responseSuccess("Success", $level);
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }

    public function update(Request $request) {
        try {
            $level = $this->model->find($request->id);
            $level->level_name = $request->level_name;
            $level->save();
            return $this->_responseSuccess("Success", $level);
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }

    public function delete(Request $request) {
        try {
            $level = $this->model->find($request->id);
            $level->status = '01';
            $level->save();
            return $this->_responseSuccess("Success", $level);
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }
}
