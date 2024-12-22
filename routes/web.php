<?php

use Livewire\Volt\Volt;
use App\Livewire\SendMessage;

Volt::route('/', 'welcome');
Volt::route('/contact', SendMessage::class);
Volt::route('/blog', 'welcome');
