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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('car_id')
                ->nullable()
                ->constrained('cars')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('bid_id')
                ->nullable()
                ->constrained('bids')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->dateTime('transaction_date');
            $table->enum('payment_method', ['credit_card', 'paypal', 'bank_transfer', 'cash']);
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
