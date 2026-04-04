<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', callback: static function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('slug');
            $table->json('description')->nullable();
            $table->foreignId('category_id')->constrained('product_categories');
            $table->unsignedBigInteger('item_id');
            $table->integer('item_qty')->default(1);
            $table->integer('sales_count')->default(0);
            $table->unsignedInteger('toll');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
