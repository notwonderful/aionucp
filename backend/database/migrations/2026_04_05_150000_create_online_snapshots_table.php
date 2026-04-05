<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_snapshots', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('online_count');
            $table->timestamp('recorded_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_snapshots');
    }
};
