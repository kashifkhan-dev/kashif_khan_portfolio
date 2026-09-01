<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectShowController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Portfolio Routes
Route::get('/', LandingController::class)->name('home');
Route::get('/projects/{project}', [ProjectShowController::class, 'show'])->name('projects.show');
Route::post('/contact', ContactController::class)->name('contact.store');

// Legacy /dashboard redirect alias
Route::middleware(['auth'])->get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

// Admin Panel Routes (Protected by Auth middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Hero Section Content Editor
    Route::get('/hero', [HeroController::class, 'index'])->name('hero.index');
    Route::post('/hero', [HeroController::class, 'update'])->name('hero.update');

    // Projects CRUD
    Route::resource('projects', ProjectController::class)->except(['show']);

    // Skills CRUD
    Route::resource('skills', SkillController::class)->except(['create', 'edit', 'show']);

    // Experiences CRUD
    Route::resource('experiences', ExperienceController::class)->except(['create', 'edit', 'show']);

    // Messages Inbox
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::patch('/messages/{message}/toggle-read', [MessageController::class, 'toggleRead'])->name('messages.toggle-read');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Site Settings Editor
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // User Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
