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
        Schema::create('finance_managers', function (Blueprint $table) {
            $table->id();
            $table->integer('applicant_id');
            $table->string('inquiry')->nullable();
            $table->string('reply_inquiry')->nullable();
            $table->string('finance_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_managers');
    }
};
