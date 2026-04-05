<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wiki_categories', callback: static function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 50)->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();

            $table->index(['published', 'sort_order']);
        });

        Schema::create('wiki_entries', callback: static function (Blueprint $table) {
            $table->id();
            $table->foreignId('wiki_category_id')->constrained()->cascadeOnDelete();
            $table->string('type', 20);
            $table->json('content');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();

            $table->index(['wiki_category_id', 'published', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wiki_entries');
        Schema::dropIfExists('wiki_categories');
    }
};
