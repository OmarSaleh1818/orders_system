<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\ApplicantControllar;
use App\Http\Controllers\Setting\SectionsController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Setting\ProjectsController;
use App\Http\Controllers\Employee\ApplicantManagerController;
use App\Http\Controllers\Employee\FinanceManagerController;
use App\Http\Controllers\Employee\FinanceController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', [DashboardController::class, 'Dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// All Applicant route
    Route::prefix('applicant')->group(function() {
        Route::get('/view', [ApplicantControllar::class, 'applicantView'])->name('applicant.view');
        Route::get('/add/order', [ApplicantControllar::class, 'addOrder'])->name('add.order');
        Route::post('/store', [ApplicantControllar::class, 'ApplicantStore'])->name('applicant.store');
        Route::get('/edit/{id}', [ApplicantControllar::class, 'ApplicantEdit'])->name('applicant.edit');
        Route::post('/update/{id}', [ApplicantControllar::class, 'ApplicantUpdate'])->name('applicant.update');
        Route::get('/delete/{id}', [ApplicantControllar::class, 'applicantDelete'])->name('applicant.delete');
        Route::get('/applicant/eye/{id}', [ApplicantControllar::class, 'ApplicantEye'])->name('applicant.eye');
        Route::get('/back', [ApplicantControllar::class, 'applicantBack'])->name('applicant.back');
        Route::post('/reply/inquiry/{id}', [ApplicantControllar::class, 'ApplicantReplyInquiry'])->name('applicant.reply.inquiry');
        Route::post('/return/date/{id}', [ApplicantControllar::class, 'ApplicantReturnDate'])->name('applicant.return.date');
    });
    Route::get('/get-section-name/{project_id}', [ApplicantControllar::class, 'getSectionName']);
    Route::get('/get-step-names/{project_id}', [ApplicantControllar::class, 'getStepNames']);
    Route::get('/get-item-names/{step_name}', [ApplicantControllar::class, 'getItemNames']);
    Route::get('/get-item-value/{itemName}', [ApplicantControllar::class, 'getItemValue']);
    Route::get('/get-remaining-value/{itemName}', [ApplicantControllar::class, 'getRemainingValue']);

// End

// All Applicant Manager Route
    Route::prefix('manager')->group(function() {
        Route::get('/applicant/view', [ApplicantManagerController::class, 'applicantManagerView'])->name('applicant.manager.view');
        Route::get('/applicant/eye/{id}', [ApplicantManagerController::class, 'ApplicantManagerEye'])->name('applicant.manager.eye');
        Route::get('/applicant/sure/{id}', [ApplicantManagerController::class, 'ApplicantManagerSure'])->name('applicant.manager.sure');
        Route::post('/applicant/reject/{id}', [ApplicantManagerController::class, 'ApplicantManagerReject'])->name('applicant.manager.reject');
        Route::get('/applicant/back', [ApplicantManagerController::class, 'ApplicantManagerBack'])->name('applicant.manager.back');
        Route::get('/project/view', [ProjectsController::class, 'ProjectView'])->name('project.view');
        Route::get('/add/project', [ProjectsController::class, 'AddProject'])->name('add.project');

        Route::post('/project/store', [ProjectsController::class, 'ProjectStore'])->name('project.store');
        Route::get('/project/edit/{id}', [ProjectsController::class, 'ProjectEdit'])->name('project.edit');
        Route::post('/project/update/{id}', [ProjectsController::class, 'ProjectUpdate'])->name('project.update');
        Route::get('/project/eye/{id}', [ProjectsController::class, 'ProjectEye'])->name('project.eye');
        Route::get('/back', [ProjectsController::class, 'Back'])->name('back');
    });
    Route::get('/get-users-by-section', [ProjectsController::class, 'getUsersBySection']);
// End

// All Finance Manager Route
    Route::get('/finance/manager/view', [FinanceManagerController::class, 'FinanceManagerView'])->name('finance.manager.view');
    Route::get('/finance/manager/eye/{id}', [FinanceManagerController::class, 'FinanceManagerEye'])->name('finance.manager.eye');
    Route::post('/finance/manager/inquiry/{id}', [FinanceManagerController::class, 'FinanceManagerInquiry'])->name('finance.manager.inquiry');
    Route::get('/finance/manager/back', [FinanceManagerController::class, 'FinanceManagerBack'])->name('finance.manager.back');
    Route::post('/proposed/date/{id}', [FinanceManagerController::class, 'ProposedDate'])->name('proposed.date');
    Route::post('/finance/manager/reject/{id}', [FinanceManagerController::class, 'FinanceManagerReject'])->name('finance.manager.reject');
    Route::get('/finance/manager/sure/{id}', [FinanceManagerController::class, 'FinanceManagerSure'])->name('finance.manager.sure');

// End

// All Finance Manager Route
    Route::prefix('finance')->group(function() {
        Route::get('/view', [FinanceController::class, 'FinanceView'])->name('finance.view');
        Route::get('/eye/{id}', [FinanceController::class, 'FinanceEye'])->name('finance.eye');
        Route::get('/back', [FinanceController::class, 'FinanceBack'])->name('finance.back');
        Route::post('/attachment/{id}', [FinanceController::class, 'FinanceAttachment'])->name('finance.attachment');
    });
// End

// All Users Route
    Route::prefix('users')->group(function() {
//        Route::get('/view', [RegisteredUserController::class, 'create'])->name('users');
//        Route::get('/create', [RegisteredUserController::class, 'UsersCreate'])->name('users_create');
//        Route::post('/store', [RegisteredUserController::class, 'UsersStore'])->name('users.store');
        // All Section Route
        Route::get('/section/view', [SectionsController::class, 'SectionView'])->name('sections');
        Route::post('/section/store', [SectionsController::class, 'SectionStore'])->name('section.store');
        Route::get('/section/edit/{id}', [SectionsController::class, 'SectionEdit'])->name('section.edit');
        Route::post('/section/update/{id}', [SectionsController::class, 'SectionUpdate'])->name('section.update');
        Route::get('/section/delete/{id}', [SectionsController::class, 'SectionDelete'])->name('section.delete');
        // End
    });
// End

// All Project Route
    Route::get('/project/approved/view', [ProjectsController::class, 'ProjectApprovedView'])->name('project.approved');
    Route::get('/project/sure/{id}', [ProjectsController::class, 'ProjectSure'])->name('project.sure');
    Route::post('/project/reject/{id}', [ProjectsController::class, 'ProjectReject'])->name('project.reject');
    Route::get('/project/back', [ProjectsController::class, 'ProjectBack'])->name('project.back');
    Route::get('/project/manager/eye/{id}', [ProjectsController::class, 'ProjectManagerEye'])->name('project.manager.eye');
    Route::post('/project/update/manager/{id}', [ProjectsController::class, 'ProjectUpdateManager'])->name('project.update.manager');
// End
});
Route::get('/reload-captcha', [ApplicantControllar::class, 'ReloadCaptcha']);

Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles',RoleController::class);

    Route::resource('users', UserController::class);

});

require __DIR__.'/auth.php';
