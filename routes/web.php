<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\ScheduleController::class, 'indexHome'])
->middleware('verified')
->name('home');

Route::get('/signup', function () {
    return view('signup');
})->middleware('guest')
  ->name('signup');

Route::post('/signup', [App\Http\Controllers\SignupController::class, 'store']);

Route::get('/login', function () {
    return view('login');
})->middleware('guest')
  ->name('login');

Route::post('/login', [App\Http\Controllers\LoginController::class, 'authenticate']);

Route::get('/email/verify', function () {
    return view('verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
   $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])
->middleware('auth')
->name('logout');

Route::get('/profile', function () {
    $user_id = Auth::id();
    $user_profile= \App\Models\User::find($user_id)->profile->toArray();

    $profile_introduction = current(array_column($user_profile, 'profile_introduction'));
    $profile_icon = current(array_column($user_profile, 'profile_icon'));
    $profile_header = current(array_column($user_profile, 'profile_header'));

    return view('profile', ['profile_introduction' => $profile_introduction, 'profile_icon' => $profile_icon, 'profile_header' => $profile_header]);
});

Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'store']);

Route::get('/schedule', [App\Http\Controllers\ScheduleController::class, 'indexSchedule'])
->middleware('auth')
->name('schedule');

Route::get('/register', function () {
    return view('register');
})->middleware('auth')
->name('register');


Route::delete('/schedule/delete', [App\Http\Controllers\ScheduleController::class, 'deleted'])
->middleware('auth')
->name('schedule.delete');


Route::post('/register', [App\Http\Controllers\ScheduleController::class, 'register']);


