<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', callback: static function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('slug');
            $table->string('tag', 50);
            $table->json('excerpt');
            $table->json('body');
            $table->string('image')->nullable();
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('published');
            $table->index('published_at');
            $table->index('tag');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
