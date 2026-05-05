<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Question | Admin | The Entry Pass</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .admin-wrapper {
            background: var(--color-background);
            min-height: 100vh;
            padding: var(--spacing-8);
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-6);
            padding-bottom: var(--spacing-4);
            border-bottom: 1px solid var(--color-border);
        }
        .admin-title {
            font-size: var(--font-size-2xl);
            font-weight: var(--font-weight-bold);
            color: var(--color-foreground);
        }
        .admin-card {
            background: var(--color-card);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-sm);
            padding: var(--spacing-6);
            margin-bottom: var(--spacing-6);
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-4);
        }
        .form-field {
            margin-bottom: var(--spacing-4);
        }
        .form-field label {
            display: block;
            font-size: var(--font-size-xs);
            font-weight: var(--font-weight-semibold);
            color: var(--color-muted-foreground);
            margin-bottom: var(--spacing-2);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .form-field input,
        .form-field select,
        .form-field textarea {
            width: 100%;
            padding: var(--spacing-3);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            font-size: var(--font-size-sm);
            background: var(--color-background);
            transition: all var(--transition-fast);
        }
        .form-field input:focus,
        .form-field select:focus,
        .form-field textarea:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px var(--color-primary-light);
        }
        .form-field textarea {
            min-height: 100px;
            resize: vertical;
        }
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: var(--spacing-2);
            margin-top: var(--spacing-6);
            flex-wrap: wrap;
        }
        .alert {
            padding: var(--spacing-4);
            border-radius: var(--radius-lg);
            margin-bottom: var(--spacing-4);
            font-size: var(--font-size-sm);
        }
        .alert-error {
            background: var(--color-error-bg);
            color: var(--color-error);
            border: 1px solid var(--color-error-border);
        }
        .hint-text {
            font-size: var(--font-size-xs);
            color: var(--color-muted-foreground);
            margin-top: var(--spacing-1);
        }
        @media (max-width: 768px) {
            .admin-wrapper { padding: var(--spacing-4); }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @include('partials.header')
    
    <main class="admin-wrapper">
        <div class="container">
            <div class="admin-header">
                <h1 class="admin-title">Create New Question</h1>
                <a href="{{ route('admin.questions.index') }}" class="btn btn-outline btn-sm">← Back to List</a>
            </div>

            @if($errors->any())
                <div class="alert alert-error">
                    <strong>Please fix the following:</strong>
                    <ul style="margin-top: var(--spacing-2); padding-left: var(--spacing-6);">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="admin-card">
                <form method="POST" action="{{ route('admin.questions.store') }}">
                    @csrf

                    <div class="form-grid">
                        <div class="form-field">
                            <label>Exam <span style="color: var(--color-error);">*</span></label>
                            <select name="exam_id" required>
                                <option value="">Select an exam</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-field">
                            <label>Correct Answer <span style="color: var(--color-error);">*</span></label>
                            <select name="correct_answer" required>
                                <option value="">Select answer</option>
                                @foreach(['A','B','C','D','E','F','G'] as $opt)
                                    <option value="{{ $opt }}" {{ old('correct_answer') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                            <p class="hint-text">Select which option (A-G) is correct</p>
                        </div>
                    </div>

                    <div class="form-field">
                        <label>Question Text <span style="color: var(--color-error);">*</span></label>
                        <textarea name="question" required placeholder="Enter your question here...">{{ old('question') }}</textarea>
                    </div>

                    <div class="form-field">
                        <label>Extract / Context (Optional)</label>
                        <textarea name="extract" placeholder="Add context, passage, or scenario for this question...">{{ old('extract') }}</textarea>
                        <p class="hint-text">Use this for case studies or passage-based questions</p>
                    </div>

                    <div class="form-grid">
                        @foreach(['A','B','C','D','E','F','G'] as $letter)
                            <div class="form-field">
                                <label>Option {{ $letter }}</label>
                                <textarea name="option{{ $letter }}" placeholder="Option {{ $letter }} text...">{{ old('option'.$letter) }}</textarea>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-field">
                        <label>Rationale / Explanation</label>
                        <textarea name="rationale" placeholder="Explain why the correct answer is right...">{{ old('rationale') }}</textarea>
                        <p class="hint-text">Helps students learn from their mistakes</p>
                    </div>

                    <div class="form-field">
                        <label>Study Tip (Optional)</label>
                        <textarea name="study_tip" placeholder="Add a helpful hint or memory aid...">{{ old('study_tip') }}</textarea>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-outline">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Question</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('partials.footer')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>