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
        Schema::create('multi_projects', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('step_id');
            $table->string('item_name');
            $table->decimal('item_value');
            $table->decimal('remaining_value')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multi_projects');
    }
};
