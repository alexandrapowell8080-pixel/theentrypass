<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Question Manager | Admin | The Entry Pass</title>
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
            flex-wrap: wrap;
            gap: var(--spacing-4);
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
        .filters-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: var(--spacing-4);
            align-items: end;
            margin-bottom: var(--spacing-6);
            padding-bottom: var(--spacing-4);
            border-bottom: 1px solid var(--color-border);
        }
        .filter-field label {
            display: block;
            font-size: var(--font-size-xs);
            font-weight: var(--font-weight-semibold);
            color: var(--color-muted-foreground);
            margin-bottom: var(--spacing-2);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .filter-field input,
        .filter-field select {
            width: 100%;
            padding: var(--spacing-3);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            font-size: var(--font-size-sm);
            background: var(--color-background);
            transition: all var(--transition-fast);
        }
        .filter-field input:focus,
        .filter-field select:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px var(--color-primary-light);
        }
        .filter-actions {
            display: flex;
            gap: var(--spacing-2);
            flex-wrap: wrap;
        }
        .questions-table-container {
            overflow-x: auto;
            border-radius: var(--radius-xl);
            border: 1px solid var(--color-border);
        }
        .questions-table {
            width: 100%;
            border-collapse: collapse;
            font-size: var(--font-size-sm);
        }
        .questions-table thead {
            background: var(--color-muted);
            border-bottom: 1px solid var(--color-border);
        }
        .questions-table th {
            padding: var(--spacing-4);
            text-align: left;
            font-weight: var(--font-weight-semibold);
            color: var(--color-muted-foreground);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: var(--font-size-xs);
            white-space: nowrap;
        }
        .questions-table tbody tr {
            border-bottom: 1px solid var(--color-border);
            transition: background var(--transition-fast);
        }
        .questions-table tbody tr:hover {
            background: var(--color-muted);
        }
        .questions-table tbody tr:last-child {
            border-bottom: none;
        }
        .questions-table td {
            padding: var(--spacing-4);
            vertical-align: middle;
        }
        .question-number {
            font-weight: var(--font-weight-semibold);
            color: var(--color-muted-foreground);
            width: 60px;
        }
        .question-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--color-primary);
        }
        .question-text-cell {
            max-width: 400px;
            color: var(--color-foreground);
            line-height: var(--line-height-relaxed);
        }
        .question-text-truncated {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }
        .question-type {
            font-size: var(--font-size-xs);
            padding: var(--spacing-1) var(--spacing-3);
            background: var(--color-primary-light);
            color: var(--color-primary);
            border-radius: var(--radius-full);
            font-weight: var(--font-weight-semibold);
            display: inline-block;
            white-space: nowrap;
        }
        .question-added-by {
            color: var(--color-muted-foreground);
            white-space: nowrap;
        }
        .question-date {
            color: var(--color-muted-foreground);
            white-space: nowrap;
            font-size: var(--font-size-xs);
        }
        .question-actions {
            display: flex;
            gap: var(--spacing-2);
            white-space: nowrap;
        }
        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-lg);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-fast);
            cursor: pointer;
            border: 1px solid var(--color-border);
            background: var(--color-card);
        }
        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }
        .action-btn.edit {
            color: var(--color-primary);
            border-color: var(--color-primary-border);
        }
        .action-btn.edit:hover {
            background: var(--color-primary-light);
        }
        .action-btn.delete {
            color: var(--color-error);
            border-color: var(--color-error-border);
        }
        .action-btn.delete:hover {
            background: var(--color-error-bg);
        }
        .action-btn svg {
            width: 16px;
            height: 16px;
        }
        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: var(--spacing-6);
            padding-top: var(--spacing-4);
            border-top: 1px solid var(--color-border);
            flex-wrap: wrap;
            gap: var(--spacing-4);
        }
        .pagination-info {
            font-size: var(--font-size-sm);
            color: var(--color-muted-foreground);
        }
        .pagination {
            display: flex;
            gap: var(--spacing-1);
        }
        .pagination .page-link {
            padding: var(--spacing-2) var(--spacing-4);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            color: var(--color-foreground);
            font-size: var(--font-size-sm);
            font-weight: var(--font-weight-medium);
            transition: all var(--transition-fast);
            background: var(--color-card);
        }
        .pagination .page-link:hover,
        .pagination .page-link.active {
            background: var(--color-primary);
            color: var(--color-primary-foreground);
            border-color: var(--color-primary);
        }
        .pagination .page-link:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .empty-state {
            text-align: center;
            padding: var(--spacing-12) var(--spacing-6);
            color: var(--color-muted-foreground);
        }
        .empty-state-icon {
            width: 4rem;
            height: 4rem;
            margin: 0 auto var(--spacing-4);
            border-radius: var(--radius-full);
            background: var(--color-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-primary);
        }
        .alert {
            padding: var(--spacing-4);
            border-radius: var(--radius-lg);
            margin-bottom: var(--spacing-4);
            font-size: var(--font-size-sm);
            display: flex;
            align-items: center;
            gap: var(--spacing-3);
        }
        .alert-success {
            background: var(--color-success-bg);
            color: var(--color-success);
            border: 1px solid var(--color-success-border);
        }
        .alert-error {
            background: var(--color-error-bg);
            color: var(--color-error);
            border: 1px solid var(--color-error-border);
        }
        .alert svg {
            width: 1.25rem;
            height: 1.25rem;
            flex-shrink: 0;
        }
        .bulk-actions {
            display: flex;
            gap: var(--spacing-2);
            margin-bottom: var(--spacing-4);
            align-items: center;
        }
        .select-all-wrapper {
            display: flex;
            align-items: center;
            gap: var(--spacing-2);
            font-size: var(--font-size-sm);
            color: var(--color-muted-foreground);
        }
        @media (max-width: 768px) {
            .admin-wrapper {
                padding: var(--spacing-4);
            }
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .filters-bar {
                grid-template-columns: 1fr;
            }
            .questions-table {
                font-size: var(--font-size-xs);
            }
            .questions-table th,
            .questions-table td {
                padding: var(--spacing-2);
            }
            .question-text-cell {
                max-width: 200px;
            }
            .action-btn {
                width: 28px;
                height: 28px;
            }
            .action-btn svg {
                width: 14px;
                height: 14px;
            }
        }
    </style>
</head>
<body>
    @include('partials.header')
    
    <main class="admin-wrapper">
        <div class="container" style="max-width: 90rem;">
            <div class="admin-header">
                <h1 class="admin-title">Question Manager</h1>
                <div style="display: flex; gap: var(--spacing-2); flex-wrap: wrap;">
                    <a href="{{ route('homepage') }}" class="btn btn-outline btn-sm">← Back to Site</a>
                    <a href="{{ route('admin.questions.create') }}" class="btn btn-primary btn-sm">+ Add Question</a>
                    <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">Logout</button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line></svg>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line></svg>
                    <div>
                        <strong>Please fix the following:</strong>
                        <ul style="margin-top: var(--spacing-2); padding-left: var(--spacing-6);">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="admin-card">
                <form method="GET" action="{{ route('admin.questions.index') }}" class="filters-bar">
                    <div class="filter-field">
                        <label for="search">Search</label>
                        <input type="text" name="search" id="search" value="{{ $search }}" placeholder="Search questions...">
                    </div>
                    <div class="filter-field">
                        <label for="exam_id">Filter by Exam</label>
                        <select name="exam_id" id="exam_id">
                            <option value="">All Exams</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ $examId == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-outline">Reset</a>
                    </div>
                </form>

                @if($questions->count())
                    <div class="bulk-actions">
                        <div class="select-all-wrapper">
                            <input type="checkbox" id="select-all" class="question-checkbox">
                            <label for="select-all">Select All</label>
                        </div>
                        <span style="color: var(--color-muted-foreground); font-size: var(--font-size-sm);">
                            {{ $questions->total() }} questions found
                        </span>
                    </div>

                    <div class="questions-table-container">
                        <table class="questions-table">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" class="question-checkbox" id="header-checkbox">
                                    </th>
                                    <th style="width: 60px;">#</th>
                                    <th>Question</th>
                                    <th>Type</th>
                                    <th>Added By</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $globalNumber = ($questions->currentPage() - 1) * $questions->perPage();
                                @endphp
                                @foreach($questions as $question)
                                    @php $globalNumber++; @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="question-checkbox row-checkbox" data-id="{{ $question->id }}">
                                        </td>
                                        <td class="question-number">{{ $globalNumber }}</td>
                                        <td class="question-text-cell">
                                            <span class="question-text-truncated" title="{{ $question->question }}">
                                                {{ $question->question }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="question-type">Regular</span>
                                        </td>
                                        <td class="question-added-by">
                                            {{ $question->exam->user->name ?? 'Admin' }}
                                        </td>
                                        <td class="question-date">
                                            {{ $question->created_at->format('M d, Y') }}
                                        </td>
                                        <td>
                                            <div class="question-actions">
                                                <button type="button" class="action-btn edit" onclick="editQuestion({{ $question->id }})" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path><path d="m15 5 4 4"></path></svg>
                                                </button>
                                                <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" style="display: inline;" onsubmit="return confirm('Delete this question permanently?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn delete" title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrapper">
                        <div class="pagination-info">
                            Showing {{ $questions->firstItem() }} to {{ $questions->lastItem() }} of {{ $questions->total() }} results
                        </div>
                        <div class="pagination">
                            {{ $questions->links() }}
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line></svg>
                        </div>
                        <p style="font-size: var(--font-size-lg); margin-bottom: var(--spacing-2);">No questions found</p>
                        <p style="margin-bottom: var(--spacing-4);">Try adjusting your filters or add your first question.</p>
                        <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">+ Add First Question</a>
                    </div>
                @endif
            </div>
        </div>
    </main>

    @include('partials.footer')
    
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            if (window.axios) {
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
            }

            const headerCheckbox = document.getElementById('header-checkbox');
            const selectAll = document.getElementById('select-all');
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');

            function updateSelectAllState() {
                const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
                headerCheckbox.checked = allChecked;
                selectAll.checked = allChecked;
            }

            headerCheckbox.addEventListener('change', function() {
                rowCheckboxes.forEach(cb => cb.checked = this.checked);
                selectAll.checked = this.checked;
            });

            selectAll.addEventListener('change', function() {
                rowCheckboxes.forEach(cb => cb.checked = this.checked);
                headerCheckbox.checked = this.checked;
            });

            rowCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateSelectAllState);
            });
        });

        function editQuestion(id) {
            window.location.href = '/admin/questions/' + id + '/edit';
        }
    </script>
</body>
</html>