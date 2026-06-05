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
            $table->string('embed_url');
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
