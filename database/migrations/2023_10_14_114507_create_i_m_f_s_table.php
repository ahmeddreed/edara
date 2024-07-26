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
        Schema::create('i_m_f_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId("customer_id")->references('id')->on('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->integer("old_number");
            $table->integer("new_number");
            $table->integer("number");
            $table->string("operation_type",10);
            $table->string("note",500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_m_f_s');
    }
};
