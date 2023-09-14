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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->date('date');
            $table->string('project_name');
            $table->string('section_name');
            $table->string('item_name');
            $table->string('item_value');
            $table->decimal('remaining_value');
            $table->decimal('price');
            $table->string('price_name');
            $table->string('order_name');
            $table->string('account_number');
            $table->string('bank_name');
            $table->string('bank_name_account');
            $table->string('contract_number')->nullable();
            $table->date('payment_date');
            $table->string('priority_level');
            $table->string('step_name');
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
        Schema::dropIfExists('applicants');
    }
};
