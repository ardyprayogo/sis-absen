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
        $dateTime = Carbon::now()->toDateTimeString();
        $retval = $this->model->updateOrCreate([
                'date' => $date,
                'employee_id' => $user->employee_id
            ],[
                'date' => $date,
                'check_in' => $dateTime,
                'employee_id' => $user->employee_id,
                'created_user' => $user->employee->employee_name,
                'updated_user' => $user->employee->employee_name
            ]);
        return $retval;
    }

    public function checkOut($request) {
        $user = Auth::user();
        $date = Carbon::now()->format('Y-m-d');
        $dateTime = Carbon::now()->toDateTimeString();
        $retval = $this->model->updateOrCreate([
                'date' => $date,
                'employee_id' => $user->employee_id
            ],[
                'date' => $date,
                'check_out' => $dateTime,
                'employee_id' => $user->employee_id,
                'created_user' => $user->employee->employee_name,
                'updated_user' => $user->employee->employee_name
            ]);
        return $retval;
    }
}
