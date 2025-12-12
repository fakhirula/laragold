<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('buy_price_per_gram', 18, 6)->comment('Harga beli per 1 gram (API)');
            $table->decimal('sell_price_per_gram', 18, 6)->comment('Harga jual per 1 gram (API)');
            $table->dateTime('recorded_at')->comment('Waktu data ditarik dari API');
            $table->index(['product_id', 'recorded_at'], 'idx_product_time');

            $table->foreign('product_id')->references('id')->on('products')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
