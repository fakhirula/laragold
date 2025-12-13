<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('brand_id', unsigned: true);
            $table->string('name');
            $table->decimal('purity_pct', 5, 2)->default(99.99);
            $table->decimal('weight_g', 10, 3)->default(0.000);
            $table->boolean('is_physical')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
