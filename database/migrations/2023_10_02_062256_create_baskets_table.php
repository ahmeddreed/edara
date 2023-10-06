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
        Schema::create('baskets', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->references('id')->on('users');
            $table->foreignId("customer_id")->references('id')->on('customers');
            $table->integer("t-price")->default(0);
            $table->string("note",500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baskets');
    }
};
