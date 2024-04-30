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
        Schema::create('multi_start_projects', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('startProject_id');
            $table->integer('batch_number');
            $table->decimal('batch_value');
            $table->date('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multi_start_projects');
    }
};
