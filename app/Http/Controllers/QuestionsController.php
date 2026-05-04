<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Questions;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionsController extends Controller
{


    public function questions(string $course, string $exam): View
    {
        $exam = Exam::where('slug', $exam)->first();
        if (! $exam) {
            abort(404, 'Exam not found');
        }
        $course_name = $exam->subject->course->name;
        $course_slug = $exam->subject->course->slug;
        $subject_name = $exam->subject->name;
        $exam_name = $exam->name;
        $exam_slug = $exam->slug;
        $question_query = Questions::where('exam_id', $exam->id);
        $subjects = Subject::with(['exams' => function ($query) {
            $query->orderBy('id')->limit(1);
        }])->where('course_id', $exam->subject->course->id)->take(3)->get();
        $exams = Exam::where('subject_id', $exam->subject->id)->whereNot('id', $exam->id)->take(3)->get();

        $question = (clone $question_query)->first();
        $question_count = (clone $question_query)->count();

        $q_r = [];
        foreach ($subjects as $key => $subject) {
            foreach ($subject->exams as $exam_key => $exam_) {
                $q_r[] = [
                    '@type' => 'Question',
                    'name' => $exam_->name,
                    'url' => url($course_slug.'/'.$exam_->slug),
                ];
            }

        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'QAPage',
            'name' => $question->question.' | '.env('APP_NAME'),
            'url' => url($course_slug.'/'.$exam_slug),
            'description' => 'Practice and ace '.$course_name.' using our quality prep materials on '.$subject_name.' using '.$exam_name,
            'mainEntity' => [
                '@type' => 'Question',
                'name' => $question->question,
                'text' => $question->question,
                'eduQuestionType' => 'Multiple choice',
                'answerCount' => 1,
                'upvoteCount' => 5,
                'datePublished' => $question->created_at,
                'author' => [
                    '@type' => 'Person',
                    'name' => env('APP_NAME'),
                    'url' => env('APP_URL'),
                ],
                'about' => [
                    '@type' => 'Thing',
                    'name' => $subject_name,
                ],
                'educationalAlignment' => [
                    [
                        '@type' => 'AlignmentObject',
                        'alignmentType' => 'educationalSubject',
                        'targetName' => $exam_name,
                    ],
                ],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $question->correct_answer.' Rationale: '.$question->rationale,
                    'upvoteCount' => 10,
                    'datePublished' => $question->created_at,
                    'author' => [
                        '@type' => 'Organization',
                        'name' => env('APP_NAME'),
                        'url' => env('APP_URL'),
                    ]],

            ],
            'relatedLink' => $q_r,
        ];

        return view('questions.index', compact('question', 'question_count', 'course_name', 'subject_name', 'exam_name', 'exam_slug', 'course_slug', 'subjects', 'exams', 'schema'));
    }

    /**
     * Check user answer if correct
     */
    public function answer(Request $request): JsonResponse
    {
        $data = $request->validate([
            'question_id' => 'required',
            'user_answer' => 'required',
            'exam_id' => 'required',
        ]);

        $question = Questions::where('id', $data['question_id'])->first();
        if (! $question) {
            return response()->json([
                'message' => 'The requested question does not exits!!',
            ], 404);
        }
        $is_correct = $question->correct_answer == $data['user_answer'];

        return response()->json([
            'status' => $is_correct ? 'correct' : 'wrong',
            'correct_answer' => $is_correct ? null : $question->correct_answer,
            'rationale' => $question->rationale,
            'study_tip' => $question->study_tip,
        ]);
    }

    /**
     * Retrives the next question
     */
    public function nextQuestion(int $question_id): JsonResponse
    {
        $question_query = Questions::where('id', $question_id);
        $question = (clone $question_query)->first();
        if (! $question) {

            if ($question_id == -1) {
                return response()->json([
                    'message' => 'The exam is completed!',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'The requested question does not exits!!',
                ], 404);
            }
        }
        $question = Questions::where('id', '>', $question_id)->where('exam_id', $question->exam_id)->orderBy('id')->first();

        return response()->json([
            'question' => $question,
        ]);
    }

    /**
     * Retry question
     */
    public function retryQuestion(int $question_id)
    {
        $question = Questions::whereId($question_id)->first();
        if (! $question) {
            return response()->json([
                'message' => 'The requested question does not exits or has been deleted!!',
            ], 404);
        }

        return response()->json([
            'question' => $question,
        ]);
    }
}
