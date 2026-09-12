<?php

declare(strict_types=1);

use App\Jobs\AddReactionToBlogpost;
use App\Livewire\BlogpostReact;
use App\Models\BlogReaction;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;

it('starts every reaction count at zero for a post with no reactions', function () {
    Livewire::test(BlogpostReact::class, ['slug' => 'test-blog-post'])
        ->assertSet('reactionCounts', [
            'like' => 0,
            'love' => 0,
            'wow' => 0,
            'haha' => 0,
        ]);
});

it('loads existing reaction counts for the given slug only', function () {
    BlogReaction::create(['blog_post_slug' => 'test-blog-post', 'reaction' => 'like']);
    BlogReaction::create(['blog_post_slug' => 'test-blog-post', 'reaction' => 'like']);
    BlogReaction::create(['blog_post_slug' => 'test-blog-post', 'reaction' => 'wow']);
    BlogReaction::create(['blog_post_slug' => 'other-post', 'reaction' => 'love']);

    Livewire::test(BlogpostReact::class, ['slug' => 'test-blog-post'])
        ->assertSet('reactionCounts', [
            'like' => 2,
            'love' => 0,
            'wow' => 1,
            'haha' => 0,
        ]);
});

it('dispatches a job and optimistically increments the count when reacting', function () {
    Queue::fake();

    Livewire::test(BlogpostReact::class, ['slug' => 'test-blog-post'])
        ->call('addReaction', 'love')
        ->assertSet('reactionCounts.love', 1);

    Queue::assertPushed(AddReactionToBlogpost::class, fn ($job) => $job->slug === 'test-blog-post' && $job->reaction === 'love');
});

it('only allows one reaction per post per session', function () {
    Queue::fake();

    Livewire::test(BlogpostReact::class, ['slug' => 'test-blog-post'])
        ->call('addReaction', 'like')
        ->call('addReaction', 'haha')
        ->assertSet('reactionCounts.like', 1)
        ->assertSet('reactionCounts.haha', 0);

    Queue::assertPushed(AddReactionToBlogpost::class, 1);
});
