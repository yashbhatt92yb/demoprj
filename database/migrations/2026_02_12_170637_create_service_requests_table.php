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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->string('customer_id');
            $table->foreign('customer_id')->references('cab_custmr_prfl_uin')->on('cab_custmr_prfl')->cascadeOnDelete();
            $table->string('service_id');
            $table->foreign('service_id')->references('service_id')->on('services')->cascadeOnDelete();
            $table->string('affiliate_id')->nullable();
            $table->foreign('affiliate_id')->references('cab_aff_uin')->on('cab_aff')->nullOnDelete();
            $table->string('assigned_to')->nullable();
            $table->foreign('assigned_to')->references('cab_staff_prfl_uin')->on('cab_staff_prfl')->nullOnDelete();
            $table->string('current_status')->default('pending'); // pending, assigned, in_progress, needs_info, reviewing, completed, flagged_revoke
            $table->dateTime('assignment_seen_by_staff_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
