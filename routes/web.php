<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('homepage');

// Route::get('/questions', [QuestionsController::class, 'questions'])->name('questions');
Route::post('/answer', [QuestionsController::class, 'answer'])->name('answer');
Route::get('/next-question/{question_id}', [QuestionsController::class, 'nextQuestion'])->name('next-question');
Route::get('/retry-question/{question_id}', [QuestionsController::class, 'retryQuestion'])->name('retry-question');

// questions page
Route::get('/{course}/{exam}', [QuestionsController::class, 'questions'])->name('exam-questions');
