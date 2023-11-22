<?php

use App\Http\Controllers\CongregationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceGroupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/congregation', [CongregationController::class, 'upsert'])->name('upsert.congregation');
    Route::delete('/congregation/{identifier}', [CongregationController::class, 'delete'])->name('delete.congregation');

    Route::post('/report', [ServiceGroupController::class, 'start'])->name('report.start');
    Route::post('/delete_report', [ServiceGroupController::class, 'close'])->name('report.close');
    Route::post('/send_reports', [ReportController::class, 'send_reports'])->name('report.send');
    Route::get('/reports/{identifier}', [ReportController::class, 'getUpdates'])->name('report.get-updates');
    Route::post('/reports/reset-updated', [ReportController::class, 'resetUpdated'])->name('report.reset-updated');
});
