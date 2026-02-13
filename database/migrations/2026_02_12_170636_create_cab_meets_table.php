<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cab_meets', function (Blueprint $table) {
            $table->string('cab_meet_uin')->primary();
            $table->string('meet_nm');
            $table->string('host_id');
            $table->foreign('host_id')->references('cab_staff_prfl_uin')->on('cab_staff_prfl')->cascadeOnDelete();
            $table->dateTime('sch_dt');
            $table->string('meet_link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cab_meets');
    }
};
