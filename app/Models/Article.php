<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'description' => 'array',
        'article_body' => 'array',
        'central_concepts' => 'array',
        'analytical_mechanism' => 'array',
        'why_it_matters' => 'array',
        'related_materials' => 'array',
        'talat_ai_questions' => 'array',
        'sovereign_summary' => 'array',
        'publishing_data_tags' => 'array',

        'meta_title' => 'array',
        'meta_description' => 'array',
        'slug' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_old' => 'boolean',
        'auto_publish' => 'boolean',
        'social_published' => 'boolean',
        'published_at' => 'datetime',
        'social_platforms' => 'array',

        'sovereign_meta_bar' => 'array',
        'institutional_alignment' => 'array',
        'central_hypothesis' => 'array',
        'actor_deconstruction' => 'array',
        'mechanisms_of_influence' => 'array',
        'structural_context' => 'array',
        'implications_consequences' => 'array',
        'strategic_foresight' => 'array',
        'references_evidence' => 'array',
        'strategic_quotations' => 'array',
    ];

    public function type()
    {
        return $this->belongsTo(ArticleType::class, 'article_type_id');
    }
}
