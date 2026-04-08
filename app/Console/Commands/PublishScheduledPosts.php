<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

#[Signature('posts:publish-scheduled')]
#[Description('Publish scheduled posts to social media via Webhook')]

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish-scheduled';
    protected $description = 'Publish scheduled posts to social media via Webhook';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = Post::where('auto_publish', true)
            ->where('social_published', false)
            ->where('published_at', '<=', now())
            ->get();

        foreach ($posts as $post) {
            try {
                $postUrl = config('app.url') . '/' . $post->slug['ar'];
                $imageUrl = $post->image ? asset($post->image) : null;
                $webhookUrl = config('app.webhook_url');

                Http::timeout(5)->post($webhookUrl, [
                    'title' => $post->title['ar'],
                    'content' => strip_tags($post->description['ar']),
                    'url' => $postUrl,
                    'image_url' => $imageUrl,
                ]);

                $post->update(['social_published' => true]);
                $this->info("Published: {$post->title['ar']}");

            } catch (\Exception $e) {
                Log::error('Scheduled Webhook Error: ' . $e->getMessage());
            }
        }
    }
}
