<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('raw_data_models', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->text('url')->nullable();
            $table->text('image_url')->nullable();
            $table->timestamp('publishedAt')->nullable();
            $table->boolean('require_crawler')->default(true);
            $table->json('data_response')->nullable();
            $table->boolean('processed')->default(false);
            $table->string('provider')->nullable();
            $table->timestamps();
            $table->index(['title','publishedAt']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_data_models');
    }
};
