<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;
use Auth;

class EmployeeRepository extends Model
{

    private $model;

    public function __construct(Employee $model) {
        $this->model = $model;

    }

    public function saveEmployee($request, $user) {
        $employee = $this->model;
        $employee->employee_name = $request->name;
        $employee->employee_address = $request->address;
        $employee->employee_phone = $request->phone;
        $employee->employee_email = $request->email;
        $employee->level_id = $request->level_id;
        $employee->division_id = $request->division_id;
        $employee->save();

        $user->employee_id = $employee->id;
        $user->save();
    }

    public function getEmployee() {
        $user = Auth::user();
        $employeeId = $user->employee->id;

        $employee = $this->model
            ->select(
                'ms_employees.*',
                'ms_levels.level_name',
                'ms_divisions.division_name'
                )
            ->join('ms_levels', 'ms_levels.id', 'ms_employees.level_id')
            ->join('ms_divisions', 'ms_divisions.id', 'ms_employees.division_id')
            ->where('ms_employees.id', $employeeId)
            ->first();

        return $employee;
    }

    public function listEmployee($request) {

        $employeeName = isset($request->name) ? $request->name : null;

        $employee = $this->model
            ->select(
                'ms_employees.*',
                'ms_levels.level_name',
                'ms_divisions.division_name'
                )
            ->join('ms_levels', 'ms_levels.id', 'ms_employees.level_id')
            ->join('ms_divisions', 'ms_divisions.id', 'ms_employees.division_id')
            ->where('ms_employees.status', '00');

        if ($employeeName != null) {
            $employee = $employee->where('ms_employees.employee_name', 'like', '%'.$employeeName.'%');
        }

        return $employee->get();
    }

    public function updateEmployee($request) {
        $employee = $this->model->find($request->id);
        $employee->employee_name = $request->name;
        $employee->employee_address = $request->address;
        $employee->employee_phone = $request->phone;
        $employee->level_id = $request->level_id;
        $employee->division_id = $request->division_id;
        $employee->save();
    }

    public function deleteEmployee($request) {
        $employee = $this->model->find($request->id);
        $employee->status = '01';
        $employee->save();
    }
}
