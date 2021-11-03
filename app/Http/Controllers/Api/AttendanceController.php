<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance\AttendanceRepository;

class AttendanceController extends Controller
{
    //
    private $repository;

    public function __construct(AttendanceRepository $repo) {
        $this->repository = $repo;
    }

    public function checkIn(Request $request) {
        try {
            //code...
            return $this->repository->checkIn($request);
        } catch (\Throwable $th) {
            return $this->_responseError($th->getMessage());
        }
    }
}
