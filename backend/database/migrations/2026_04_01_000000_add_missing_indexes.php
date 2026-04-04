<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index('category_id');
        });

        Schema::table('recharges', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('player_id');
            $table->index('type');
        });

        Schema::table('promo_codes', function (Blueprint $table) {
            $table->unique('code');
        });

        Schema::table('referral_actions', function (Blueprint $table) {
            $table->index('aion_acc_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
        });

        Schema::table('recharges', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['player_id']);
            $table->dropIndex(['type']);
        });

        Schema::table('promo_codes', function (Blueprint $table) {
            $table->dropUnique(['code']);
        });

        Schema::table('referral_actions', function (Blueprint $table) {
            $table->dropIndex(['aion_acc_id']);
        });
    }
};
