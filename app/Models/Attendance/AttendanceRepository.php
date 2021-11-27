<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance\Attendance;
use Auth;
use Carbon\Carbon;
use DB;

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
        $count = $this->model
                ->where('date', $date)
                ->where('employee_id', $user->employee_id)
                ->whereNotNull('check_in')
                ->count();

        if ($count > 0) {
            throw new \Exception("Data absen sudah ada");
        } else {
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
        }
        return $retval;
    }

    public function checkOut($request) {
        $user = Auth::user();
        $date = Carbon::now()->format('Y-m-d');
        $dateTime = Carbon::now()->toDateTimeString();
        $count = $this->model
                    ->where('date', $date)
                    ->where('employee_id', $user->employee_id)
                    ->whereNotNull('check_out')
                    ->count();
        
        if ($count > 0) {
            throw new \Exception("Data absen sudah ada");
        } else {
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
        } 
        return $retval;
    }

    public function report($request) {
        $user = Auth::user();
        $dateStart = $request->date_start;
        $dateEnd = $request->date_end;
        $employee_id = isset($request->employee_id) ? $request->employee_id : $user->employee_id;

        $result = $this->model
            ->join('ms_employees', 'ms_employees.id', 'tr_attendance.employee_id')
            ->select(
                'ms_employees.employee_name',
                'date',
                'check_in',
                'check_out',
                DB::raw('TIMEDIFF(check_out, check_in) AS work_hour'),
                DB::raw("TIMEDIFF(check_out, '17:00:00') AS late_check_out"),
                DB::raw("TIMEDIFF(check_in, '08:00:00') AS late_check_in")
            )
            ->where('employee_id', $employee_id)
            ->whereBetween('date', [$dateStart, $dateEnd])
            ->get();
        return $result;
    }

    public function getPercent($request) {
        $user = Auth::user();
        $day = date('Y-m-d');
        $now = date('d');

        $workDay = 0;
        for($i=1; $i<$now; $i++)
        {
            $repeat = strtotime("-1 day", strtotime($day));
            $day = date('l', $repeat);
            if ($day == 'Sunday' || $day == 'Saturday') continue;
            $workDay += 1;
        }
        $attend = $this->model
            ->select(
                'date'
            )
            ->where('employee_id', $user->employee_id)
            ->whereMonth('date', date('m'))
            ->count();
        
        $percent = $attend/$workDay * 100;

        return [
            'attendance' => $attend,
            'work' => $workDay,
            'percentation' => number_format((float)$percent, 2, '.', '')
        ];
    }

    public function getLongLat($request) {
        return DB::table('sys_config')
                ->first();
    }
}
