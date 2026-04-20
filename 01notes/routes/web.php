<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('notes', NoteController::class);

Route::put('notes/{note}/toggle-pinned',[NoteController::class, 'togglePinned'])->name('notes.toggle-pinned');

Route::fallback(function () {
    return 'Still got somewhere';
});
