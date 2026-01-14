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
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\RoleCrudController;
use App\Http\Controllers\Admin\UserCrudController;
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

        Route::delete('page-groups/bulk-destroy', [PageGroupController::class, 'bulkDestroy'])->name('page-groups.bulk-destroy');
        Route::resource('page-groups', PageGroupController::class)->except(['show']);
        Route::delete('pages/bulk-destroy', [PageController::class, 'bulkDestroy'])->name('pages.bulk-destroy');
        Route::resource('pages', PageController::class)->except(['show']);
        Route::delete('partials/bulk-destroy', [PartialController::class, 'bulkDestroy'])->name('partials.bulk-destroy');
        Route::resource('partials', PartialController::class)->except(['show']);
        Route::delete('services/bulk-destroy', [ServiceController::class, 'bulkDestroy'])->name('services.bulk-destroy');
        Route::resource('services', ServiceController::class);
        Route::delete('projects/bulk-destroy', [ProjectController::class, 'bulkDestroy'])->name('projects.bulk-destroy');
        Route::resource('projects', ProjectController::class)->except(['show']);
        Route::delete('testimonials/bulk-destroy', [TestimonialController::class, 'bulkDestroy'])->name('testimonials.bulk-destroy');
        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        Route::delete('sliders/bulk-destroy', [SliderController::class, 'bulkDestroy'])->name('sliders.bulk-destroy');
        Route::resource('sliders', SliderController::class)->except(['show']);
        Route::delete('team-members/bulk-destroy', [TeamMemberController::class, 'bulkDestroy'])->name('team-members.bulk-destroy');
        Route::resource('team-members', TeamMemberController::class)->except(['show']);
        Route::delete('blog-sections/bulk-destroy', [BlogSectionController::class, 'bulkDestroy'])->name('blog-sections.bulk-destroy');
        Route::resource('blog-sections', BlogSectionController::class)->except(['show']);
        Route::delete('blogs/bulk-destroy', [BlogController::class, 'bulkDestroy'])->name('blogs.bulk-destroy');
        Route::resource('blogs', BlogController::class)->except(['show']);
        Route::delete('statistics/bulk-destroy', [StatisticController::class, 'bulkDestroy'])->name('statistics.bulk-destroy');
        Route::resource('statistics', StatisticController::class)->except(['show']);
        Route::delete('job-postings/bulk-destroy', [JobPostingController::class, 'bulkDestroy'])->name('job-postings.bulk-destroy');
        Route::resource('job-postings', JobPostingController::class)->except(['show']);
        Route::delete('gallery-sections/bulk-destroy', [GallerySectionController::class, 'bulkDestroy'])->name('gallery-sections.bulk-destroy');
        Route::resource('gallery-sections', GallerySectionController::class)->except(['show']);
        Route::delete('galleries/bulk-destroy', [GalleryController::class, 'bulkDestroy'])->name('galleries.bulk-destroy');
        Route::resource('galleries', GalleryController::class)->except(['show']);
        Route::delete('partners/bulk-destroy', [PartnerController::class, 'bulkDestroy'])->name('partners.bulk-destroy');
        Route::resource('partners', PartnerController::class)->except(['show']);
        Route::delete('awards/bulk-destroy', [AwardController::class, 'bulkDestroy'])->name('awards.bulk-destroy');
        Route::resource('awards', AwardController::class)->except(['show']);

        Route::delete('newsletters/bulk-destroy', [NewsletterController::class, 'bulkDestroy'])->name('newsletters.bulk-destroy');
        Route::resource('newsletters', NewsletterController::class)->only(['index', 'destroy']);
        Route::get('newsletters/campaign/create', [NewsletterController::class, 'campaignForm'])->name('newsletters.campaign');
        Route::post('newsletters/campaign', [NewsletterController::class, 'campaign'])->name('newsletters.campaign.send');

        Route::delete('contacts/bulk-destroy', [ContactController::class, 'bulkDestroy'])->name('contacts.bulk-destroy');
        Route::resource('contacts', ContactController::class)->only(['index', 'destroy']);
        Route::get('contacts/{contact}/reply', [ContactController::class, 'replyForm'])->name('contacts.reply');
        Route::post('contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply.send');

        // Settings
        Route::get('settings/{group}', [SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('settings/{group}', [SettingsController::class, 'update'])->name('settings.update');

        // Roles & Users CRUD
        Route::delete('roles/bulk-destroy', [RoleCrudController::class, 'bulkDestroy'])->name('roles.bulk-destroy');
        Route::resource('roles', RoleCrudController::class)->except(['show']);
        Route::delete('users/bulk-destroy', [UserCrudController::class, 'bulkDestroy'])->name('users.bulk-destroy');
        Route::resource('users', UserCrudController::class)->except(['show']);
    });
