<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('document.send');
});

Route::get('/sendDocument', [DocumentController::class, 'showSendDocumentForm'])->name('sendDocumentForm');
Route::post('/sendDocument', [DocumentController::class, 'sendDocument'])->name('sendDocument');

Route::get('/listDocument', [DocumentController::class, 'listDocument'])->name('list-documents');

Route::get('/download-pdf',         [DocumentController::class, 'downloadPdf'])->name('download-pdf');
Route::post('/revokeDocument',       [DocumentController::class, 'revokeDocument']);
Route::post('/sendRemind',          [DocumentController::class, 'sendRemind']);
Route::post('/extendExpiry',         [DocumentController::class, 'extendExpiry']);

Route::get('/behalfList',         [DocumentController::class, 'behalfList'])->name('behalfList');

Route::get('/embeddedSigningLink/{documentId}/{email}', [DocumentController::class, 'embeddedSigningLink'])->name('generate-link');

//Identity
Route::get('/createIdentityForm', [DocumentController::class, 'createIdentityForm'])->name('createIdentityForm');
Route::post('/createIdentity',       [DocumentController::class, 'createIdentity'])->name('create-identity');
Route::get('/listIdentity',         [DocumentController::class, 'listIdentity'])->name('list-identity');
Route::delete('/deleteIdentity/{email}', [DocumentController::class, 'deleteIdentity'])->name('deleteIdentity');

Route::get('/download-audittrail',  [DocumentController::class, 'downloadAudittrail'])->name('download-audittrail');
Route::get('/apiCreditsCount',       [DocumentController::class, 'apiCreditsCount']);

