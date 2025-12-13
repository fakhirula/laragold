<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_portfolio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('balance_weight_g', 18, 6)->default(0.000000);
            $table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['user_id', 'product_id'], 'uk_user_product');

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_portfolio');
    }
};
