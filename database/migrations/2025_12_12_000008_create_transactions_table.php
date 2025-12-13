<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['buy', 'sell']);
            $table->enum('status', ['pending', 'completed', 'cancelled', 'failed']);
            $table->decimal('total_amount_rp', 18, 2);
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->timestamp('transaction_date')->useCurrent();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('branch_id')->references('id')->on('branches')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
