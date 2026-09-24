<?php

use App\Http\Controllers\BillingCycleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('plans', PlanController::class);
    Route::resource('subscribers', SubscriberController::class);
    Route::resource('billing-cycles', BillingCycleController::class);
    Route::patch('/billing-cycles/{billingCycle}/mark-as-paid', [BillingCycleController::class, 'markAsPaid'])->name('billing-cycles.mark-as-paid');
    Route::get('/insights', [\App\Http\Controllers\InsightController::class, 'index'])->name('insights.index');
    Route::get('/settings', function () {
    return view('settings.index');
})->name('settings.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';