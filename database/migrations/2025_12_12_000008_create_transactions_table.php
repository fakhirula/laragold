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
            $table->enum('type', ['buy', 'sell'])->comment('User membeli atau User menjual');
            $table->enum('status', ['pending', 'completed', 'cancelled', 'failed']);
            $table->decimal('total_amount_rp', 18, 2)->comment('Total Rupiah yang terlibat (Min. 10000)');
            $table->unsignedBigInteger('partner_id')->nullable()->comment('Mitra yang melayani pencairan (NULL jika hanya transaksi digital)');
            $table->timestamp('transaction_date')->useCurrent();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('partner_id')->references('id')->on('service_partners')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
