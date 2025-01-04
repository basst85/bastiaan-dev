<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Enums\BlogReactionType;
use App\Models\BlogReaction;

class AddReactionToBlogpost implements ShouldQueue
{
    use Queueable;

    public $slug;
    public $reaction;

    /**
     * Create a new job instance.
     */
    public function __construct($slug, $reaction)
    {
        $this->slug = $slug;
        $this->reaction = $reaction;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        BlogReaction::create([
            'blog_post_slug' => $this->slug,
            'reaction' => BlogReactionType::from($this->reaction)->value,
        ]);
    }
}
