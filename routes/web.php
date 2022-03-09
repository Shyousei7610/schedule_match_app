<?php

use App\Events\AddedMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MatchController;

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

Route::get('/home', [ScheduleController::class, 'indexHome'])
->middleware('verified')
->name('home');

Route::get('/signup', function () {
    return view('signup');
})->middleware('guest')
  ->name('signup');

Route::post('/signup', [SignupController::class, 'store']);

Route::get('/login', function () {
    return view('login');
})->middleware('guest')
  ->name('login');

Route::post('/login', [LoginController::class, 'authenticate']);

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

Route::get('/logout', [LoginController::class, 'logout'])
->middleware('auth')
->name('logout');

Route::get('/profile', function () {
    $user_id = Auth::id();
    $user_profile= \App\Models\User::find($user_id)->profile->toArray();

    $profile_introduction = current(array_column($user_profile, 'profile_introduction'));
    $profile_icon = current(array_column($user_profile, 'profile_icon'));
    $profile_header = current(array_column($user_profile, 'profile_header'));

    return view('profile', ['profile_introduction' => $profile_introduction, 'profile_icon' => $profile_icon, 'profile_header' => $profile_header]);
})->name('profile');

Route::post('/profile', [ProfileController::class, 'store']);

Route::get('/schedule/list', [ScheduleController::class, 'indexScheduleList'])
->middleware('auth')
->name('schedule.list');

Route::get('/schedule/register', [ScheduleController::class, 'indexScheduleRegister'])
->middleware('auth')
->name('schedule.register');

Route::post('/schedule/register', [ScheduleController::class, 'register']);

Route::delete('/schedule/delete', [ScheduleController::class, 'delete'])
->middleware('auth')
->name('schedule.delete');


Route::get('/match/search', [MatchController::class, 'match'])
->middleware('auth')
->name('match.match');

Route::get('/match/result', [MatchController::class, 'indexResult'])
->middleware('auth')
->name('match.result');

Route::post('/match/apply', [MatchController::class, 'apply'])
->middleware('auth')
->name('match.apply');

Route::get('/message/{identifier}', [ChatController::class, 'index'])
->middleware('auth');

Route::post('/message/{identifier}', [ChatController::class, 'register'])
->middleware('auth');


Route::get('/tasks', function () {
    $task = ['id' => 1, 'name' => 'メールの確認'];
    event(new AddedMessage($task));
});
