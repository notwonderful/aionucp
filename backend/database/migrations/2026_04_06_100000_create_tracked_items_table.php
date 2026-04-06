<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracked_items', static function (Blueprint $table) {
            $table->unsignedInteger('item_unique_id')->primary();
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('item_owner');
            $table->unsignedBigInteger('item_count')->default(1);
            $table->unsignedSmallInteger('enchant')->default(0);
            $table->string('item_creator')->nullable();
            $table->string('last_owner_name');
            $table->string('last_owner_account');
            $table->boolean('is_deleted')->default(false);
            $table->timestamp('first_seen_at');
            $table->timestamp('last_changed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracked_items');
    }
};
