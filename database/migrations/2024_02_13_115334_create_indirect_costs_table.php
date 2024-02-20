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
        Schema::create('indirect_costs', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->string('management', 50);
            $table->decimal('indirect_costs');
            $table->decimal('total_costs');
            $table->string('cost_finance', 50);
            $table->string('monthly_benefit', 50);
            $table->string('per_month', 50);
            $table->decimal('percentage_total');
            $table->decimal('benefit_value');
            $table->decimal('total_project_costs');
            $table->string('target_profit_percentage', 50);
            $table->string('target_profit_value', 50);
            $table->string('actual_profit_percentage', 50);
            $table->string('actual_profit_value', 50);
            $table->decimal('total_project_value');
            $table->string('private_discount', 50);
            $table->decimal('before_tax');
            $table->decimal('value_tax');
            $table->decimal('after_tax');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indirect_costs');
    }
};
