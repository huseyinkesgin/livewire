<?php

use App\Livewire\Location\CityIndex;
use App\Livewire\Location\StateIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('states', StateIndex::class)->name('states');
    Route::get('cities', CityIndex::class)->name('cities');
});