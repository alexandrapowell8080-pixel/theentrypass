<?php

use App\Http\Controllers\Admin\QuestionAdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionsController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if ($user && Hash::check($credentials['password'], $user->password)) {
        if ($user->id !== 2) {
            return back()->with('error', 'Admin access required.');
        }

        $request->session()->put('user_id', $user->id);
        $request->session()->put('role', 'admin');
        $request->session()->put('user_name', $user->name);

        return redirect()->route('admin.questions.index');
    }

    return back()->with('error', 'Invalid credentials.');
})->name('admin.login.submit');

Route::post('/admin/logout', function (Request $request) {
    $request->session()->forget(['user_id', 'role', 'user_name']);

    return redirect('/');
})->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/questions', [QuestionAdminController::class, 'index'])->name('questions.index');
    Route::get('/questions/create', [QuestionAdminController::class, 'create'])->name('questions.create');
    Route::get('/questions/{question}/edit', [QuestionAdminController::class, 'edit'])->name('questions.edit');
    Route::post('/questions', [QuestionAdminController::class, 'store'])->name('questions.store');
    Route::put('/questions/{question}', [QuestionAdminController::class, 'update'])->name('questions.update');
    Route::patch('/questions/{question}', [QuestionAdminController::class, 'update'])->name('questions.update.patch');
    Route::delete('/questions/{question}', [QuestionAdminController::class, 'destroy'])->name('questions.destroy');
});

Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::post('/answer', [QuestionsController::class, 'answer'])->name('answer');
Route::get('/next-question/{question_id}', [QuestionsController::class, 'nextQuestion'])->name('next-question');
Route::get('/retry-question/{question_id}', [QuestionsController::class, 'retryQuestion'])->name('retry-question');
Route::get('/{course}/{exam}', [QuestionsController::class, 'questions'])->name('exam-questions');
