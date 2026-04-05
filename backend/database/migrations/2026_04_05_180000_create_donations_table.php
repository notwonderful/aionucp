<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', callback: static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('gateway');
            $table->string('status');
            $table->unsignedInteger('amount_toll');
            $table->unsignedInteger('bonus_toll')->default(0);
            $table->unsignedInteger('amount_money');
            $table->string('currency', 3);
            $table->decimal('exchange_rate', 10, 6);
            $table->string('gateway_transaction_id')->nullable();
            $table->string('gateway_event_id')->nullable()->unique();
            $table->json('gateway_data')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('gateway_transaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
