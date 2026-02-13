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
        Schema::create('affiliate_audits', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('affiliate_uin');
            $table->foreign('affiliate_uin')->references('cab_aff_uin')->on('cab_aff')->cascadeOnDelete();
            $table->foreignId('admin_user_id')->nullable()->constrained('users');
            $table->string('action');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_audits');
    }
};
