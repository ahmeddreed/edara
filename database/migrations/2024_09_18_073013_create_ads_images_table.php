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
        Schema::create('ads_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId("settings_id")->references('id')->on('settings')->onUpdate('cascade')->onDelete('cascade');
            $table->string("title");
            $table->string("image");
            $table->string("description");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads_images');
    }
};
