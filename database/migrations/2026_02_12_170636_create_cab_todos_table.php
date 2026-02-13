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
        Schema::create('cab_todos', function (Blueprint $table) {
            $table->string('cab_todo_uin')->primary();
            $table->string('tzk_ttl');
            $table->string('asn_to');
            $table->foreign('asn_to')->references('cab_staff_prfl_uin')->on('cab_staff_prfl')->cascadeOnDelete();
            $table->dateTime('due_dt');
            $table->string('curr_stau')->default('pending'); // check pending, done
            $table->text('tzk_desp')->nullable();
            $table->string('prio')->default('medium'); // check high, medium, low
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cab_todos');
    }
};
