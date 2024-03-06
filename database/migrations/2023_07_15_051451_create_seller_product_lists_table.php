<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seller_product_lists', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->nullable();
            $table->string('seller_serial')->nullable();
            $table->string('image')->nullable();
            $table->string('name')->nullable();
            $table->string('short_des')->nullable();
            $table->string('starting_price')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_product_lists');
    }
};
