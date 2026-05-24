<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Home
Route::get('/', function () { return view('home'); })->name('home');

// Signup
Route::get('/signup', [AuthController::class,'signupForm'])->name('signup');
Route::post('/signup', [AuthController::class,'signup'])->name('signup.post');

// Login
Route::post('/login', [AuthController::class,'login'])->name('login');

// Dashboard
Route::get('/dashboard', [AuthController::class,'dashboard'])->name('dashboard');
Route::post('/dashboard', [AuthController::class,'handlePost']);

// Logout
Route::get('/logout', [AuthController::class,'logout'])->name('logout');

// Delete
Route::post('/delete-post', [AuthController::class,'deletePost'])->name('delete.post');
Route::post('/delete-comment', [AuthController::class,'deleteComment'])->name('delete.comment');

// Courses
Route::get('/course', [AuthController::class,'course'])->name('course');

// HTML Course & Quiz
Route::get('/html-course', [AuthController::class,'htmlCourse'])->name('html.course');
Route::get('/html-quiz', [AuthController::class,'htmlQuiz'])->name('html.quiz');

// Lesson 1
Route::post('/html-submit', [AuthController::class,'submitQuiz'])->name('html.submit');

// Lesson 2
Route::get('/lesson2-quiz', [AuthController::class,'lesson2Quiz'])->name('lesson2.quiz'); // show quiz page
Route::post('/lesson2-submit', [AuthController::class,'lesson2Submit'])->name('lesson2.submit'); // submit answers




