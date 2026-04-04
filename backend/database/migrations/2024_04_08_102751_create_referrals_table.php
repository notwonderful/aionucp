<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referrals', callback: static function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('earned')->default(0);
            $table->timestamps();
        });

        Schema::create('referral_actions', callback: static function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedInteger('aion_acc_id');
            $table->string('action'); // register, purchase, etc.
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_actions');
        Schema::dropIfExists('referrals');
    }
};
