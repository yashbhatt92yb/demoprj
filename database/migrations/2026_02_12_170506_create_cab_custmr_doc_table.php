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
        Schema::create('cab_custmr_doc', function (Blueprint $table) {
            $table->string('cab_custmr_doc_uin')->primary();
            $table->string('cab_custmr_uin');
            $table->foreign('cab_custmr_uin')->references('cab_custmr_prfl_uin')->on('cab_custmr_prfl')->cascadeOnDelete();
            $table->string('doc_typ_uin');
            $table->foreign('doc_typ_uin')->references('doc_typ_uin')->on('cab_doc_typ')->cascadeOnDelete();
            $table->string('doc_path');
            $table->integer('stau')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cab_custmr_doc');
    }
};
