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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->date('date');
            $table->string('project_name');
            $table->decimal('total');
            $table->decimal('remaining_value');
            $table->string('section_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('project_days');
            $table->integer('price_number');
            $table->string('customer_type');
            $table->string('customer_name');
            $table->string('benefit');
            $table->string('project_code');
            $table->integer('status_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
