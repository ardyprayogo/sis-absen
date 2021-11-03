<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_attendance', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->dateTime('check_in')->comment('Absen masuk');
            $table->dateTime('check_out')->comment('Absen keluar');
            $table->string('status', 2)->default('00');
            $table->string('created_user', 50)->nullable();
            $table->string('updated_user', 50)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            
            $table->index(['date', 'check_in', 'check_out']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_attendance');
    }
}
