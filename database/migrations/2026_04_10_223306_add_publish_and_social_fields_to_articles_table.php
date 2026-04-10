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
        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('description');
            $table->boolean('is_featured')->default(false)->after('is_active');
            $table->boolean('is_old')->default(false)->after('is_featured');
            $table->boolean('auto_publish')->default(false)->after('is_old');
            $table->json('social_platforms')->nullable()->after('auto_publish');
            $table->boolean('social_published')->default(false)->after('social_platforms');
            $table->timestamp('published_at')->nullable()->after('social_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'is_featured',
                'is_old',
                'auto_publish',
                'social_platforms',
                'social_published',
                'published_at'
            ]);
        });
    }
};
