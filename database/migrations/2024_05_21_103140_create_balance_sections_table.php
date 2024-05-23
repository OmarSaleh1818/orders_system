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
        Schema::create('balance_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('balance_id');
            $table->string('section_name');
            $table->integer('section_price');
            $table->integer('section_cash');
            $table->integer('section_earn');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance_sections');
    }
};
