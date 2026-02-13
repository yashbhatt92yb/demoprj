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
        Schema::create('cab_invc', function (Blueprint $table) {
            $table->string('cab_invc_uin')->primary();
            $table->string('invc_num');
            $table->string('cust_uin');
            $table->foreign('cust_uin')->references('cab_custmr_prfl_uin')->on('cab_custmr_prfl')->cascadeOnDelete();
            $table->decimal('tot_amt', 15, 2);
            $table->string('pay_stau')->default('unpaid'); // unpaid, paid
            $table->foreignId('req_id')->nullable()->constrained('service_requests', 'request_id')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cab_invc');
    }
};
