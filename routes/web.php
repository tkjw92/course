<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CredController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// view
Route::get('/', [CredController::class, 'loginView'])->middleware('check:islogin');
Route::post('/', [CredController::class, 'login']);
Route::get('/register', [CredController::class, 'registerView']);
Route::get('/admin', [AdminController::class, 'getAllCourse'])->middleware('check:admin');
Route::get('/admin/course/{id}', [AdminController::class, 'manage'])->middleware('check:admin');
Route::get('/admin/quiz', [AdminController::class, 'quizView'])->middleware('check:admin');
Route::get('/student', [StudentController::class, 'index'])->middleware('check');
Route::get('/student/course/{id_course}', [StudentController::class, 'course'])->middleware('check');
Route::get('/student/course/{id_course}/{id_subtopic}', [StudentController::class, 'course'])->middleware('check');
Route::get('/student/quiz/{id}', [QuizController::class, 'view'])->middleware('check');
Route::get('/admin/certificate', [AdminController::class, 'certificateView'])->middleware('check:admin');

Route::post('/student/quiz/{id}', [QuizController::class, 'inputChoice'])->middleware('check');
Route::get('/student/quiz/{id}/score', [QuizController::class, 'score'])->middleware('check');

// add
Route::post('/admin', [AdminController::class, 'addCourse'])->middleware('check:admin');
Route::post('/admin/course', [AdminController::class, 'addTopic'])->middleware('check:admin');
Route::post('/admin/course/topic', [AdminController::class, 'addSubtopic'])->middleware('check:admin');
ROute::post('/admin/quiz/soal/add', [AdminController::class, 'addSoal'])->middleware('check:admin');
Route::post('/admin/quiz/add', [AdminController::class, 'addQuiz'])->middleware('check:admin');
Route::post('/register', [CredController::class, 'register']);
Route::post('/admin/certificate', [AdminController::class, 'addCertificateApi'])->middleware('check:admin');

// delete
Route::get('/admin/delete/{id}', [AdminController::class, 'deleteCourse'])->middleware('check:admin');
Route::get('/admin/course/delete/{id}', [AdminController::class, 'deleteTopic'])->middleware('check:admin');
Route::get('/admin/course/subtopic/delete/{id}', [AdminController::class, 'deleteSubtopic'])->middleware('check:admin');
Route::get('/admin/quiz/delete/soal/{id}', [AdminController::class, 'deleteSoal'])->middleware('check:admin');
Route::get('/admin/quiz/delete/{id}', [AdminController::class, 'deleteQuiz'])->middleware('check:admin');
Route::get('/admin/certificate/delete/{id}', [AdminController::class, 'deleteCertificateApi'])->middleware('check:admin');

// edit
Route::post('/admin/edit/{id}', [AdminController::class, 'editCourse'])->middleware('check:admin');
Route::post('/admin/course/edit/{id}', [AdminController::class, 'editTopic'])->middleware('check:admin');
Route::get('/admin/course/subtopic/edit/{id}', [AdminController::class, 'editContentView'])->middleware('check:admin');
Route::post('/admin/course/subtopic/edit/{id}', [AdminController::class, 'editContent'])->middleware('check:admin');
Route::get('/admin/quiz/edit/{id}', [AdminController::class, 'editQuizView'])->middleware('check:admin');
Route::post('/admin/quiz/soal/edit', [AdminController::class, 'editSoal'])->middleware('check:admin');
Route::post('/admin/quiz/update', [AdminController::class, 'updateQuiz'])->middleware('check:admin');
Route::post('/admin/certificate/update', [AdminController::class, 'updateCertificateApi'])->middleware('check:admin');

Route::get('/logout', function () {
    session()->flush();
    return redirect('/');
});

Route::get('/debug', function (Request $data) {
    dd(
        DB::table('account')->where('email', session('account')['email'])->first()->id
    );
});
