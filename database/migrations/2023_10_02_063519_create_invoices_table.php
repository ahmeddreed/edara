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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId("equipper")->nullable()->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId("customer_id")->nullable()->references('id')->on('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->integer("t_price")->default(0);
            $table->integer("discount")->default(0);
            $table->integer("t_price_after_discount")->default(0);
            $table->string("invoice_type")->nullable();
            $table->string("operation_type")->nullable();
            $table->integer("material_count")->default(0);
            $table->string("note",500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
