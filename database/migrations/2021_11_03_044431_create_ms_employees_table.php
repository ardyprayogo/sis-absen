<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name')->nullable();
            $table->string('employee_address')->nullable();
            $table->string('employee_phone')->nullable();
            $table->string('employee_email')->nullable();
            $table->integer('level_id')->nullable()->comment('Jabatan');
            $table->integer('division_id')->nullable()->comment('Divisi');
            $table->string('status', 2)->default('00');
            $table->string('created_user', 50)->nullable();
            $table->string('updated_user', 50)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->index(['level_id', 'division_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_employees');
    }
}
