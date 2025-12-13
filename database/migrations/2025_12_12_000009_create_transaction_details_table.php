<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('weight_g', 18, 6);
            $table->decimal('price_per_gram_at_time', 18, 6);
            $table->decimal('subtotal_rp', 18, 2);
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('transactions')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
