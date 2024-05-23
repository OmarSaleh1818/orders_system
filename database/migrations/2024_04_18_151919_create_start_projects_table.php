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
        Schema::create('start_projects', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('openProject_id');
            $table->date('date');
            $table->string('art_show');
            $table->string('finance_show');
            $table->string('draft_show');
            $table->integer('total');
            $table->integer('status_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('start_projects');
    }
};
