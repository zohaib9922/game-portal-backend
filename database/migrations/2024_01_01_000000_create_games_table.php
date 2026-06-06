<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->string('launch_type')->default('embed'); // 'embed' or 'emulator'
            $table->string('emulator_core')->nullable(); // e.g. 'arcade', 'nes', 'snes'
            $table->string('rom_url')->nullable(); // for emulator games
            $table->string('external_url')->nullable(); // for non-embed games
            $table->string('embed_url')->nullable(); // for embed games
            $table->string('thumbnail')->nullable();
            $table->unsignedBigInteger('plays')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->json('tags')->nullable();
            $table->timestamps();

            $table->index('category');
            $table->index('is_featured');
            $table->index('plays');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
