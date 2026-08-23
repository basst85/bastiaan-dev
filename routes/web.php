<?php

use App\Livewire\IndexBlogpost;
use App\Livewire\SendMessage;
use App\Livewire\ShowBlogpost;
use App\Livewire\ShowBlogpostTag;
use Livewire\Volt\Volt;
use Spatie\MarkdownResponse\Middleware\ProvideMarkdownResponse;

Volt::route('/', 'welcome');
Volt::route('/contact', SendMessage::class);

Route::middleware(ProvideMarkdownResponse::class)->group(function () {
    Route::get('/blog', IndexBlogpost::class)->name('blog');
    Route::get('/blog/tag/{tag}', ShowBlogpostTag::class)->name('blogpost.tag');
    Route::get('/blog/{slug}', ShowBlogpost::class)->name('blogpost.show');
});
