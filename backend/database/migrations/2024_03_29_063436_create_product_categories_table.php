<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_categories', callback: static function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('slug');
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('product_categories')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
