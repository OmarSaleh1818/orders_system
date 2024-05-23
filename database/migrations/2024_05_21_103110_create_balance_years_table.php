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
        Schema::create('balance_years', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('year_name');
            $table->date('date');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total');
            $table->integer('total_cash');
            $table->integer('total_earn');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance_years');
    }
};
