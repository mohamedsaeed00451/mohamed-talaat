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
            $table->json('sovereign_meta_bar')->nullable();
            $table->json('institutional_alignment')->nullable();
            $table->json('central_hypothesis')->nullable();
            $table->json('actor_deconstruction')->nullable();
            $table->json('mechanisms_of_influence')->nullable();
            $table->json('structural_context')->nullable();
            $table->json('implications_consequences')->nullable();
            $table->json('strategic_foresight')->nullable();
            $table->json('references_evidence')->nullable();
            $table->string('risk_index_color', 20)->nullable();
            $table->string('analytical_positioning')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'sovereign_meta_bar', 'institutional_alignment', 'central_hypothesis',
                'actor_deconstruction', 'mechanisms_of_influence', 'structural_context',
                'implications_consequences', 'strategic_foresight', 'references_evidence',
                'risk_index_color', 'analytical_positioning'
            ]);
        });
    }
};
