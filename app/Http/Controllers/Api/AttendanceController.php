<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use App\Models\Attendance\AttendanceRepository;

class AttendanceController extends BaseApiController
{
    //
    private $repository;

    public function __construct(AttendanceRepository $repo) {
        $this->repository = $repo;
    }

    public function checkIn(Request $request) {
        try {
            $attendance = $this->repository->checkIn($request);
            return $this->_responseSuccess('Check In berhasil', $attendance);
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }

    public function checkOut(Request $request) {
        try {
            $attendance = $this->repository->checkOut($request);
            return $this->_responseSuccess('Check Out berhasil', $attendance);
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }

    public function report(Request $request) {
        try {
            $report = $this->repository->report($request);
            return $this->_responseSuccess('Success', $report);
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }
}
