<?php

use App\Livewire\ApprovalRequests\Create;
use App\Livewire\ApprovalRequests\Index;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/requests', Index::class)->name('requests.index');
    Route::get('/requests/create', Create::class)->name('requests.create');
});



require __DIR__.'/settings.php';
