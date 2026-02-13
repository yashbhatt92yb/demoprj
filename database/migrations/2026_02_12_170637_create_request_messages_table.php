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
        Schema::create('request_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('req_id')->constrained('service_requests', 'request_id')->cascadeOnDelete();
            $table->foreignId('sender_id')->nullable()->constrained('users');
            $table->string('sender_role')->nullable();
            $table->text('body')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->dateTime('seen_by_staff_at')->nullable();
            $table->dateTime('seen_by_customer_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_messages');
    }
};
