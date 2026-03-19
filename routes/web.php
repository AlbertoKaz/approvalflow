<?php

use App\Livewire\ApprovalRequests\Create;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('/requests/create', Create::class)->name('requests.create');
});



require __DIR__.'/settings.php';
