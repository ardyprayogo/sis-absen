<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'tr_attendance';

    protected $fillable = [
        'date',
        'employee_id',
        'check_in',
        'check_out',
        'created_user',
        'updated_user'
    ];
}
