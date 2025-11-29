<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ScholarshipProgramController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AuthenticateController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/terms', function () {
    return view('auth.terms');
})->name('terms');

Route::get('/register', [AuthenticateController::class, 'registerForm'])->name('register.form');
Route::post('/register', [AuthenticateController::class, 'register'])->name('register');
Route::get('/login', [AuthenticateController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthenticateController::class, 'login'])->name('login');
Route::post('/logout', [AuthenticateController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard routes
    Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/viewer/report', [DashboardController::class, 'viewerReports'])->name('viewer.report');

    // Common dashboard redirect
    Route::get('/dashboard', function () {
        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'viewer':
                return redirect()->route('viewer.report');
            case 'user':
            default:
                return redirect()->route('user.dashboard');
        }
    })->name('dashboard');

    // File download route
    Route::get('/applications/{application}/download/{fileType}', [ApplicationController::class, 'downloadFile'])
        ->name('applications.download');

    // Shared routes
    Route::get('/programs', [ScholarshipProgramController::class, 'index'])->name('programs.index');
    Route::get('/programs/{program}', [ScholarshipProgramController::class, 'show'])->name('programs.show');
    
    // Applications routes
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');

    // Student-only routes
    Route::middleware(['role:user'])->group(function () {
        Route::get('/applications/{program}/create', [ApplicationController::class, 'create'])->name('applications.create');
        Route::post('/applications/{program}', [ApplicationController::class, 'store'])->name('applications.store');
    });

    // Admin-only routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        // Program management
        Route::get('/programs', [ScholarshipProgramController::class, 'adminIndex'])->name('admin.programs.index');
        Route::get('/programs/create', [ScholarshipProgramController::class, 'create'])->name('admin.programs.create');
        Route::post('/programs', [ScholarshipProgramController::class, 'store'])->name('admin.programs.store');
        Route::get('/programs/{program}/edit', [ScholarshipProgramController::class, 'edit'])->name('admin.programs.edit');
        Route::put('/programs/{program}', [ScholarshipProgramController::class, 'update'])->name('admin.programs.update');
        Route::delete('/programs/{program}', [ScholarshipProgramController::class, 'destroy'])->name('admin.programs.destroy');
        Route::post('/programs/{program}/toggle-status', [ScholarshipProgramController::class, 'toggleStatus'])->name('admin.programs.toggle-status');
        
        // Application management
        Route::get('/applications', [ApplicationController::class, 'adminIndex'])->name('admin.applications.index');
        Route::get('/applications/{application}', [ApplicationController::class, 'adminShow'])->name('admin.applications.show');
        
        // User management
        Route::get('/users', [ApplicationController::class, 'manageUsers'])->name('admin.users.index');
        Route::post('/users/{user}/update-role', [ApplicationController::class, 'updateUserRole'])->name('admin.users.update-role');
        
        // Application actions
        Route::post('/applications/{application}/assign', [ApplicationController::class, 'assignReviewer'])->name('applications.assign');
        Route::post('/applications/{application}/update-status', [ApplicationController::class, 'updateStatus'])->name('applications.update-status');
    });

    // Viewer-only routes
    Route::middleware(['role:viewer'])->prefix('viewer')->group(function () {
        Route::get('/applications', [ApplicationController::class, 'viewerIndex'])->name('viewer.applications.index');
        Route::get('/applications/{application}', [ApplicationController::class, 'viewerShow'])->name('viewer.applications.show');
        Route::get('/evaluations/{application}/create', [EvaluationController::class, 'create'])->name('evaluations.create');
        Route::post('/evaluations/{application}', [EvaluationController::class, 'store'])->name('evaluations.store');
        Route::get('/evaluations', [EvaluationController::class, 'myEvaluations'])->name('evaluations.my');
    });

    // Role-specific message routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::resource('messages', MessageController::class)->names([
            'index' => 'admin.messages.index',
            'create' => 'admin.messages.create',
            'store' => 'admin.messages.store',
            'show' => 'admin.messages.show',
        ]);
        Route::post('/messages/{message}/mark-read', [MessageController::class, 'markAsRead'])->name('admin.messages.mark-read');
        Route::get('/messages/unread/count', [MessageController::class, 'getUnreadCount'])->name('admin.messages.unread-count');
    });

    Route::middleware(['role:viewer'])->prefix('viewer')->group(function () {
        Route::resource('messages', MessageController::class)->names([
            'index' => 'viewer.messages.index',
            'create' => 'viewer.messages.create',
            'store' => 'viewer.messages.store',
            'show' => 'viewer.messages.show',
        ]);
        Route::post('/messages/{message}/mark-read', [MessageController::class, 'markAsRead'])->name('viewer.messages.mark-read');
        Route::get('/messages/unread/count', [MessageController::class, 'getUnreadCount'])->name('viewer.messages.unread-count');
    });

    Route::middleware(['role:user'])->prefix('user')->group(function () {
        Route::resource('messages', MessageController::class)->names([
            'index' => 'user.messages.index',
            'create' => 'user.messages.create',
            'store' => 'user.messages.store',
            'show' => 'user.messages.show',
        ]);
        Route::post('/messages/{message}/mark-read', [MessageController::class, 'markAsRead'])->name('user.messages.mark-read');
        Route::get('/messages/unread/count', [MessageController::class, 'getUnreadCount'])->name('user.messages.unread-count');
    });
});