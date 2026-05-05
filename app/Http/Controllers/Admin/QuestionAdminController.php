<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionAdminController extends Controller
{
    public function index(Request $request)
    {
        $examId = $request->get('exam_id');
        $search = trim((string) $request->get('search', ''));

        $exams = Exam::orderBy('name')->get();

        $questions = Questions::query()
            ->with('exam')
            ->when($examId, fn ($q) => $q->where('exam_id', $examId))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('question', 'like', "%{$search}%")
                        ->orWhere('optionA', 'like', "%{$search}%")
                        ->orWhere('optionB', 'like', "%{$search}%")
                        ->orWhere('optionC', 'like', "%{$search}%")
                        ->orWhere('optionD', 'like', "%{$search}%")
                        ->orWhere('optionE', 'like', "%{$search}%")
                        ->orWhere('optionF', 'like', "%{$search}%")
                        ->orWhere('optionG', 'like', "%{$search}%")
                        ->orWhere('correct_answer', 'like', "%{$search}%")
                        ->orWhere('rationale', 'like', "%{$search}%")
                        ->orWhere('extract', 'like', "%{$search}%")
                        ->orWhere('study_tip', 'like', "%{$search}%");
                });
            })
            ->orderBy('exam_id')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.questions.index', compact('questions', 'exams', 'examId', 'search'));
    }

    public function edit(Questions $question)
    {
        $exams = Exam::orderBy('name')->get();

        return view('admin.questions.edit', compact('question', 'exams'));
    }

    public function update(Request $request, Questions $question)
    {
        $validated = $request->validate([
            'exam_id' => ['required', 'exists:exams,id'],
            'question' => ['required', 'string', 'max:5000'],
            'extract' => ['nullable', 'string'],
            'optionA' => ['nullable', 'string', 'max:500'],
            'optionB' => ['nullable', 'string', 'max:500'],
            'optionC' => ['nullable', 'string', 'max:500'],
            'optionD' => ['nullable', 'string', 'max:500'],
            'optionE' => ['nullable', 'string', 'max:500'],
            'optionF' => ['nullable', 'string', 'max:500'],
            'optionG' => ['nullable', 'string', 'max:500'],
            'correct_answer' => ['required', 'string', 'max:10'],
            'rationale' => ['nullable', 'string'],
            'study_tip' => ['nullable', 'string'],
        ]);

        $question->update([
            'exam_id' => $validated['exam_id'],
            'question' => $validated['question'],
            'extract' => $validated['extract'] ?? null,
            'optionA' => $validated['optionA'] ?? null,
            'optionB' => $validated['optionB'] ?? null,
            'optionC' => $validated['optionC'] ?? null,
            'optionD' => $validated['optionD'] ?? null,
            'optionE' => $validated['optionE'] ?? null,
            'optionF' => $validated['optionF'] ?? null,
            'optionG' => $validated['optionG'] ?? null,
            'correct_answer' => strtoupper(trim($validated['correct_answer'])),
            'rationale' => $validated['rationale'] ?? null,
            'study_tip' => $validated['study_tip'] ?? null,
        ]);

        return redirect()->route('admin.questions.index')->with('success', "Question #{$question->id} updated successfully.");
    }

    public function create()
    {
        $exams = Exam::orderBy('name')->get();

        return view('admin.questions.create', compact('exams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => ['required', 'exists:exams,id'],
            'question' => ['required', 'string'],
            'extract' => ['nullable', 'string'],
            'optionA' => ['nullable', 'string'],
            'optionB' => ['nullable', 'string'],
            'optionC' => ['nullable', 'string'],
            'optionD' => ['nullable', 'string'],
            'optionE' => ['nullable', 'string'],
            'optionF' => ['nullable', 'string'],
            'optionG' => ['nullable', 'string'],
            'correct_answer' => ['required', 'string', 'max:10'],
            'rationale' => ['nullable', 'string'],
            'study_tip' => ['nullable', 'string'],
        ]);

        Questions::create([
            'exam_id' => $validated['exam_id'],
            'question' => $validated['question'],
            'extract' => $validated['extract'] ?? null,
            'optionA' => $validated['optionA'] ?? null,
            'optionB' => $validated['optionB'] ?? null,
            'optionC' => $validated['optionC'] ?? null,
            'optionD' => $validated['optionD'] ?? null,
            'optionE' => $validated['optionE'] ?? null,
            'optionF' => $validated['optionF'] ?? null,
            'optionG' => $validated['optionG'] ?? null,
            'correct_answer' => strtoupper(trim($validated['correct_answer'])),
            'rationale' => $validated['rationale'] ?? null,
            'study_tip' => $validated['study_tip'] ?? null,
            'slug' => Str::slug($validated['question'], '-', null),
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'Question created successfully.');
    }

    public function destroy(Questions $question)
    {
        $question->delete();

        return back()->with('success', "Question #{$question->id} deleted.");
    }
}
