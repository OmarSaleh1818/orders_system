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
        Schema::create('open_projects', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('project_id');
            $table->date('date');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('project_days');
            $table->string('customer_type');
            $table->string('customer_name');
            $table->string('benefit');
            $table->string('project_code');
            $table->string('art_show');
            $table->string('finance_show');
            $table->string('draft_show');
            $table->text('description');
            $table->integer('status_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('open_projects');
    }
};
