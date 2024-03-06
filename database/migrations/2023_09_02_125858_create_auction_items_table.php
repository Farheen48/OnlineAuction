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
        Schema::create('auction_items', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->nullable();
            $table->string('category')->nullable();
            $table->string('time_limit')->nullable();
            $table->string('bidding_staus')->default('not-approved');
            $table->string('status')->nullable();
            $table->double('price_collected')->default(0);
            $table->longText('bidder')->nullable();
            $table->double('total_bid')->nullable();
            $table->string('current_price')->default(0);
            $table->longText('token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auction_items');
    }
};
