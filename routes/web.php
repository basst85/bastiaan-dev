<?php

use Livewire\Volt\Volt;
use App\Livewire\SendMessage;
use App\Livewire\IndexBlogpost;
use App\Livewire\ShowBlogpost;
use Spatie\MarkdownResponse\Middleware\ProvideMarkdownResponse;

Volt::route('/', 'welcome');
Volt::route('/contact', SendMessage::class);

Route::middleware(ProvideMarkdownResponse::class)->group(function () {
    Route::get('/blog', IndexBlogpost::class);
    Route::get('/blog/{slug}', ShowBlogpost::class)->name('blogpost.show');
});
