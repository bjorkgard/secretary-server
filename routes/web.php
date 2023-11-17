<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceGroupReportController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::put('/report/{report}', [ReportController::class, 'update'])->name('report.update');

Route::middleware(['signed', 'locale'])->group(function () {
    Route::get('/service-group-reports/{locale}/{serviceGroup}', [ServiceGroupReportController::class, 'show'])->name('service-group-reports');
    Route::get('/publisher-report/{locale}/{report}', [ReportController::class, 'show'])->name('publisher-report');
});
