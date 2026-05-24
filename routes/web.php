<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CppController;
use App\Http\Controllers\CController;
use App\Http\Controllers\HTMLController;
use App\Http\Controllers\JavaController;
use App\Http\Controllers\PythonController;

Route::get('/', fn () => view('home'))->name('home');

Route::controller(AuthController::class)->group(function () {
    Route::get('/signup', 'signupForm')->name('signup');
    Route::post('/signup', 'signup')->name('signup.post');
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/dashboard', 'handlePost')->name('handle.post');
    Route::get('/profile', 'profile')->name('profile');
    Route::post('/profile/upload', 'updateProfile')->name('profile.upload');
    Route::post('/profile/action', 'profileAction')->name('profile.action');
    Route::get('/course', 'course')->name('course');
    Route::delete('/post', 'deletePost')->name('post.delete');
    Route::delete('/comment', 'deleteComment')->name('comment.delete');
    Route::get('/c-course', 'cCourse')->name('c.course');
    Route::get('/cpp-course', 'cppCourse')->name('cpp.course');
    Route::get('/java-course', 'javaCourse')->name('java.course');
});

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::controller(CertificateController::class)->group(function () {
    Route::get('/certificates', 'show')->name('certificate.show');
    Route::get('/certificate/{certificateId}/download', 'download')->name('certificate.download');
    Route::get('/certificate/{certificateId}', 'displayCertificate')->name('certificate.view');
});

Route::controller(HTMLController::class)->group(function () {
    Route::get('/html-course', 'htmlCourse')->name('html.course');
    Route::get('/html-quiz', 'htmlQuiz')->name('html.quiz');
    Route::post('/html-submit', 'submitQuiz')->name('html.submit');
    Route::get('/lesson2-quiz', 'lesson2Quiz')->name('lesson2.quiz');
    Route::post('/lesson2-submit', 'lesson2Submit')->name('lesson2.submit');
    Route::get('/lesson3-quiz', 'lesson3Quiz')->name('lesson3.quiz');
    Route::post('/lesson3-submit', 'lesson3Submit')->name('lesson3.submit');
    Route::get('/lesson4-quiz', 'lesson4Quiz')->name('lesson4.quiz');
    Route::get('/lesson4-pass', 'lesson4Pass')->name('lesson4.pass');
    Route::get('/lesson5-quiz', 'lesson5Quiz')->name('lesson5.quiz');
    Route::post('/lesson5-submit', 'lesson5Submit')->name('lesson5.submit');
    Route::get('/lesson5-pass', 'lesson5Pass')->name('lesson5.pass');
    Route::get('/final-exam', 'finalExam')->name('final.exam');
    Route::post('/final-exam-submit', 'finalExamSubmit')->name('final.submit');
});

Route::controller(CController::class)->group(function () {
    Route::get('/c-course', 'index')->name('c.course');
    Route::get('/c-quiz', 'quiz')->name('c.quiz');
    Route::post('/c-submit', 'submitQuiz')->name('c.submit');
    Route::get('/c-lesson2-quiz', 'lesson2Quiz')->name('c.lesson2.quiz');
    Route::post('/c-lesson2-submit', 'lesson2Submit')->name('c.lesson2.submit');
    Route::get('/c-lesson3-quiz', 'lesson3Quiz')->name('c.lesson3.quiz');
    Route::post('/c-lesson3-submit', 'lesson3Submit')->name('c.lesson3.submit');
    Route::get('/c-lesson4-quiz', 'lesson4Quiz')->name('c.lesson4.quiz');
    Route::post('/c-lesson4-submit', 'lesson4Submit')->name('c.lesson4.submit');
    Route::get('/c-lesson5-quiz', 'lesson5Quiz')->name('c.lesson5.quiz');
    Route::post('/c-lesson5-submit', 'lesson5Submit')->name('c.lesson5.submit');
    Route::get('/c-final-exam', 'finalExam')->name('c.final.exam');
    Route::post('/c-final-submit', 'finalExamSubmit')->name('c.final.submit');
});

Route::controller(JavaController::class)->group(function () {
    Route::get('/java-quiz', 'javaQuiz')->name('java.quiz');
    Route::post('/java-submit', 'submitQuiz')->name('java.submit');
    Route::get('/java-lesson2-quiz', 'lesson2Quiz')->name('java.lesson2.quiz');
    Route::post('/java-lesson2-submit', 'lesson2Submit')->name('java.lesson2.submit');
    Route::get('/java-lesson3-quiz', 'lesson3Quiz')->name('java.lesson3.quiz');
    Route::post('/java-lesson3-submit', 'lesson3Submit')->name('java.lesson3.submit');
    Route::get('/java-lesson4-quiz', 'lesson4Quiz')->name('java.lesson4.quiz');
    Route::post('/java-lesson4-submit', 'lesson4Submit')->name('java.lesson4.submit');
    Route::get('/java-lesson5-quiz', 'lesson5Quiz')->name('java.lesson5.quiz');
    Route::post('/java-lesson5-submit', 'lesson5Submit')->name('java.lesson5.submit');
    Route::get('/java-final-exam', 'finalExam')->name('java.final.exam');
    Route::post('/java-final-submit', 'finalSubmit')->name('java.final.submit');
});

Route::controller(CppController::class)->group(function () {
    Route::get('/cpp-quiz', 'cppQuiz')->name('cpp.quiz');
    Route::post('/cpp-submit', 'submitQuiz')->name('cpp.submit');
    Route::get('/cpp-lesson2-quiz', 'lesson2Quiz')->name('cpp.lesson2.quiz');
    Route::post('/cpp-lesson2-submit', 'lesson2Submit')->name('cpp.lesson2.submit');
    Route::get('/cpp-lesson3-quiz', 'lesson3Quiz')->name('cpp.lesson3.quiz');
    Route::post('/cpp-lesson3-submit', 'lesson3Submit')->name('cpp.lesson3.submit');
    Route::get('/cpp-lesson4-quiz', 'lesson4Quiz')->name('cpp.lesson4.quiz');
    Route::post('/cpp-lesson4-submit', 'lesson4Submit')->name('cpp.lesson4.submit');
    Route::get('/cpp-lesson5-quiz', 'lesson5Quiz')->name('cpp.lesson5.quiz');
    Route::post('/cpp-lesson5-submit', 'lesson5Submit')->name('cpp.lesson5.submit');
    Route::get('/cpp-final-exam', 'finalExam')->name('cpp.final.exam');
    Route::post('/cpp-final-submit', 'finalSubmit')->name('cpp.final.submit');
});

Route::controller(PythonController::class)->group(function () {
    Route::get('/python-course', 'pythonCourse')->name('py.course');
    Route::get('/py-quiz', 'pyQuiz')->name('py.quiz');
    Route::post('/py-submit', 'pySubmit')->name('py.submit');
    Route::get('/py-lesson2-quiz', 'lesson2Quiz')->name('py.lesson2.quiz');
    Route::post('/py-lesson2-submit', 'lesson2Submit')->name('py.lesson2.submit');
    Route::get('/py-lesson3-quiz', 'lesson3Quiz')->name('py.lesson3.quiz');
    Route::post('/py-lesson3-submit', 'lesson3Submit')->name('py.lesson3.submit');
    Route::get('/py-lesson4-quiz', 'lesson4Quiz')->name('py.lesson4.quiz');
    Route::post('/py-lesson4-submit', 'lesson4Submit')->name('py.lesson4.submit');
    Route::get('/py-lesson5-quiz', 'lesson5Quiz')->name('py.lesson5.quiz');
    Route::post('/py-lesson5-submit', 'lesson5Submit')->name('py.lesson5.submit');
    Route::get('/py-final-exam', 'finalExam')->name('py.final.exam');
    Route::post('/py-final-submit', 'finalSubmit')->name('py.final.submit');
});
