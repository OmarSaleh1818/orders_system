<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Setting\OpenPrejectController;
use App\Http\Controllers\Setting\StartProjectControler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\ApplicantControllar;
use App\Http\Controllers\Setting\SectionsController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Setting\ProjectsController;
use App\Http\Controllers\Setting\InvoicesController;
use App\Http\Controllers\Setting\BalanceController;
use App\Http\Controllers\Employee\ApplicantManagerController;
use App\Http\Controllers\Employee\FinanceManagerController;
use App\Http\Controllers\Employee\FinanceController;
use App\Http\Controllers\Setting\PdfController;
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
Route::get('/dashboard', [DashboardController::class, 'Dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// All Applicant route
    Route::prefix('applicant')->group(function() {
        Route::get('/view', [ApplicantControllar::class, 'applicantView'])->name('applicant.view');
        Route::get('/add/order', [ApplicantControllar::class, 'addOrder'])->name('add.order');
        Route::post('/store', [ApplicantControllar::class, 'ApplicantStore'])->name('applicant.store');
        Route::post('/international/store', [ApplicantControllar::class, 'ApplicantInternationalStore'])->name('applicant.international.store');
        Route::get('/edit/{id}', [ApplicantControllar::class, 'ApplicantEdit'])->name('applicant.edit');
        Route::post('/update/{id}', [ApplicantControllar::class, 'ApplicantUpdate'])->name('applicant.update');
        Route::get('/delete/{id}', [ApplicantControllar::class, 'applicantDelete'])->name('applicant.delete');
        Route::get('/applicant/eye/{id}', [ApplicantControllar::class, 'ApplicantEye'])->name('applicant.eye');
        Route::get('/back', [ApplicantControllar::class, 'applicantBack'])->name('applicant.back');
        Route::post('/reply/inquiry/{id}', [ApplicantControllar::class, 'ApplicantReplyInquiry'])->name('applicant.reply.inquiry');
        Route::post('/return/date/{id}', [ApplicantControllar::class, 'ApplicantReturnDate'])->name('applicant.return.date');
    });
    Route::get('/get-order-number/{project_id}', [ApplicantControllar::class, 'getOrderNumber']);
    Route::get('/get-last-order-number/{project_id}', [ApplicantControllar::class, 'getLastOrderNumber']);
    Route::get('/get-section-name/{project_id}', [ApplicantControllar::class, 'getSectionName']);
    Route::get('/get-step-names/{project_id}', [ApplicantControllar::class, 'getStepNames']);
    Route::get('/get-item-names/{step_name}', [ApplicantControllar::class, 'getItemNames']);
    Route::get('/get-item-value/{itemName}', [ApplicantControllar::class, 'getItemValue']);
    Route::get('/get-remaining-value/{itemName}', [ApplicantControllar::class, 'getRemainingValue']);
    Route::get('/applicants/filter', [ApplicantControllar::class, 'filterApplicants'])->name('applicants.filter');


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
        Route::get('/project/repeat/{id}', [ProjectsController::class, 'ProjectRepeat'])->name('project.repeat');
        Route::get('/project/pdf/{id}', [PdfController::class, 'ProjectPdf'])->name('project.pdf');
    });
    Route::get('/get-users-by-section', [ProjectsController::class, 'getUsersBySection']);
// End
    Route::get('/projects/filter', [ProjectsController::class, 'filterProjects'])->name('projects.filter');


// All Finance Manager Route
    Route::get('/finance/manager/view', [FinanceManagerController::class, 'FinanceManagerView'])->name('finance.manager.view');
    Route::get('/finance/manager/eye/{id}', [FinanceManagerController::class, 'FinanceManagerEye'])->name('finance.manager.eye');
    Route::post('/finance/manager/inquiry/{id}', [FinanceManagerController::class, 'FinanceManagerInquiry'])->name('finance.manager.inquiry');
    Route::get('/finance/manager/back', [FinanceManagerController::class, 'FinanceManagerBack'])->name('finance.manager.back');
    Route::post('/proposed/date/{id}', [FinanceManagerController::class, 'ProposedDate'])->name('proposed.date');
    Route::post('/finance/manager/reject/{id}', [FinanceManagerController::class, 'FinanceManagerReject'])->name('finance.manager.reject');
    Route::get('/finance/manager/sure/{id}', [FinanceManagerController::class, 'FinanceManagerSure'])->name('finance.manager.sure');
    Route::get('/finance/order/sure/{id}', [FinanceManagerController::class, 'FinanceOrderSure'])->name('finance.order.sure');

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
        Route::get('/section/view', [SectionsController::class, 'SectionView'])->name('sections');
        Route::post('/section/store', [SectionsController::class, 'SectionStore'])->name('section.store');
        Route::get('/section/edit/{id}', [SectionsController::class, 'SectionEdit'])->name('section.edit');
        Route::post('/section/update/{id}', [SectionsController::class, 'SectionUpdate'])->name('section.update');
        Route::get('/section/delete/{id}', [SectionsController::class, 'SectionDelete'])->name('section.delete');
    });
// End

// All Project Route
    Route::prefix('project')->group(function() {
        Route::get('/open/view', [OpenPrejectController::class, 'ProjectOpenView'])->name('project.open');
        Route::get('/add/project/open/{id}', [OpenPrejectController::class, 'AddProjectOpen'])->name('add.project.open');
        Route::post('/open/store/{id}', [OpenPrejectController::class, 'ProjectOpenStore'])->name('project.open.store');
        Route::get('/sure/{id}', [ProjectsController::class, 'ProjectSure'])->name('project.sure');
        Route::get('/price/sure/{id}', [ProjectsController::class, 'PriceSure'])->name('price.sure');
        Route::post('/reject/{id}', [ProjectsController::class, 'ProjectReject'])->name('project.reject');
        Route::get('/back', [ProjectsController::class, 'ProjectBack'])->name('project.back');
        Route::get('/manager/eye/{id}', [OpenPrejectController::class, 'ProjectManagerEye'])->name('project.manager.eye');
        Route::get('/open/project/sure/{id}', [OpenPrejectController::class, 'OpenProjectSure'])->name('open.project.sure');
        Route::get('/open/project/Manager/sure/{id}', [OpenPrejectController::class, 'OpenProjectManagerSure'])->name('open.projectManager.sure');
        Route::get('/open/project/back', [OpenPrejectController::class, 'OpenProjectBack'])->name('open.project.back');
        Route::post('/open/project/reject/{id}', [OpenPrejectController::class, 'OpenProjectReject'])->name('open.project.reject');
        Route::get('/open/project/edit/{id}', [OpenPrejectController::class, 'OpenProjectEdit'])->name('open.project.edit');
        Route::post('/open/project/update/{id}', [OpenPrejectController::class, 'OpenProjectUpdate'])->name('project.open.update');
        Route::post('/update/manager/{id}', [ProjectsController::class, 'ProjectUpdateManager'])->name('project.update.manager');

        Route::get('/add/project/start/{id}', [StartProjectControler::class, 'AddProjectStart'])->name('add.project.start');
        Route::post('/start/store/{id}', [StartProjectControler::class, 'ProjectStartStore'])->name('project.start.store');
        Route::get('/approved/eye/{id}', [StartProjectControler::class, 'ProjectApprovedEye'])->name('project.approved.eye');
        Route::post('/approved/reject/{id}', [StartProjectControler::class, 'ProjectApprovedReject'])->name('project.approved.reject');
        Route::get('/approved/edit/{id}', [StartProjectControler::class, 'ProjectApprovedEdit'])->name('project.approved.edit');
        Route::post('/approved/update/{id}', [StartProjectControler::class, 'ProjectApprovedUpdate'])->name('project.approved.update');
        Route::get('/approved/sure/{id}', [StartProjectControler::class, 'ProjectApprovedSure'])->name('project.approved.sure');
        Route::get('/approved/Manager/sure/{id}', [StartProjectControler::class, 'ProjectApprovedManagerSure'])->name('project.approvedManager.sure');
    });
// End
    Route::get('/open-projects/filter', [OpenPrejectController::class, 'filterBySection'])->name('filter.open.project');
// All invoices route
    Route::get('/invoices/view', [InvoicesController::class, 'InvoicesView'])->name('invoices.view');
    Route::get('/invoices/eye/{id}', [InvoicesController::class, 'InvoicesEye'])->name('invoices.eye');
    Route::get('/invoices/back', [InvoicesController::class, 'InvoicesBack'])->name('invoices.back');
    Route::get('/invoices/add', [InvoicesController::class, 'InvoicesAdd'])->name('invoices.add');
    Route::post('/invoices/store', [InvoicesController::class, 'InvoicesStore'])->name('invoices.store');
    Route::get('/invoices/sure/{id}', [InvoicesController::class, 'InvoicesSure'])->name('invoices.sure');
    Route::post('/invoices/reject/{id}', [InvoicesController::class, 'InvoicesReject'])->name('invoices.reject');
    Route::get('/invoices/edit/{id}', [InvoicesController::class, 'InvoicesEdit'])->name('invoices.edit');
    Route::post('/invoices/update/{id}', [InvoicesController::class, 'InvoicesUpdate'])->name('invoices.update');
    Route::get('/invoices/manager/sure/{id}', [InvoicesController::class, 'InvoicesManagerSure'])->name('invoices.manager.sure');
    Route::post('/invoices/attachment/{id}', [InvoicesController::class, 'InvoicesAttachment'])->name('invoices.attachment');
    Route::get('/invoices/filter', [InvoicesController::class, 'filterInvoicesBySection'])->name('filter.invoices');

// End

    // All balance Route
    Route::prefix('balance')->group(function() {
        Route::get('/setting/view', [BalanceController::class, 'BalanceSettingView'])->name('balance.setting');
        Route::get('/add/year', [BalanceController::class, 'AddYear'])->name('add.year');
        Route::post('/year/store', [BalanceController::class, 'BalanceYearStore'])->name('balance.year.store');
        Route::get('/year/eye/{id}', [BalanceController::class, 'BalanceYearEye'])->name('balance.year.eye');
        Route::get('/back', [BalanceController::class, 'BalanceBack'])->name('balance.back');
        Route::get('/year/edit/{id}', [BalanceController::class, 'BalanceYearEdit'])->name('balance.year.edit');
        Route::post('/year/update/{id}', [BalanceController::class, 'BalanceYearUpdate'])->name('balance.year.update');

        Route::get('/project/view', [BalanceController::class, 'BalanceProjectView'])->name('balance.project');

        Route::get('/public/view', [BalanceController::class, 'BalancePublicView'])->name('balance.public');
    });
// End
});
Route::get('/reload-captcha', [ApplicantControllar::class, 'ReloadCaptcha']);

Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles',RoleController::class);

    Route::resource('users', UserController::class);

});

require __DIR__.'/auth.php';
