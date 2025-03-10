<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\MailResponseController;
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
    return Inertia::render('WelcomePage', [
        'canLogin' => Route::has('login'),
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('DashboardPage');
    })->name('dashboard');

    Route::get('/donations/{year?}', [DonationController::class, 'index'])->name('donations');
    Route::get('/donation/create', [DonationController::class, 'create'])->name('donation.create');
    Route::post('/donation/store', [DonationController::class, 'store'])->name('donation.store');
    Route::delete('/donation/{donation}', [DonationController::class, 'destroy'])->name('donation.destroy');
});

/*
 * Webhooks for Mailgun
*/
Route::post('mailgun/complained', [MailResponseController::class, 'complained'])->name('mailgun.complained');
Route::post('mailgun/unsubscribed', [MailResponseController::class, 'unsubscribed'])->name('mailgun.unsubscribed');
Route::post('mailgun/fail', [MailResponseController::class, 'fail'])->name('mailgun.fail');


Route::put('/report/{report}', [ReportController::class, 'update'])->name('report-update');
Route::put('/report/publisher/{report}', [ReportController::class, 'updatePublisher'])->name('report-update-publisher');
Route::put('/report/send-email/{report}', [ReportController::class, 'sendEmail'])->name('report-send-email');

Route::middleware(['signed', 'locale'])->group(function () {
    Route::get('/service-group-reports/{locale}/{serviceGroup}', [ServiceGroupReportController::class, 'show'])->name('service-group-reports');
    Route::get('/publisher-report/{locale}/{report}', [ReportController::class, 'show'])->name('publisher-report');
});
