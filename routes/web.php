<?php

use App\Http\Controllers\ApplicationAdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeDataController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PublicJobVacancyController;
use App\Http\Controllers\UsersController;
use App\Models\Penilaian;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HrApprovalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login');
Route::get('/login', [HomeController::class, 'index'])
    ->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('user.logout');
Route::prefix('lowongan')->name('lowongan.')->group(function () {
    Route::get('/', [PublicJobVacancyController::class, 'index'])->name('index');
    Route::get('/detail/{id}', [PublicJobVacancyController::class, 'show'])->name('show');
});

Route::prefix('apply')->name('application.')->group(function () {
    Route::get('/{jobVacancy}', [ApplicationController::class, 'create'])->name('create');
    Route::post('/{jobVacancy}', [ApplicationController::class, 'store'])->name('store');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('employee-data', [EmployeeDataController::class, 'create'])->name('employee-data.create');
    Route::post('employee-data', [EmployeeDataController::class, 'store'])->name('employee-data.store');
    Route::post('employee-data/upload-signed-contract', [EmployeeDataController::class, 'uploadSignedContract'])->name('employee-data.upload-signed-contract');
    Route::get('employee-data/view-contract/{userId}', [EmployeeDataController::class, 'viewContract'])->name('employee-data.view-contract');
    Route::get('employee-data/download-contract/{userId}', [EmployeeDataController::class, 'downloadContract'])->name('employee-data.download-contract');
    // Group untuk menus (tanpa prefix user)
    Route::prefix('menus')->name('menus.')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::post('/store', [MenuController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{id}', [MenuController::class, 'destroy'])->name('destroy');

        // Menu order management
        Route::get('/move/{id}/{direction}', [MenuController::class, 'move'])->name('move');

        // Menu parent selection (AJAX)
        Route::post('/parents', [MenuController::class, 'getParents'])->name('parents');

        // Tree view
        Route::get('/tree', [MenuController::class, 'tree'])->name('tree');

        // Menu roles/access management
        Route::get('/roles', [MenuController::class, 'roles'])->name('roles');
        Route::get('/get-group-access/{group_id}', [MenuController::class, 'getGroupAccess'])->name('get-group-access');
        Route::post('/save-group-access', [MenuController::class, 'saveGroupAccess'])->name('save-group-access');
        Route::post('/toggle-access', [MenuController::class, 'toggleAccess'])->name('toggle-access');
        Route::post('/bulk-assign-access', [MenuController::class, 'bulkAssignAccess'])->name('bulk-assign-access');
        Route::get('/export-roles', [MenuController::class, 'exportRoles'])->name('export-roles');
    });

    // Group terpisah untuk user
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index'); // Diubah dari '/user' ke '/'
        Route::get('/create', [UsersController::class, 'create'])->name('create');
        Route::post('/', [UsersController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [UsersController::class, 'update'])->name('update');
        Route::delete('/{id}', [UsersController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('penilaian')->name('penilaian.')->group(function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('index');
        Route::get('/create', [PenilaianController::class, 'create'])->name('create');
        Route::post('/', [PenilaianController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PenilaianController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PenilaianController::class, 'update'])->name('update');
        Route::delete('/{id}', [PenilaianController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('job-vacancy')->name('job-vacancy.')->group(function () {
        Route::get('/', [JobVacancyController::class, 'index'])->name('index');
        Route::get('/create', [JobVacancyController::class, 'create'])->name('create');
        Route::post('/', [JobVacancyController::class, 'store'])->name('store');
        Route::get('/{id}', [JobVacancyController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [JobVacancyController::class, 'edit'])->name('edit');
        Route::put('/{id}', [JobVacancyController::class, 'update'])->name('update');
        Route::delete('/{id}', [JobVacancyController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('apps')->name('admin.applications.')->middleware(['auth'])->group(function () {
        Route::get('/', [ApplicationAdminController::class, 'index'])->name('index');
        Route::get('/{id}', [ApplicationAdminController::class, 'show'])->name('show');
        Route::put('/{id}/status', [ApplicationAdminController::class, 'updateStatus'])->name('update-status');
        Route::get('/{id}/download-cv', [ApplicationAdminController::class, 'downloadCV'])->name('download-cv');
        Route::get('/{id}/download-portfolio', [ApplicationAdminController::class, 'downloadPortfolio'])->name('download-portfolio');
    });
    Route::prefix('groups')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->name('groups.index');
        Route::get('/create', [GroupController::class, 'create'])->name('groups.create');
        Route::post('/', [GroupController::class, 'store'])->name('groups.store');
        Route::get('/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
        Route::put('/{group}', [GroupController::class, 'update'])->name('groups.update');
        Route::delete('/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');
    });
    Route::prefix('evaluations')->name('evaluations.')->group(function () {
        Route::get('/', [EvaluationController::class, 'index'])->name('index');
        Route::get('/{asesi_id}/create', [EvaluationController::class, 'create'])->name('create');
        Route::post('/{asesi_id}/store', [EvaluationController::class, 'store'])->name('store');
        Route::get('/{asesi_id}/show', [EvaluationController::class, 'showEvaluation'])->name('show');
        Route::get('/{asesi_id}/export-pdf', [EvaluationController::class, 'exportPdf'])->name('exportPdf');
    });
    Route::get('/hr-approval', [HrApprovalController::class, 'index'])->name('hr-approval.index');
    Route::get('/hr-approval/{id}', [HrApprovalController::class, 'edit'])->name('hr-approval.edit');
    Route::post('/hr-approval/{id}', [HrApprovalController::class, 'update'])->name('hr-approval.update');
});
