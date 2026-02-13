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
        Schema::create('cab_aff', function (Blueprint $table) {
            $table->string('cab_aff_uin')->primary();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('fa_nm');
            $table->string('la_nm');
            $table->string('adhr_num')->nullable(); // nullable as per sample, though schema says not null but data sample has values
            $table->string('pn_num')->nullable();
            $table->string('mob');
            $table->string('eml');
            $table->text('deactivation_reason')->nullable();
            $table->dateTime('deactivated_at')->nullable();
            $table->dateTime('removed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cab_aff');
    }
};
