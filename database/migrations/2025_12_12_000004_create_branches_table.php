<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->unsignedBigInteger('head_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Foreign key untuk kepala cabang
            $table->foreign('head_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
