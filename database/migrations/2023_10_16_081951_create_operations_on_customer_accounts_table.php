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
        Schema::create('operations_on_customer_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("customer_accounts_id")->references('id')->on('customers');
            $table->integer("pay");
            $table->integer("old_number");
            $table->integer("new_number");
            $table->foreignId("user_id")->references('id')->on('users')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operations_on_customer_accounts');
    }
};
