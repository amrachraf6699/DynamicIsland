<?php

use App\Http\Controllers\Admin\AwardController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogSectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GallerySectionController;
use App\Http\Controllers\Admin\JobPostingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PageGroupController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PartialController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('login', [AdminAuthController::class, 'store'])->name('login.store');
});

Route::post('logout', [AdminAuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('page-groups', PageGroupController::class)->except(['show']);
        Route::resource('pages', PageController::class)->except(['show']);
        Route::resource('partials', PartialController::class)->except(['show']);
        Route::resource('services', ServiceController::class)->except(['show']);
        Route::resource('projects', ProjectController::class)->except(['show']);
        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        Route::resource('sliders', SliderController::class)->except(['show']);
        Route::resource('team-members', TeamMemberController::class)->except(['show']);
        Route::resource('blog-sections', BlogSectionController::class)->except(['show']);
        Route::resource('blogs', BlogController::class)->except(['show']);
        Route::resource('statistics', StatisticController::class)->except(['show']);
        Route::resource('job-postings', JobPostingController::class)->except(['show']);
        Route::resource('gallery-sections', GallerySectionController::class)->except(['show']);
        Route::resource('galleries', GalleryController::class)->except(['show']);
        Route::resource('partners', PartnerController::class)->except(['show']);
        Route::resource('awards', AwardController::class)->except(['show']);
    });
