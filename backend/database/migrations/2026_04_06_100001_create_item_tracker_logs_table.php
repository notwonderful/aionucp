<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_tracker_logs', static function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('item_unique_id')->index();
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('old_owner_id')->nullable();
            $table->string('old_owner_name')->nullable();
            $table->string('old_owner_account')->nullable();
            $table->unsignedInteger('new_owner_id')->nullable();
            $table->string('new_owner_name')->nullable();
            $table->string('new_owner_account')->nullable();
            $table->string('event_type')->default('transfer');
            $table->timestamp('logged_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_tracker_logs');
    }
};
