<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\JobController;
use App\Http\Controllers\User\ProfileController;
use App\Utility\DeclareAuthRouteUtility;
use Illuminate\Support\Facades\Route;

DeclareAuthRouteUtility::declareRoute(AuthController::class, true, true, "freelancer");

Route::middleware(["role:freelancer", "verify-email"])->group(function () {
    Route::get('/districts/{province}', [ProfileController::class, 'getDistricts']);
    Route::get('/subdistricts/{district}', [ProfileController::class, 'getSubdistricts']);

    Route::name('profiles.')->prefix('profiles')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::post('/personal-data', [ProfileController::class, 'updatePersonalData'])->name('update-personal-data');
        Route::post('/about-me', [ProfileController::class, 'updateAboutMe'])->name('about-me');
        Route::post('/update-photo', [ProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::delete('/delete-photo', [ProfileController::class, 'deletePhoto'])->name('delete-photo');

        Route::name('work-experiences.')->prefix('work-experiences')->group(function () {
            Route::post('/', [ProfileController::class, 'storeWorkExperience'])->name('store');
            Route::put('/', [ProfileController::class, 'updateWorkExperience'])->name('update');
            Route::delete('/{id}', [ProfileController::class, 'deleteWorkExperience'])->name('delete');
        });

        Route::name('educations.')->prefix('educations')->group(function () {
            Route::post('/', [ProfileController::class, 'storeEducation'])->name('store');
            Route::put('/', [ProfileController::class, 'updateEducation'])->name('update');
            Route::delete('/{id}', [ProfileController::class, 'deleteEducation'])->name('delete');
        });

        Route::name('achievements.')->prefix('achievements')->group(function () {
            Route::post('/', [ProfileController::class, 'storeAchievement'])->name('store');
            Route::put('/', [ProfileController::class, 'updateAchievement'])->name('update');
            Route::delete('/{id}', [ProfileController::class, 'deleteAchievement'])->name('delete');
        });

        Route::name('skills.')->prefix('skills')->group(function () {
            Route::post('/', [ProfileController::class, 'storeSkill'])->name('store');
            Route::delete('/{id}', [ProfileController::class, 'deleteSkill'])->name('delete');
        });

        Route::name('cv.')->prefix('cv')->group(function () {
            Route::get('/', [ProfileController::class, 'showCv'])->name('show');
            Route::post('/', [ProfileController::class, 'updateCv'])->name('update');
            Route::delete('/', [ProfileController::class, 'deleteCv'])->name('delete');
        });

        Route::name('skkni.')->prefix('skkni')->group(function () {
            Route::get('/', [ProfileController::class, 'showSKKNI'])->name('show');
            Route::post('/', [ProfileController::class, 'updateSKKNI'])->name('update');
            Route::delete('/', [ProfileController::class, 'deleteSkkni'])->name('delete');
        });

        Route::name('skkk.')->prefix('skkk')->group(function () {
            Route::get('/', [ProfileController::class, 'showSKKK'])->name('show');
            Route::post('/', [ProfileController::class, 'updateSKKK'])->name('update');
            Route::delete('/', [ProfileController::class, 'deleteSkkk'])->name('delete');
        });

        Route::name('applications.')->prefix('applications')->group(function () {
            Route::get('/', [ProfileController::class, 'showApplications'])->name('show');
        });
    });

    Route::name('jobs.')->prefix('jobs')->group(function () {
        Route::get('/search', [JobController::class, 'index'])->name('index-search');
        Route::get('/{id}', [JobController::class, 'show'])->name('show');
        Route::post('/{id}/apply', [JobController::class, 'store'])->name('apply');
    });
});
