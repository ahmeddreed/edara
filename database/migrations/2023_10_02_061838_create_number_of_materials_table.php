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
        Schema::create('number_of_materials', function (Blueprint $table) {
            $table->id();
            $table->integer("number")->default(0);
            $table->foreignId("material_id")->references('id')->on('materials');
            $table->string("note",500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('number_of_materials');
    }
};
