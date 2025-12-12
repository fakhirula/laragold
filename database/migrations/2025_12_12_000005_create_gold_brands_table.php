<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gold_brands', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 100)->unique()->comment('Antam, UBS, Pegadaian');
            $table->enum('metal_type', ['Gold', 'Silver', 'Platinum'])->default('Gold');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gold_brands');
    }
};
