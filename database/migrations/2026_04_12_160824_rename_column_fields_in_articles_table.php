<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('ALTER TABLE articles CHANGE COLUMN white_papers_file policy_paper_file VARCHAR(255) NULL');
        DB::statement('ALTER TABLE articles CHANGE COLUMN published_researches_file strategic_fact_sheets_file VARCHAR(255) NULL');
        DB::statement('ALTER TABLE articles CHANGE COLUMN executive_briefs_file strategic_brief_file VARCHAR(255) NULL');
        DB::statement('ALTER TABLE articles CHANGE COLUMN chronological_archive_file analytical_infographic_file VARCHAR(255) NULL');
        Schema::table('articles', function (Blueprint $table) {
            $table->string('analytical_article_file')->nullable();
        });
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE articles CHANGE COLUMN policy_paper_file white_papers_file VARCHAR(255) NULL');
        DB::statement('ALTER TABLE articles CHANGE COLUMN strategic_fact_sheets_file published_researches_file VARCHAR(255) NULL');
        DB::statement('ALTER TABLE articles CHANGE COLUMN strategic_brief_file executive_briefs_file VARCHAR(255) NULL');
        DB::statement('ALTER TABLE articles CHANGE COLUMN analytical_infographic_file chronological_archive_file VARCHAR(255) NULL');
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('analytical_article_file');
        });
    }
};
