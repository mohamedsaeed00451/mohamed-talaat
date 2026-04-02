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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_type_id')->constrained('article_types')->cascadeOnDelete();
            $table->json('title');
            $table->json('description');
            $table->string('image')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->string('white_papers_file')->nullable();
            $table->string('published_researches_file')->nullable();
            $table->string('executive_briefs_file')->nullable();
            $table->string('chronological_archive_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
