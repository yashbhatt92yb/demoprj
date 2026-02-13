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
        Schema::create('cab_cust_fin_info', function (Blueprint $table) {
            $table->string('cab_cust_fin_info_uin')->primary();
            $table->string('cab_cust_uin');
            $table->foreign('cab_cust_uin')->references('cab_custmr_prfl_uin')->on('cab_custmr_prfl')->cascadeOnDelete();
            $table->decimal('mnthly_incm', 15, 2)->nullable();
            $table->decimal('anual_incm', 15, 2)->nullable();
            $table->decimal('total_asset', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cab_cust_fin_info');
    }
};
