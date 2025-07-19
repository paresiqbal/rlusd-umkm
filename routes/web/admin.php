<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FreelanceController;
use App\Http\Controllers\Admin\MitraController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\VacancyController;
use App\Utility\DeclareAuthRouteUtility;
use Illuminate\Support\Facades\Route;

DeclareAuthRouteUtility::declareRoute(AuthController::class, false, false);

Route::get('/districts/{province}', [MitraController::class, 'getDistricts']);

Route::middleware("role:admin")->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/mitra', [MitraController::class, 'index'])->name('mitra');
    Route::get('/admin/freelance', [FreelanceController::class, 'index'])->name('freelance');

    route::name('partners.')->prefix('/admin/partners')->group(function () {
        Route::get('/', [MitraController::class, 'index'])->name('index');
        Route::get('/download', [MitraController::class, 'downloadMitra'])->name('download');
        Route::get('/fetch', [MitraController::class, 'fetchPartner'])->name('fetchPartner');
        Route::get('/{id}', [MitraController::class, 'getMitraById'])
            ->where('id', '[0-9]+')
            ->name('get');
        Route::post('/{id}/activate', [MitraController::class, 'activateMitra'])
            ->where('id', '[0-9]+')
            ->name('activate');
        Route::post('/{id}/deactivate', [MitraController::class, 'deactivateMitra'])
            ->where('id', '[0-9]+')
            ->name('deactivate');
        Route::delete('/{id}', [MitraController::class, 'deleteMitra'])
            ->where('id', '[0-9]+')
            ->name('delete');
    });

    route::name('vacancies.')->prefix('/admin/vacancies')->group(function () {
        Route::get('/', [VacancyController::class, 'index'])->name("index");
        Route::get('/fetch', [VacancyController::class, 'fetchJobs'])->name('fetch');
        Route::get('/{id}', [VacancyController::class, 'getJobById'])->name('get');
        Route::post('/{id}/accept', [VacancyController::class, 'acceptJobs'])->name('accept');
        Route::post('/{id}/reject', [VacancyController::class, 'rejectJobs'])->name('reject');
        Route::delete('/{id}', [VacancyController::class, 'deleteJob'])->name('delete');
    });

    Route::name('candidates.')->prefix('/admin/candidates')->group(function () {
        Route::get('/', [CandidateController::class, 'index'])->name("index");
        Route::get('/fetch', [CandidateController::class, 'fetchCandidate'])->name('fetch');
        Route::get('/{id}', [CandidateController::class, 'getCandidateById'])->name('get');
        Route::post('/{id}/accept', [CandidateController::class, 'acceptCandidate'])->name('accept');
        Route::post('/{id}/reject', [CandidateController::class, 'rejectCandidate'])->name('reject');
        Route::delete('/{id}', [CandidateController::class, 'deleteCandidate'])->name('delete');
        Route::get('/download/cv/{id}', [CandidateController::class, 'downloadCV'])->name('download.cv');
    });

    Route::name('freelancers.')->prefix('/admin/freelancers')->group(function () {
        Route::get('/', [FreelanceController::class, 'index'])->name('index');
        Route::get('/fetch', [FreelanceController::class, 'fetchFreelancer'])->name('fetchFreelancer');
        Route::get('/download', [FreelanceController::class, 'downloadFreelancer'])->name('download');
        Route::get('/{id}', [FreelanceController::class, 'getFreelancerById'])->name('get')->where('id', '[0-9]+')
            ->name('get');;
        Route::post('/{id}/activate', [FreelanceController::class, 'activateFreelancer'])->name('activate')->where('id', '[0-9]+')
            ->name('get');;
        Route::post('/{id}/deactivate', [FreelanceController::class, 'deactivateFreelancer'])->name('deactivate')->where('id', '[0-9]+')
            ->name('get');;
        Route::delete('/{id}', [FreelanceController::class, 'deleteFreelancer'])->name('delete')->where('id', '[0-9]+')
            ->name('get');;
        Route::get('/download/cv/{id}', [FreelanceController::class, 'downloadCV'])->name('download.cv');
    });;
});
