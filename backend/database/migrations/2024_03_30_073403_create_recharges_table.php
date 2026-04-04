<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recharges', callback: static function (Blueprint $table) {
            $table->id();
            $table->bigInteger('player_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->cascadeOnDelete()
                ->on('users');
            $table->string('type')->nullable();
            $table->dateTime('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recharges');
    }
};
