<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\RegistrationController;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
    Route::post('/switch-user', [LoginController::class, 'switchUser'])->name('login.switch_user');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/show', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::get('/dashboard/edit', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::put('/dashboard/update', [DashboardController::class, 'update'])->name('dashboard.update');

    Route::resource('/user', UserController::class)->middleware('role:Superadmin');
    Route::resource('/event_categories', EventCategoryController::class)->middleware('role:Superadmin,Organizer');
    Route::resource('/venues', VenueController::class)->middleware('role:Superadmin,Organizer');
    Route::resource('/organizers', OrganizerController::class)->middleware('role:Superadmin,Organizer');
    Route::resource('/events', EventController::class)->middleware('role:Superadmin,Organizer');
    Route::resource('/tickets', TicketController::class)->middleware('role:Superadmin,Organizer');
    Route::resource('/speakers', SpeakerController::class)->middleware('role:Superadmin,Organizer');
    Route::resource('/sponsors', SponsorController::class)->middleware('role:Superadmin,Organizer');
    Route::resource('/registrations', RegistrationController::class)->middleware('role:Superadmin,Organizer');
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/{setting}/update', [SettingController::class, 'update'])->name('setting.update');
});
