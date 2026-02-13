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
        Schema::create('cab_pymt', function (Blueprint $table) {
            $table->string('cab_pymt_uin')->primary();
            $table->string('invc_uin');
            $table->foreign('invc_uin')->references('cab_invc_uin')->on('cab_invc')->cascadeOnDelete();
            $table->string('txn_id');
            $table->decimal('pd_amt', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cab_pymt');
    }
};
