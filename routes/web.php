<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FriendListController;


Route::get('/', ['as' => 'login', function () {
    return view('login');
}]);

Route::get('/register', function () {
    return view('register');
});

Route::get('/otp-check', function () {
    return view('checkotp');
});

Route::post('/user-registration', [LoginController::class, 'userRegistration']);

Route::get('/resend-otp', [LoginController::class, 'resendOtp']);

Route::post('/check-otp', [LoginController::class, 'checkOtp']);

Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/friend-list', [FriendListController::class, 'friendList'])->middleware('auth');

Route::post('/remove-friend', [FriendListController::class, 'removeFriend'])->middleware('auth');
Route::post('/searchby-name', [FriendListController::class, 'searchbyName'])->middleware('auth');

Route::get('/invite-friends', function () {
    return view('invitefriends');
});

Route::post('/send-request', [FriendListController::class, 'sendRequest']);

Route::get('/make-friends/{user_id}/{friend_id}', [FriendListController::class, 'inviteFriends'])->name('make.friend');

Route::post('/confirm-invitation', [FriendListController::class, 'confirmInvitation']);

Route::post('/accept-invitation', [FriendListController::class, 'acceptInvitation']);

Route::get('/forgot-password', function () {
    return view('forgotpassword');
})->middleware('auth');

Route::post('/send-password-links', [LoginController::class, 'sendPasswordLink'])->middleware('auth');

Route::get('/update-password/{id}', [LoginController::class, 'updatePassword'])->name('reset.password')->middleware('auth');

Route::post('/create-new-password', [LoginController::class, 'createNewPassword'])->middleware('auth');
