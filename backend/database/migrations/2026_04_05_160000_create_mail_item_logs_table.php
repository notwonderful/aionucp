<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mail_item_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users');
            $table->string('player_name');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('item_qty');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mail_item_logs');
    }
};
