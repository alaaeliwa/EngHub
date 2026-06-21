<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NotificationController;

// Main Controller Routes
Route::get('/', [MainController::class, 'home'])->name('home');
Route::get('/login', [MainController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.post');
Route::get('/register', [MainController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerSubmit'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [MainController::class, 'forgotPassword'])->name('forgot-password');

Route::middleware(['auth'])->group(function () {
    Route::get('/courses', [MainController::class, 'courses'])->name('courses');
    Route::get('/course-details', [MainController::class, 'courseDetails'])->name('course.details');
    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    Route::get('/upload', [MainController::class, 'upload'])->name('upload');
    Route::get('/upload-success', [MainController::class, 'uploadSuccess'])->name('upload.success');
    Route::get('/favorites', [MainController::class, 'favorites'])->name('favorites');
    Route::get('/profile', [MainController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/favorite/{id}', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorite.toggle');

    // Workshops
    Route::get('/workshops', [MainController::class, 'workshops'])->name('workshops');
    Route::get('/create-workshop', [MainController::class, 'createWorkshop'])->name('create-workshop');
    Route::post('/create-workshop', [MainController::class, 'storeWorkshop'])->name('workshop.store');
    Route::get('/workshop-details/{id}', [MainController::class, 'workshopDetails'])->name('workshop-details');
    Route::post('/workshops/{id}/register', [MainController::class, 'registerWorkshop'])->name('workshop.register');
    Route::get('/search', [SearchController::class, 'search'])->name('search.api');

    // Comments
    Route::post('/courses/{courseId}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{id}/like', [\App\Http\Controllers\CommentController::class, 'toggleLike'])->name('comments.like');
    Route::delete('/comments/{id}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin');
    // JSON endpoint for live dashboard stats
    Route::get('/admin/stats/json', [\App\Http\Controllers\AdminController::class, 'statsJson'])->name('admin.stats.json');
    
    // Users
    Route::put('/admin/users/{id}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/admin/users/{id}/toggle-ban', [\App\Http\Controllers\AdminController::class, 'toggleBanUser'])->name('admin.users.toggle-ban');
    Route::delete('/admin/users/{id}', [\App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.users.delete');

    // Courses
    Route::post('/admin/courses', [\App\Http\Controllers\AdminController::class, 'storeCourse'])->name('admin.courses.store');
    Route::put('/admin/courses/{id}/status', [\App\Http\Controllers\AdminController::class, 'changeCourseStatus'])->name('admin.courses.status');
    Route::delete('/admin/courses/{id}', [\App\Http\Controllers\AdminController::class, 'deleteCourse'])->name('admin.courses.delete');

    // Materials
    Route::put('/admin/materials/{id}/status', [\App\Http\Controllers\AdminController::class, 'changeMaterialStatus'])->name('admin.materials.status');
    Route::delete('/admin/materials/{id}', [\App\Http\Controllers\AdminController::class, 'deleteMaterial'])->name('admin.materials.delete');

    // Workshops
    Route::get('/admin/workshops/{id}/edit', [\App\Http\Controllers\AdminController::class, 'editWorkshop'])->name('admin.workshops.edit');
    Route::put('/admin/workshops/{id}', [\App\Http\Controllers\AdminController::class, 'updateWorkshop'])->name('admin.workshops.update');
    Route::put('/admin/workshops/{id}/status', [\App\Http\Controllers\AdminController::class, 'changeWorkshopStatus'])->name('admin.workshops.status');
    Route::delete('/admin/workshops/{id}', [\App\Http\Controllers\AdminController::class, 'deleteWorkshop'])->name('admin.workshops.delete');

    // Comments
    Route::delete('/admin/comments/{id}', [\App\Http\Controllers\AdminController::class, 'deleteComment'])->name('admin.comments.delete');
});