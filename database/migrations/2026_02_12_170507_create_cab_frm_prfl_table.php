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
        Schema::create('cab_frm_prfl', function (Blueprint $table) {
            $table->string('cab_frm_prfl_uin')->primary();
            $table->string('frm_nm')->nullable();
            $table->string('reg_nbr')->nullable();
            $table->string('gst_nbr')->nullable();
            $table->string('bizz_typ')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cab_frm_prfl');
    }
};
