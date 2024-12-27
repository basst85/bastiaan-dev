<?php

use Livewire\Volt\Volt;
use App\Livewire\SendMessage;
use App\Livewire\IndexBlogpost;
use App\Livewire\ShowBlogpost;

Volt::route('/', 'welcome');
Volt::route('/contact', SendMessage::class);
Volt::route('/blog', IndexBlogpost::class);
Volt::route('/blog/{slug}', ShowBlogpost::class);
