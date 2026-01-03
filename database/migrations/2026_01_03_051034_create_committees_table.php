<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('committees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('committee_number')->unique();
            $table->text('description')->nullable();
            $table->decimal('total_amount', 12, 2); // Total committee amount
            $table->integer('number_of_members');
            $table->integer('duration_months');
            $table->decimal('installment_amount', 10, 2); // Har installment ki amount
            $table->enum('frequency', ['daily', 'weekly', 'monthly', '10_days']);
            $table->date('start_date');
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->enum('rotation_method', ['auction', 'lottery', 'fixed_order', 'bidding'])->default('lottery');
            $table->decimal('admin_commission', 5, 2)->default(0); // Percentage
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('committees');
    }
};