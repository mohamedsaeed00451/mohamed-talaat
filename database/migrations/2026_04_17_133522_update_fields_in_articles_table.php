<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Drop old files
            $table->dropColumn([
                'policy_paper_file',
                'strategic_fact_sheets_file',
                'strategic_brief_file',
                'analytical_infographic_file',
                'analytical_article_file'
            ]);

            // Add new files
            $table->string('infographic_design_file')->nullable();
            $table->string('interactive_infographic_file')->nullable();

            // Add new text/json fields
            $table->json('subtitle')->nullable()->after('title');
            $table->json('article_body')->nullable()->after('description');
            $table->json('central_concepts')->nullable()->after('article_body');
            $table->json('analytical_mechanism')->nullable()->after('central_concepts');
            $table->json('why_it_matters')->nullable()->after('analytical_mechanism');
            $table->json('related_materials')->nullable()->after('why_it_matters');
            $table->json('talat_ai_questions')->nullable()->after('related_materials');
            $table->json('sovereign_summary')->nullable()->after('talat_ai_questions');
            $table->json('publishing_data_tags')->nullable()->after('sovereign_summary');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('policy_paper_file')->nullable();
            $table->string('strategic_fact_sheets_file')->nullable();
            $table->string('strategic_brief_file')->nullable();
            $table->string('analytical_infographic_file')->nullable();
            $table->string('analytical_article_file')->nullable();

            $table->dropColumn([
                'infographic_design_file',
                'interactive_infographic_file',
                'subtitle',
                'article_body',
                'central_concepts',
                'analytical_mechanism',
                'why_it_matters',
                'related_materials',
                'talat_ai_questions',
                'sovereign_summary',
                'publishing_data_tags'
            ]);
        });
    }
};
