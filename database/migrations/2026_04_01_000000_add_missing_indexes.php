<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donates', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('category_id');
        });

        Schema::table('recharges', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('player_id');
            $table->index('type');
        });

        Schema::table('referrals', function (Blueprint $table) {
            $table->index('user_id');
            $table->unique('code');
        });

        Schema::table('promo_codes', function (Blueprint $table) {
            $table->unique('code');
        });
    }

    public function down(): void
    {
        Schema::table('donates', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
        });

        Schema::table('recharges', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['player_id']);
            $table->dropIndex(['type']);
        });

        Schema::table('referrals', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropUnique(['code']);
        });

        Schema::table('promo_codes', function (Blueprint $table) {
            $table->dropUnique(['code']);
        });
    }
};
