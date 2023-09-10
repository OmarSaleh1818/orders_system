<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\ApplicantControllar;
use App\Http\Controllers\Setting\SectionsController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Setting\ProjectsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// All Applicant route
    Route::get('/applicant/view', [ApplicantControllar::class, 'applicantView'])->name('applicant.view');
    Route::get('/add/order', [ApplicantControllar::class, 'addOrder'])->name('add.order');
    Route::post('/applicant/store', [ApplicantControllar::class, 'ApplicantStore'])->name('applicant.store');
    Route::get('/applicant/edit/{id}', [ApplicantControllar::class, 'ApplicantEdit'])->name('applicant.edit');
    Route::post('/applicant/update/{id}', [ApplicantControllar::class, 'ApplicantUpdate'])->name('applicant.update');
    Route::get('/applicant/delete/{id}', [ApplicantControllar::class, 'applicantDelete'])->name('applicant.delete');
    Route::get('/get-items/{projectId}', [ApplicantControllar::class, 'getItems']);
    Route::get('/get-item-value/{itemName}', [ApplicantControllar::class, 'getItemValue']);
    Route::get('/get-remaining-value/{itemName}', [ApplicantControllar::class, 'getRemainingValue']);

// End

// All Section Route
    Route::get('/section/view', [SectionsController::class, 'SectionView'])->name('sections');
    Route::post('/section/store', [SectionsController::class, 'SectionStore'])->name('section.store');
    Route::get('/section/edit/{id}', [SectionsController::class, 'SectionEdit'])->name('section.edit');
    Route::post('/section/update/{id}', [SectionsController::class, 'SectionUpdate'])->name('section.update');
    Route::get('/section/delete/{id}', [SectionsController::class, 'SectionDelete'])->name('section.delete');
// End

// All Users Route
    Route::prefix('users')->group(function() {
    Route::get('/view', [RegisteredUserController::class, 'create'])->name('users');
    Route::get('/create', [RegisteredUserController::class, 'UsersCreate'])->name('users_create');
    Route::post('/store', [RegisteredUserController::class, 'UsersStore'])->name('users.store');
    });
// End

// All Project Route
    Route::get('/project/view', [ProjectsController::class, 'ProjectView'])->name('project.view');
    Route::get('/add/project', [ProjectsController::class, 'AddProject'])->name('add.project');
    Route::post('/project/store', [ProjectsController::class, 'ProjectStore'])->name('project.store');
    Route::get('/project/edit/{id}', [ProjectsController::class, 'ProjectEdit'])->name('project.edit');
    Route::post('/project/update/{id}', [ProjectsController::class, 'ProjectUpdate'])->name('project.update');
    Route::get('/project/approved/view', [ProjectsController::class, 'ProjectApprovedView'])->name('project.approved');
    Route::get('/project/sure/{id}', [ProjectsController::class, 'ProjectSure'])->name('project.sure');
    Route::get('/project/eye/{id}', [ProjectsController::class, 'ProjectEye'])->name('project.eye');
    Route::get('/project/reject/{id}', [ProjectsController::class, 'ProjectReject'])->name('project.reject');
    Route::get('/project/back', [ProjectsController::class, 'ProjectBack'])->name('project.back');

// End
});

require __DIR__.'/auth.php';
