<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('login');
// });

Route::redirect('/', '/login');


Route::group(['middleware' => ['no-cache']], function () {
    // Routes that should not be cached after logout
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/generate-approval-note', [App\Http\Controllers\GenerateApprovalNote::class, 'index'])->name('generate-approval-note');
    Route::get('/generate-approval-note', [App\Http\Controllers\GenerateApprovalNote::class, 'getUser'])->name('generate-approval-note');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'getUser'])->name('profile');
    // Route::post('/store-approval-data', [App\Http\Controllers\GenerateApprovalNote::class, 'storeApprovalData']);
    Route::post('/store-approval-data', [App\Http\Controllers\GenerateApprovalNote::class, 'storeApprovalData'])->name('store-approval-data');
    Route::get('/sent-request', [App\Http\Controllers\SentRequestController::class, 'index']);
    Route::get('/sent-request', [App\Http\Controllers\SentRequestController::class, 'getSentRequests'])->name('sent-request');
    Route::get('/received-request', [App\Http\Controllers\ReceivedRequestController::class, 'index']);
    Route::get('/pdf-approval-note/{id}', [App\Http\Controllers\PDFApprovalNoteController::class, 'generatePDFApprovalNote'])->name('pdf-approval-note');
    Route::get('/edit-approval-note/{id}', [App\Http\Controllers\SentRequestController::class, 'editApprovalNote'])->name('edit-approval-note');
    Route::post('/update-approval-note/{id}', [App\Http\Controllers\SentRequestController::class, 'updateApprovalNote']);
    Route::get('/delete-data/{id}', [App\Http\Controllers\SentRequestController::class, 'deleteData']);
    Route::get('/received-request', [App\Http\Controllers\ReceivedRequestController::class, 'getReceivedRequests'])->name('received-request');
    Route::get('/accept-approval-note/{id}', [App\Http\Controllers\ReceivedRequestController::class, 'acceptApprovalNote']);
    Route::get('/reject-approval-note/{id}', [App\Http\Controllers\ReceivedRequestController::class, 'rejectApprovalNote']);
    Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update-password');

    Route::get('/edit-bill/{id}', [App\Http\Controllers\SentRequestController::class, 'editBill'])->name('edit-bill');
    Route::get('/delete-bill/{id}', [App\Http\Controllers\SentRequestController::class, 'deleteBill']);
    Route::post('/update-bill/{id}', [App\Http\Controllers\SentRequestController::class, 'updateBill']);

    Route::get('/received-bill-request', [App\Http\Controllers\ReceivedBillRequestController::class, 'index']);

    Route::get('/received-bill-request', [App\Http\Controllers\ReceivedBillRequestController::class, 'getReceivedBillRequests'])->name('received-bill-request');

    Route::get('/pdf-bill-approval-note/{id}', [App\Http\Controllers\PDFBillApprovalNoteController::class, 'generatePDFBillApprovalNote'])->name('pdf-bill-approval-note');

    Route::get('/accept-bill-approval-note/{id}', [App\Http\Controllers\ReceivedBillRequestController::class, 'acceptBillApprovalNote']);

    Route::get('/reject-bill-approval-note/{id}', [App\Http\Controllers\ReceivedBillRequestController::class, 'rejectBillApprovalNote']);

    Route::get('/user-management', [App\Http\Controllers\ProfileController::class, 'userManagement'])->name('user-management');
    Route::get('/department-management', [App\Http\Controllers\ProfileController::class, 'departmentManagement'])->name('department-management');
    Route::get('/company-management', [App\Http\Controllers\ProfileController::class, 'companyManagement'])->name('company-management');

    Route::post('/add-department', [App\Http\Controllers\ProfileController::class, 'addDepartment']);


    Route::get('/bill-approval', [App\Http\Controllers\BillApprovalController::class, 'index'])->name('bill-approval');
    Route::get('/bill-approval', [App\Http\Controllers\BillApprovalController::class, 'getUserCompany'])->name('bill-approval');
    Route::post('/store-bill-approval-data', [App\Http\Controllers\BillApprovalController::class, 'storeBillApprovalData'])->name('store-bill-approval-data');
    Auth::routes();
});

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'getCompany'])->name('register');








// Route::get('/generate-approval-note', [App\Http\Controllers\GenerateApprovalNote::class, 'getCompany'])->name('generate-approval-note');









// Route to update the approval note before the confirmation from any user





// Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showChangePasswordForm'])->name('profile');

// Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile');
