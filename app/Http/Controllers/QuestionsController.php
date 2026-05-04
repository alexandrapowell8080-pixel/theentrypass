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
    private array $questions = [
        [
            'id' => 1,
            'extract' => 'The human heart is a muscular organ responsible for pumping blood through the circulatory system.',
            'question' => 'What is the main function of the heart?',
            'optionA' => 'Produce hormones',
            'optionB' => 'Pump blood',
            'optionC' => 'Filter toxins',
            'optionD' => 'Digest food',
            'optionE' => 'Store oxygen',
            'optionF' => 'Control movement',
            'optionG' => 'Regulate temperature',
            'correct_answer' => 'B',
            'rationale' => 'The heart is a central organ in the circulatory system whose primary role is to pump blood throughout the body. This process ensures that oxygen and nutrients are delivered to tissues while waste products like carbon dioxide are removed. Although other organs perform functions such as hormone production or detoxification, those are not roles of the heart. Its muscular walls contract rhythmically to maintain blood flow, making option B the correct answer.',
            'study_tip' => 'Associate each organ with its primary system function.',
        ],

        [
            'id' => 2,
            'extract' => 'The brain controls body activities and processes information from the environment.',
            'question' => 'Which organ controls the body’s activities?',
            'optionA' => 'Heart',
            'optionB' => 'Liver',
            'optionC' => 'Brain',
            'optionD' => 'Kidney',
            'optionE' => 'Lungs',
            'optionF' => 'Pancreas',
            'optionG' => 'Skin',
            'correct_answer' => 'C',
            'rationale' => 'The brain serves as the control center of the body. It processes sensory information, coordinates movement, and regulates vital functions such as breathing and heart rate. Through the nervous system, it sends signals to different parts of the body, ensuring proper functioning. While other organs have specialized roles, none can integrate and control activities like the brain. This makes option C the most accurate choice for this question.',
            'study_tip' => 'Think of the brain as the body’s command center.',
        ],

        [
            'id' => 3,
            'extract' => 'The lungs are responsible for gas exchange, allowing oxygen to enter the blood and carbon dioxide to leave.',
            'question' => 'What is the primary function of the lungs?',
            'optionA' => 'Pump blood',
            'optionB' => 'Gas exchange',
            'optionC' => 'Digest food',
            'optionD' => 'Produce hormones',
            'optionE' => 'Filter blood',
            'optionF' => 'Store energy',
            'optionG' => 'Control balance',
            'correct_answer' => 'B',
            'rationale' => 'The lungs play a vital role in respiration by facilitating gas exchange. Oxygen from inhaled air enters the bloodstream, while carbon dioxide, a waste product of metabolism, is expelled. This exchange occurs in tiny air sacs called alveoli. Without this function, cells would not receive oxygen needed for energy production. Other options refer to functions of different organs, making gas exchange the correct answer.',
            'study_tip' => 'Link lungs with oxygen and breathing.',
        ],

        [
            'id' => 4,
            'extract' => 'The liver helps detoxify chemicals and metabolize drugs.',
            'question' => 'Which organ detoxifies harmful substances?',
            'optionA' => 'Kidney',
            'optionB' => 'Heart',
            'optionC' => 'Brain',
            'optionD' => 'Liver',
            'optionE' => 'Lungs',
            'optionF' => 'Skin',
            'optionG' => 'Stomach',
            'correct_answer' => 'D',
            'rationale' => 'The liver is essential for detoxification. It processes toxins, drugs, and metabolic waste, converting them into less harmful substances that can be excreted. It also plays roles in metabolism and nutrient storage. While kidneys filter blood, detoxification is primarily handled by the liver. Therefore, option D is correct because it reflects the liver’s main role in protecting the body from harmful substances.',
            'study_tip' => 'Remember: liver = detox center.',
        ],

        [
            'id' => 5,
            'extract' => 'The kidneys filter waste products from the blood and produce urine.',
            'question' => 'What is the main function of the kidneys?',
            'optionA' => 'Produce bile',
            'optionB' => 'Filter blood',
            'optionC' => 'Pump oxygen',
            'optionD' => 'Digest proteins',
            'optionE' => 'Control nerves',
            'optionF' => 'Store vitamins',
            'optionG' => 'Make hormones',
            'correct_answer' => 'B',
            'rationale' => 'Kidneys maintain internal balance by filtering blood and removing waste products through urine. They regulate water, electrolyte levels, and pH balance. Although other organs assist in related processes, the kidneys specifically handle filtration and waste removal. This ensures toxins do not accumulate in the bloodstream. Hence, option B is correct as it accurately represents the kidneys’ primary role.',
            'study_tip' => 'Think kidneys = filters.',
        ],

        [
            'id' => 6,
            'extract' => 'Bones provide structure and support to the body.',
            'question' => 'What is the primary role of bones?',
            'optionA' => 'Produce enzymes',
            'optionB' => 'Support structure',
            'optionC' => 'Pump blood',
            'optionD' => 'Digest food',
            'optionE' => 'Filter toxins',
            'optionF' => 'Control breathing',
            'optionG' => 'Store oxygen',
            'correct_answer' => 'B',
            'rationale' => 'Bones form the framework of the human body, providing structure, protection for organs, and support for movement. They also store minerals like calcium and produce blood cells in the bone marrow. Although they have multiple roles, structural support is their primary function. Other options relate to different organ systems, making option B the correct answer.',
            'study_tip' => 'Skeleton = structure + protection.',
        ],

        [
            'id' => 7,
            'extract' => 'The stomach breaks down food using acids and enzymes.',
            'question' => 'What does the stomach primarily do?',
            'optionA' => 'Absorb oxygen',
            'optionB' => 'Pump blood',
            'optionC' => 'Break down food',
            'optionD' => 'Filter waste',
            'optionE' => 'Produce bile',
            'optionF' => 'Control movement',
            'optionG' => 'Store fat',
            'correct_answer' => 'C',
            'rationale' => 'The stomach is a key organ in digestion. It uses gastric acids and enzymes to break down food into smaller components that can be absorbed later in the intestines. This process is crucial for nutrient extraction. While other organs contribute to digestion, the stomach’s main role is breaking down food, making option C correct.',
            'study_tip' => 'Stomach = digestion + acid.',
        ],

        [
            'id' => 8,
            'extract' => 'The skin acts as a protective barrier for the body.',
            'question' => 'What is the main function of the skin?',
            'optionA' => 'Protection',
            'optionB' => 'Digestion',
            'optionC' => 'Filtration',
            'optionD' => 'Circulation',
            'optionE' => 'Respiration',
            'optionF' => 'Movement',
            'optionG' => 'Hormone production',
            'correct_answer' => 'A',
            'rationale' => 'The skin protects the body from external threats such as pathogens, chemicals, and physical injury. It also helps regulate temperature and allows sensory perception. Although it has multiple roles, protection is its primary function. Other options relate to different systems, making option A the best answer.',
            'study_tip' => 'Skin = barrier + protection.',
        ],

        [
            'id' => 9,
            'extract' => 'The pancreas produces insulin and other important enzymes and hormones that help break down foods.',
            'question' => 'Which organ is responsible for producing insulin?',
            'optionA' => 'Spleen',
            'optionB' => 'Liver',
            'optionC' => 'Pancreas',
            'optionD' => 'Gallbladder',
            'optionE' => 'Adrenal gland',
            'optionF' => 'Thyroid',
            'optionG' => 'Thymus',
            'correct_answer' => 'C',
            'rationale' => 'The pancreas has a dual role as both an endocrine and exocrine organ. Its endocrine function involves producing insulin to regulate blood sugar levels. Without insulin, the body cannot properly process glucose for energy. Therefore, option C is correct.',
            'study_tip' => 'Pancreas = Blood sugar regulation.',
        ],

        [
            'id' => 10,
            'extract' => 'The small intestine is the site where most chemical digestion and nutrient absorption occur.',
            'question' => 'Where does most nutrient absorption take place?',
            'optionA' => 'Stomach',
            'optionB' => 'Large intestine',
            'optionC' => 'Esophagus',
            'optionD' => 'Small intestine',
            'optionE' => 'Liver',
            'optionF' => 'Mouth',
            'optionG' => 'Rectum',
            'correct_answer' => 'D',
            'rationale' => 'While digestion starts in the mouth and stomach, the small intestine is specially designed with villi and microvilli to maximize the absorption of nutrients into the bloodstream. This makes option D the correct answer.',
            'study_tip' => 'Small intestine = Nutrient uptake.',
        ],

        [
            'id' => 11,
            'extract' => 'The large intestine absorbs water and electrolytes from indigestible food matter and transmits useless waste material from the body.',
            'question' => 'What is a primary function of the large intestine?',
            'optionA' => 'Protein digestion',
            'optionB' => 'Water absorption',
            'optionC' => 'Bile storage',
            'optionD' => 'Oxygen transport',
            'optionE' => 'Blood filtration',
            'optionF' => 'Enzyme production',
            'optionG' => 'Muscle contraction',
            'correct_answer' => 'B',
            'rationale' => 'The large intestine’s main job is to recover water and electrolytes from the remaining food residue before it is excreted as waste. This prevents dehydration. Option B is the correct choice.',
            'study_tip' => 'Large intestine = Water recovery.',
        ],

        [
            'id' => 12,
            'extract' => 'The gallbladder is a small organ where bile is stored and concentrated before it is released into the small intestine.',
            'question' => 'What is the function of the gallbladder?',
            'optionA' => 'Produce bile',
            'optionB' => 'Store bile',
            'optionC' => 'Digest fiber',
            'optionD' => 'Filter lymph',
            'optionE' => 'Store glucose',
            'optionF' => 'Create red blood cells',
            'optionG' => 'Pump lymph',
            'correct_answer' => 'B',
            'rationale' => 'Note that the liver produces bile, but the gallbladder stores and concentrates it until it is needed for fat digestion. This makes option B the correct answer.',
            'study_tip' => 'Liver makes it, Gallbladder stores it.',
        ],

        [
            'id' => 13,
            'extract' => 'Muscles contract and relax to allow movement of the body and its internal organs.',
            'question' => 'What is the primary function of the muscular system?',
            'optionA' => 'Support structure',
            'optionB' => 'Movement',
            'optionC' => 'Waste removal',
            'optionD' => 'Sensory input',
            'optionE' => 'Heat insulation',
            'optionF' => 'Chemical storage',
            'optionG' => 'Air filtration',
            'correct_answer' => 'B',
            'rationale' => 'Muscle tissues are specialized for contraction. Whether it is moving limbs or pumping blood (cardiac muscle), movement is the defining role. Option B is correct.',
            'study_tip' => 'Muscles = Contraction + Movement.',
        ],

        [
            'id' => 14,
            'extract' => 'The thyroid gland regulates the body’s metabolic rate, heart and digestive function, and muscle control.',
            'question' => 'Which gland primarily regulates metabolism?',
            'optionA' => 'Pituitary',
            'optionB' => 'Adrenal',
            'optionC' => 'Thyroid',
            'optionD' => 'Pineal',
            'optionE' => 'Parathyroid',
            'optionF' => 'Salivary',
            'optionG' => 'Sweat gland',
            'correct_answer' => 'C',
            'rationale' => 'The thyroid gland produces hormones (T3 and T4) that dictate how quickly the body uses energy. This regulation of metabolism makes option C the correct answer.',
            'study_tip' => 'Thyroid = Metabolic thermostat.',
        ],

        [
            'id' => 15,
            'extract' => 'The spleen acts as a filter for blood as part of the immune system.',
            'question' => 'What is the role of the spleen in the human body?',
            'optionA' => 'Oxygenate blood',
            'optionB' => 'Filter blood and support immunity',
            'optionC' => 'Digest fats',
            'optionD' => 'Store calcium',
            'optionE' => 'Regulate sleep',
            'optionF' => 'Produce saliva',
            'optionG' => 'Pumping blood',
            'correct_answer' => 'B',
            'rationale' => 'The spleen recycles old red blood cells and stores white blood cells, acting as a critical filter for the immune system. Option B is the correct answer.',
            'study_tip' => 'Spleen = Immune filter.',
        ],

        [
            'id' => 16,
            'extract' => 'The bladder is a hollow muscular organ that collects and stores urine from the kidneys.',
            'question' => 'What is the primary function of the bladder?',
            'optionA' => 'Filter blood',
            'optionB' => 'Produce urine',
            'optionC' => 'Store urine',
            'optionD' => 'Digest toxins',
            'optionE' => 'Circulate fluids',
            'optionF' => 'Absorb nutrients',
            'optionG' => 'Regulate pH',
            'correct_answer' => 'C',
            'rationale' => 'While the kidneys create urine, the bladder serves as the reservoir that holds it until it is excreted. Thus, option C is correct.',
            'study_tip' => 'Bladder = Storage tank.',
        ],

        [
            'id' => 17,
            'extract' => 'The esophagus is a muscular tube that connects the throat to the stomach.',
            'question' => 'What is the main role of the esophagus?',
            'optionA' => 'Chemical digestion',
            'optionB' => 'Gas exchange',
            'optionC' => 'Transport food to the stomach',
            'optionD' => 'Filter air',
            'optionE' => 'Produce enzymes',
            'optionF' => 'Absorb water',
            'optionG' => 'Sense taste',
            'correct_answer' => 'C',
            'rationale' => 'The esophagus uses peristalsis (muscle contractions) to move food from the mouth to the stomach. It does not perform significant digestion or absorption. Option C is correct.',
            'study_tip' => 'Esophagus = Food highway.',
        ],

        [
            'id' => 18,
            'extract' => 'The diaphragm is the primary muscle used in the process of inhalation.',
            'question' => 'Which muscle is most important for breathing?',
            'optionA' => 'Bicep',
            'optionB' => 'Heart',
            'optionC' => 'Diaphragm',
            'optionD' => 'Quadriceps',
            'optionE' => 'Deltoid',
            'optionF' => 'Gluteus maximus',
            'optionG' => 'Trapezius',
            'correct_answer' => 'C',
            'rationale' => 'The diaphragm contracts to create a vacuum that pulls air into the lungs. It is the essential muscle for the respiratory system, making option C correct.',
            'study_tip' => 'Diaphragm = Breathing engine.',
        ],

        [
            'id' => 19,
            'extract' => 'Red blood cells carry oxygen from the lungs to the rest of the body.',
            'question' => 'What is the primary function of red blood cells?',
            'optionA' => 'Fight infection',
            'optionB' => 'Clot blood',
            'optionC' => 'Transport oxygen',
            'optionD' => 'Produce hormones',
            'optionE' => 'Filter waste',
            'optionF' => 'Store minerals',
            'optionG' => 'Digest glucose',
            'correct_answer' => 'C',
            'rationale' => 'Red blood cells contain hemoglobin, which binds to oxygen. Their main purpose is delivery of this oxygen to tissues. Option C is the correct answer.',
            'study_tip' => 'Red cells = Oxygen couriers.',
        ],

        [
            'id' => 20,
            'extract' => 'Veins are blood vessels that carry blood toward the heart.',
            'question' => 'What is the function of veins?',
            'optionA' => 'Carry blood away from the heart',
            'optionB' => 'Pump blood',
            'optionC' => 'Carry blood toward the heart',
            'optionD' => 'Filter blood',
            'optionE' => 'Produce blood cells',
            'optionF' => 'Absorb nutrients',
            'optionG' => 'Store oxygen',
            'correct_answer' => 'C',
            'rationale' => 'While arteries carry blood away from the heart, veins return it to the heart to be re-oxygenated. This makes option C the correct choice.',
            'study_tip' => 'Veins = Return to heart.',
        ],

    ];

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
