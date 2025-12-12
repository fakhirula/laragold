<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('phone_number', 20);
            $table->text('address');
            $table->string('last_education', 100);
            $table->string('occupation', 100);
            $table->string('income_range', 50);
            $table->string('fund_source', 100);
            $table->text('purpose_of_account');
            $table->boolean('is_kyc_verified')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
