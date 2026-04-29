<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The Entry Pass</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0EA5E9',
                        secondary: '#14B8A6',
                        accent: '#8B5CF6',
                        success: '#22C55E',
                        error: '#EF4444',
                        appBg: '#F8FAFC',
                        card: '#FFFFFF',
                        textMain: '#020617',
                        textMuted: '#64748B',
                        borderBase: '#E2E8F0',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-appBg text-textMain antialiased">
    <div class="min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6">
            {{-- heading --}}
            <div class="sticky top-0 z-40 bg-appBg/90 backdrop-blur-lg pb-4 pt-2 mb-4 border-b border-borderBase/50">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-xs text-textMuted font-bold uppercase tracking-tight">English Practice Test 1</p>
                        <p class="text-sm font-semibold">Question 1 of {{ $question_count }}</p>
                    </div>
                    <a href="/"
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors hover:text-error h-8 rounded-md px-3 text-xs text-textMuted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-x w-4 h-4 mr-1">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg> Exit
                    </a>
                </div>
                <div aria-valuemax="100" aria-valuemin="0" role="progressbar"
                    class="relative w-full overflow-hidden rounded-full h-2 bg-borderBase">
                    <div class="h-full bg-primary transition-all duration-500" style="width: 20%;">
                    </div>
                </div>
            </div>

            {{-- question --}}
            <div class="flex flex-row items-start gap-6">
                <div class="min-w-0 flex flex-1 border border-borderBase rounded-2xl bg-card shadow-sm overflow-hidden">
                    <div class="w-1/2 p-6 border-r border-borderBase">
                        <div style="opacity: 1; transform: none;">
                            <div class="mb-6">
                                <h2 id="{{ $question->id }}"
                                    class="question font-semibold text-lg text-textMain mb-6 leading-relaxed">
                                    {{ $question->question }}
                                </h2>
                                <div id="left-col" class="space-y-3 min-h-[150px]">
                                    <button id="optionA"
                                        class="w-full text-left p-4 rounded-xl border border-borderBase hover:border-primary/50 hover:bg-appBg transition-all flex items-center gap-3 group">
                                        <span
                                            class="w-8 h-8 rounded-lg bg-appBg border border-borderBase flex items-center justify-center text-sm font-bold text-textMuted group-hover:text-primary shrink-0">A</span>
                                        <span class="flex-1 text-sm font-medium optionA">{{ $question->optionA }}</span>
                                    </button>
                                    <button id="optionB"
                                        class="w-full text-left p-4 rounded-xl border border-borderBase hover:border-primary/50 hover:bg-appBg transition-all flex items-center gap-3 group">
                                        <span
                                            class="w-8 h-8 rounded-lg bg-appBg border border-borderBase flex items-center justify-center text-sm font-bold text-textMuted group-hover:text-primary shrink-0">B</span>
                                        <span class="flex-1 text-sm font-medium optionB">{{ $question->optionB }}</span>
                                    </button>
                                    <button id="optionC"
                                        class="w-full text-left p-4 rounded-xl border border-borderBase hover:border-primary/50 hover:bg-appBg transition-all flex items-center gap-3 group">
                                        <span
                                            class="w-8 h-8 rounded-lg bg-appBg border border-borderBase flex items-center justify-center text-sm font-bold text-textMuted group-hover:text-primary shrink-0">C</span>
                                        <span class="flex-1 text-sm font-medium optionC">{{ $question->optionC }}</span>
                                    </button>
                                    <button id="optionD"
                                        class="w-full text-left p-4 rounded-xl border border-borderBase hover:border-primary/50 hover:bg-appBg transition-all flex items-center gap-3 group">
                                        <span
                                            class="w-8 h-8 rounded-lg bg-appBg border border-borderBase flex items-center justify-center text-sm font-bold text-textMuted group-hover:text-primary shrink-0">D</span>
                                        <span class="flex-1 text-sm font-medium optionD">{{ $question->optionD }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div
                            class=" submit_btn_card flex items-center justify-between mt-6 pt-4 border-t border-borderBase">
                            <button
                                class="inline-flex items-center justify-center gap-2 text-sm font-medium text-textMuted disabled:opacity-30 h-9 px-4 py-2"
                                disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-left w-4 h-4 mr-1">
                                    <path d="m12 19-7-7 7-7"></path>
                                    <path d="M19 12H5"></path>
                                </svg> Previous
                            </button>
                            <button id="submitBtn"
                                class="inline-flex items-center justify-center gap-2 text-sm font-bold bg-primary cursor-not-allowed text-white shadow-lg shadow-primary/20 h-9 px-6 py-2 rounded-xl hover:bg-primary/90 transition-all"
                                disabled>
                                Submit Answer
                            </button>
                        </div>
                    </div>

                    <div class="w-1/2 p-6 bg-appBg/30">
                        <p class="text-[11px] font-bold text-textMuted uppercase mb-3">Drag your answer here</p>
                        <div id="right-col"
                            class="space-y-3 min-h-[120px] border-2 border-dashed border-borderBase rounded-2xl flex flex-col items-center justify-center p-4 bg-white/50">
                        </div>

                        <div id="study_tip_card"
                            class="mt-8 p-5 rounded-2xl bg-accent/5 border border-accent/10 hidden">
                            <span class="text-xs font-bold text-accent uppercase flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M12 7v14M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                                </svg>
                                Study Tip
                            </span>
                            <p class="text-xs text-textMuted leading-relaxed study_tip_text"> </p>
                        </div>
                    </div>
                </div>

            </div>
            <div style="opacity: 1; transform: none;" class="mt-3 rationale hidden">
                <div class="flex flex-wrap gap-2 mb-4"><button onclick="retryQuestion()"
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-transparent shadow-sm hover:bg-accent hover:text-accent-foreground h-8 px-3 text-xs rounded-xl"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-rotate-ccw w-4 h-4 mr-1">
                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                            <path d="M3 3v5h5"></path>
                        </svg> Retry</button>
                    <button onclick="veiwExplanation()"
                        class="viewExplanation  inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-transparent shadow-sm hover:bg-accent hover:text-accent-foreground h-8 px-3 text-xs rounded-xl"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-eye w-4 h-4 mr-1">
                            <path
                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                            </path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg> <span>View Explanation</span> </button>

                    <button onclick="hideExplanation()"
                        class="hideExplanation hidden inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-transparent shadow-sm hover:bg-accent hover:text-accent-foreground h-8 px-3 text-xs rounded-xl"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-eye-off w-4 h-4 mr-1">
                            <path
                                d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49">
                            </path>
                            <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"></path>
                            <path
                                d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143">
                            </path>
                            <path d="m2 2 20 20"></path>
                        </svg>Hide Explanation</button>





                    <button onclick="nextQuestion()"
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-primary-foreground shadow hover:bg-primary/90 h-8 px-3 text-xs rounded-xl bg-primary">Next
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4 ml-1">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg></button>
                </div>
                <div
                    class="rounded-xl hidden border text-card-foreground shadow p-4 bg-muted/50 border-border rationale_text_card">
                    <p class="text-sm text-foreground leading-relaxed rationale_text"></p>
                </div>
            </div>

            {{-- extra data --}}
            <div class=" w-full flex  gap-3 my-5 shrink-0 space-y-4">
                <div class="rounded-2xl flex-1 bg-card border border-borderBase shadow-sm p-4">
                    <h3 class="font-bold text-xs text-textMain mb-3 flex items-center gap-2 uppercase tracking-wide">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 text-primary">
                            <path
                                d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                            </path>
                        </svg>More in this set
                    </h3>
                    <div class="space-y-2">
                        <a class="flex items-center gap-2 p-2 rounded-lg hover:bg-appBg transition-colors group"
                            href="/quiz/69f0706dc522ae17d2f0114b">
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-xs font-bold text-textMain truncate group-hover:text-primary transition-colors">
                                    Free English Grammar Drill</p>
                                <div class="flex items-center gap-1 mt-0.5">
                                    <div
                                        class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-secondary/10 text-secondary uppercase">
                                        beginner</div>
                                    <div
                                        class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-success/10 text-success uppercase">
                                        Free</div>
                                </div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-chevron-right w-3.5 h-3.5 text-textMuted group-hover:translate-x-1 transition-transform">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl flex-1 bg-card border border-borderBase shadow-sm p-4">
                    <h3 class="font-bold text-xs text-textMain mb-3 flex items-center gap-2 uppercase tracking-wide">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-book-open w-4 h-4 text-primary">
                            <path d="M12 7v14"></path>
                            <path
                                d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z">
                            </path>
                        </svg>Other TEAS 7 sets
                    </h3>
                    <p class="text-[10px] text-textMuted mb-3 font-medium">Explore more subjects</p>
                    <div class="space-y-1">
                        <a class="flex items-center gap-2 p-2 rounded-lg hover:bg-appBg transition-all group"
                            href="/exams/teas-7/teas-science">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-textMain group-hover:text-primary">Science</p>
                                <p class="text-[10px] text-textMuted">2 practice tests</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-chevron-right w-3.5 h-3.5 text-textMuted">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const left = document.getElementById('left-col');
        const right = document.getElementById('right-col');
        let submitBtn = document.getElementById('submitBtn');
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let user_answer = null;
        let study_tip_card = document.getElementById('study_tip_card')
        let rationale = document.querySelector('.rationale')
        let rationale_text_card = document.querySelector('.rationale_text_card')
        let rationale_text = document.querySelector('.rationale_text')

        let leftSortable = Sortable.create(left, {
            group: 'shared',
            animation: 150,
            sort: false
        });

        let rightSortable = Sortable.create(right, {
            group: 'shared',
            animation: 150,
            onAdd: function(evt) {
                if (right.children.length > 1) {
                    const previous = right.children[0];
                    left.appendChild(previous);
                }
                user_answer = right.children[0].id.replace('option', '');
                toogleSubmitBtn('on')
            },
            onRemove: function(evt) {
                toogleSubmitBtn('off')
                user_answer = null;
            },
        });

        function toogleSubmitBtn(state) {
            if (state == 'on') {
                submitBtn.removeAttribute('disabled');
                submitBtn.classList.remove('cursor-not-allowed')
                submitBtn.classList.add('cursor-pointer')
                right.classList.add('border-primary')
            } else if (state == 'off') {
                submitBtn.disabled = true;
                submitBtn.classList.remove('cursor-pointer')
                submitBtn.classList.add('cursor-not-allowed')
                right.classList.remove('border-primary')
            }
        }

        submitBtn.addEventListener('click', submitAnswer);

        function submitAnswer() {
            let question_id = document.querySelector('.question').id
            const postData = {
                question_id: question_id,
                user_answer: user_answer,
                exam_id: 1
            };
            fetch('/answer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify(postData)
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        // handle HTTP errors like 404, 500, etc.
                        if (response.status == 404) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                html: "Something went wrong! <br>" + data.message,

                            });
                        }
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return data;
                })
                .then(response => {
                    document.querySelector('.submit_btn_card').classList.add('hidden')
                    toogleSubmitBtn('off')
                    leftSortable.option("disabled", true);
                    rightSortable.option("disabled", true);
                    if (response.status == 'wrong') {
                        right.classList.remove('bg-white/10', 'border-primary')
                        right.classList.add('bg-error/10', 'border-error')
                    } else if (response.status == 'correct') {
                        right.classList.remove('bg-white/10', 'border-primary')
                        right.classList.add('bg-success/10', 'border-success')
                    }
                    study_tip_card.classList.remove('hidden');
                    document.querySelector('.study_tip_text').innerText = response.study_tip
                    rationale.classList.remove('hidden')
                    rationale_text.innerText = response.rationale
                })
                .catch(err => {
                    console.log(err)
                })
        }

        function veiwExplanation() {
            rationale_text_card.classList.remove('hidden')
            document.querySelector('.viewExplanation').classList.add('hidden')
            document.querySelector('.hideExplanation').classList.remove('hidden')
        }

        function hideExplanation() {
            rationale_text_card.classList.add('hidden')
            document.querySelector('.viewExplanation').classList.remove('hidden')
            document.querySelector('.hideExplanation').classList.add('hidden')
        }

        function nextQuestion() {
            let question_id = document.querySelector('.question').id
            fetch('/next-question/' + question_id)
                .then(response => response.json())
                .then(response => {
                    while (right.firstChild) {
                        left.appendChild(right.firstChild);
                    }

                    right.innerHTML = '';

                    user_answer = null;
                    document.querySelector('.question').id = response.question.id
                    document.querySelector('.question').innerText = response.question.question
                    document.querySelector('.optionA').innerText = response.question.optionA
                    document.querySelector('.optionB').innerText = response.question.optionB
                    document.querySelector('.optionC').innerText = response.question.optionC
                    document.querySelector('.optionD').innerText = response.question.optionD
                    document.querySelector('.submit_btn_card').classList.remove('hidden')
                    leftSortable.option("disabled", false);
                    rightSortable.option("disabled", false);
                    right.classList.remove('bg-error/10', 'border-error', 'bg-success/10', 'border-success')
                    right.classList.add('bg-white/10')
                    rationale.classList.add('hidden')
                    study_tip_card.classList.add('hidden');

                    const items = Array.from(left.children);

                    items.sort((a, b) => {
                        return a.textContent.trim().localeCompare(b.textContent.trim());
                    });

                    items.forEach(item => left.appendChild(item));

                })
        }

        function retryQuestion() {
            let question_id = document.querySelector('.question').id
            fetch('/retry-question/' + question_id)
                .then(response => response.json())
                .then(response => {
                    while (right.firstChild) {
                        left.appendChild(right.firstChild);
                    }

                    right.innerHTML = '';

                    user_answer = null;
                    document.querySelector('.question').id = response.question.id
                    document.querySelector('.question').innerText = response.question.question
                    document.querySelector('.optionA').innerText = response.question.optionA
                    document.querySelector('.optionB').innerText = response.question.optionB
                    document.querySelector('.optionC').innerText = response.question.optionC
                    document.querySelector('.optionD').innerText = response.question.optionD
                    document.querySelector('.submit_btn_card').classList.remove('hidden')
                    leftSortable.option("disabled", false);
                    rightSortable.option("disabled", false);
                    right.classList.remove('bg-error/10', 'border-error', 'bg-success/10', 'border-success')
                    right.classList.add('bg-white/10')
                    rationale.classList.add('hidden')
                    study_tip_card.classList.add('hidden');

                    const items = Array.from(left.children);

                    items.sort((a, b) => {
                        return a.textContent.trim().localeCompare(b.textContent.trim());
                    });

                    items.forEach(item => left.appendChild(item));

                })
        }
    </script>
</body>

</html>
