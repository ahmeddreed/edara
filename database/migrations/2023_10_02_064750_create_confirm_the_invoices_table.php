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
        Schema::create('confirm_the_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId("invoice_id")->references('id')->on('invoices')->onUpdate('cascade')->onDelete('cascade')->unique();
            $table->boolean("invoice_verify")->default(0);
            $table->boolean("equip")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confirm_the_invoices');
    }
};
