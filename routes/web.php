<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\SetSelection\AdminPersonController;
use App\Http\Controllers\SetSelection\CandidateController;
use App\Http\Controllers\SetSelection\PartiesConroller;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::resource('candidates', CandidateController::class);
    Route::resource('parties', PartiesConroller::class);
    Route::resource('people', AdminPersonController::class);
});

Route::get('/', [VoteController::class, 'main'])->name('vote.main');
Route::get('/vote', [VoteController::class, 'index'])->name('vote.index');

Route::post('/auth-voter', [VoteController::class, 'authenticate'])->name('vote.authenticate');
Route::get('/public-key', [VoteController::class, 'getPublicKey'])->name('vote.getPublicKey');

Route::post('/submit-vote', [VoteController::class, 'submit'])->name('vote.submit');
Route::get('/summary', [SummaryController::class, 'index'])->name('summary.index');
Route::get('/summary/data', [SummaryController::class, 'data'])->name('summary.data');