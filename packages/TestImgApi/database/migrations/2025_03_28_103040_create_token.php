<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('tia.tables.tokens'), function (Blueprint $table) {
            $table->id();
            $table->string('token', 200)->unique();
            $table->timestamp('expires_at');
            $table->boolean('used')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('tia.tables.tokens'));
    }
};
