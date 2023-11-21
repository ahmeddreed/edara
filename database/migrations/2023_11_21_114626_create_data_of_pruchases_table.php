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
        Schema::create('data_of_pruchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->references('id')->on('users')->nullable();
            $table->foreignId("pruchase_id")->references('id')->on('pruchases')->nullable();
            $table->foreignId("material_id")->references('id')->on('materials');
            $table->string("note",1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_of_pruchases');
    }
};