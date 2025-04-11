<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('dashboard');
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('dashboard');
})->name('dashboard');

Route::get('/invoices', function () {
    return Inertia::render('invoices');
})->name('invoices');

Route::get('/forum', function () {
    return Inertia::render('forum');
})->name('forum');

Route::get('/reports', function () {
    return Inertia::render('reports');
})->name('reports');

Route::get('/users', function () {
    return Inertia::render('users');
})->name('users');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
