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
            $table->enum('price_type', ['buy', 'sell']);
            $table->decimal('price_per_gram', 18, 6);
            $table->dateTime('recorded_at');
            $table->index(['product_id', 'recorded_at'], 'idx_product_time');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
