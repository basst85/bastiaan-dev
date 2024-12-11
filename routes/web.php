<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Welcome;
use Livewire\Volt\Volt;

Route::get('/', Welcome::class);
Volt::route('/contact', 'contact');
