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
        Schema::create('cab_staff_prfl', function (Blueprint $table) {
            $table->string('cab_staff_prfl_uin')->primary();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('frst_nm');
            $table->string('lst_nm');
            $table->string('corp_eml');
            $table->string('mob');
            $table->string('desig');
            $table->string('dept');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cab_staff_prfl');
    }
};
