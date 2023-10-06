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
        Schema::create('data_of_baskets', function (Blueprint $table) {
            $table->id();
            $table->foreignId("basket_id")->references('id')->on('baskets');
            $table->foreignId("material_id")->references('id')->on('materials');
            $table->integer("count")->default(0);
            $table->string("note",500)->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_of_baskets');
    }
};
