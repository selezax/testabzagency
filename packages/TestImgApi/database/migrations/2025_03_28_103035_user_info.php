<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('tia.tables.users_info'), function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained(config('tia.tables.users'))
                ->onDelete('cascade');

            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('phone')->nullable();

            $table->foreignId('position_id')
                ->nullable()
                ->constrained(config('tia.tables.positions'))
                ->onDelete('set null');

            $table->string('address')->nullable();
            $table->string('photo')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::table(config('tia.tables.users_info'), function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists(config('tia.tables.users_info'));
    }
};
