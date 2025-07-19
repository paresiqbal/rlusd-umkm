<?php

use App\Http\Controllers\Partner\AuthController;
use App\Http\Controllers\Partner\CandidateController;
use App\Http\Controllers\Partner\DashboardController;
use App\Http\Controllers\Partner\FreelancerController;
use App\Http\Controllers\Partner\JobController;
use App\Http\Controllers\Partner\ProfileController;
use App\Utility\DeclareAuthRouteUtility;
use Illuminate\Support\Facades\Route;

DeclareAuthRouteUtility::declareRoute(AuthController::class, true, true);

Route::middleware("role:partner")->group(function () {
    Route::get('/partner/dashboard', [DashboardController::class, 'index'])->name("dashboard");

    Route::get('/districts/{province}', [ProfileController::class, 'getDistricts']);
    Route::get('/subdistricts/{district}', [ProfileController::class, 'getSubdistricts']);

    Route::name("jobs.")->prefix("/partner/jobs")->group(function () {
        Route::get('/', [JobController::class, 'index'])->name("index");
        Route::get('/fetch', [JobController::class, 'fetchJobs'])->name('fetch');
        Route::post('/store', [JobController::class, 'storeJob'])->name('store');
        Route::put('/update/{id}', [JobController::class, 'updateJob'])->name('update');
        Route::put('/update-status/{id}', [JobController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/{id}', [JobController::class, 'getJobById'])->name('get');
        Route::delete('/{id}', [JobController::class, 'delete'])->name('delete');
    });

    Route::name('profile.')->prefix('/partner/profiles')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/update', [ProfileController::class, 'updateProfile'])->name('update');
        Route::post('/update-about-company', [ProfileController::class, 'updateAboutCompany'])->name('updateAboutCompany');
        Route::post('/update-pic', [ProfileController::class, 'updatePIC'])->name('updatePIC');
        Route::post('/update-website', [ProfileController::class, 'updateWebsite'])->name('updateWebsite');
        Route::post('/update-photo', [ProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::delete('/delete-photo', [ProfileController::class, 'deletePhoto'])->name('delete-photo');
    });

    Route::name('candidates.')->prefix('/partner/candidates')->group(function () {
        Route::get('/', [CandidateController::class, 'index'])->name('index');
        Route::get('/fetch', [CandidateController::class, 'fetchCandidate'])->name('fetch');
        Route::get('/{id}', [CandidateController::class, 'getCandidateById'])->name('get');
        Route::post('/{id}/accept', [CandidateController::class, 'acceptCandidate'])->name('accept');
        Route::post('/{id}/reject', [CandidateController::class, 'rejectCandidate'])->name('reject');
        Route::post('/{id}/complete', [CandidateController::class, 'completedCandidate'])->name('complete');

        Route::delete('/{id}', [CandidateController::class, 'deleteCandidate'])->name('delete');
    });

    Route::name('freelancers.')->prefix('partner/freelancer')->group(function () {
        Route::get('/', [FreelancerController::class, 'index'])->name('index');
        Route::get('/{id}', [FreelancerController::class, 'detail'])->name('detail');
    });
});
