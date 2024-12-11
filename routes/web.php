<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Welcome;
use App\Livewire\SendMessage;
//use Livewire\Volt\Volt;

Route::get('/', Welcome::class);
Route::get('/contact', SendMessage::class);
