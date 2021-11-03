<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;

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
}
