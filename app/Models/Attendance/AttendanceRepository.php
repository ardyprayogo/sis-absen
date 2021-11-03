<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance\Attendance;
use Auth;
use Carbon\Carbon;

class AttendanceRepository extends Model
{

    private $model;

    public function __construct(Attendance $model) {
        $this->model = $model;
    }

    public function checkIn($request) {
        $user = Auth::user();
        $date = Carbon::now()->format('Y-m-d');

        return $date;
    }
}
