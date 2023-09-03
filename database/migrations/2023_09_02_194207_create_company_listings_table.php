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
        Schema::create('company_listings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->char('financial_status', 1);
            $table->char('market_category', 1);
            $table->integer('round_lot_size');
            $table->string('security_name');
            $table->string('symbol')->unique(); // Assuming Symbol is unique
            $table->char('test_issue', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_listings');
    }
};
