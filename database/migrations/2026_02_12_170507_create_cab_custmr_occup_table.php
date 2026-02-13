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
        Schema::create('cab_custmr_occup', function (Blueprint $table) {
            $table->string('cab_custmr_occup_uin')->primary();
            $table->string('cab_custmr_uin');
            $table->foreign('cab_custmr_uin')->references('cab_custmr_prfl_uin')->on('cab_custmr_prfl')->cascadeOnDelete();
            $table->string('empl_typ'); // check 'Govt', 'Private'
            $table->string('desig')->nullable();
            $table->string('empl_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cab_custmr_occup');
    }
};
