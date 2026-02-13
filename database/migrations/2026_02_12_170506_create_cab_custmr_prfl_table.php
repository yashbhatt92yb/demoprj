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
        Schema::create('cab_custmr_prfl', function (Blueprint $table) {
            $table->string('cab_custmr_prfl_uin')->primary();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('cab_aff_uin')->nullable();
            $table->foreign('cab_aff_uin')->references('cab_aff_uin')->on('cab_aff')->nullOnDelete();
            $table->string('adhr_num')->nullable();
            $table->string('pn_num')->nullable();
            $table->string('mob');
            $table->string('eml');
            $table->boolean('by_aff')->default(false);
            $table->integer('stau')->default(1);
            $table->integer('is_vf')->default(1);
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('addr_line1')->nullable();
            $table->string('addr_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->text('deactivation_reason')->nullable();
            $table->dateTime('deactivated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cab_custmr_prfl');
    }
};
