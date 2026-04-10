<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

#[Signature('articles:publish-scheduled')]
#[Description('Publish scheduled articles to social media via Webhook')]
class PublishScheduledArticles extends Command
{
    protected $signature = 'articles:publish-scheduled';
    protected $description = 'Publish scheduled articles to social media via Webhook';

    public function handle()
    {
        $articles = Article::where('auto_publish', true)
            ->where('social_published', false)
            ->where('published_at', '<=', now())
            ->get();

        foreach ($articles as $article) {
            try {
                $articleUrl = config('app.web_site_url', config('app.url')) . '/articles/' . $article->slug['ar'];

                if (app()->environment('local')) {
                    $imageUrl = 'https://picsum.photos/800/600';
                } else {
                    $imageUrl = $article->image ? asset($article->image) : null;
                }

                $webhookUrl = config('app.webhook_url');

                Http::timeout(5)->post($webhookUrl, [
                    'title' => $article->title['ar'],
                    'content' => strip_tags($article->description['ar']),
                    'url' => $articleUrl,
                    'image_url' => $imageUrl,
                    'platforms' => $article->social_platforms,
                ]);

                $article->update(['social_published' => true]);
                $this->info("Published: {$article->title['ar']}");

            } catch (\Exception $e) {
                Log::error('Scheduled Article Webhook Error: ' . $e->getMessage());
            }
        }
    }
}
