<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Questions;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $paths = [
            'seeders/data/teas.csv',
            'seeders/data/hesi.csv',
            'seeders/data/nex.csv',
        ];
        foreach ($paths as $key => $path) {
            $csvPath = database_path($path);

            if (! file_exists($csvPath)) {
                $this->command->error("❌ CSV file not found at: {$csvPath}");
                $this->command->info("Make sure the file is in this location {$csvPath}.");

                return;
            }
            $this->examseeder($csvPath);

        }
        $this->command->info('📝 Check storage/logs/laravel.log for detailed skipped exams and errors.');
    }

    private function examseeder(string $csvPath)
    {
        $handle = fopen($csvPath, 'r');
        fgetcsv($handle); // Skip header

        $count = 0;
        $skipped = 0;
        $failed = 0;

        $this->command->info('📂 Starting question seeding from: '.basename($csvPath));

        while (($row = fgetcsv($handle)) !== false) {
            try {
                if (count($row) < 15 || empty(trim($row[0] ?? ''))) {
                    $skipped++;

                    continue;
                }

                $course = trim($row[0] ?? '');
                $subject = trim($row[1] ?? '');
                $exam = trim($row[2] ?? '');
                $question = trim($row[3] ?? '');
                $extract = trim($row[4] ?? '');
                $optionA = trim($row[5] ?? '');
                $optionB = trim($row[6] ?? '');
                $optionC = trim($row[7] ?? '');
                $optionD = trim($row[8] ?? '');
                $optionE = trim($row[9] ?? '');
                $optionF = trim($row[10] ?? '');
                $optionG = trim($row[11] ?? '');
                $correct_answer = strtoupper(trim($row[12] ?? ''));
                $rationale = trim($row[13] ?? '');
                $study_tip = trim($row[14] ?? '');

                $courseModel = Course::firstOrCreate(['name' => $course], ['slug' => Str::slug($course)]);

                $subjectModel = Subject::firstOrCreate([
                    'name' => $subject,
                    'course_id' => $courseModel->id,
                ], ['slug' => Str::slug($subject)]);

                // check if exam exits
                $examModel = Exam::firstOrCreate([
                    'name' => $exam,
                    'subject_id' => $subjectModel->id,
                ], ['slug' => Str::slug($exam)]);

                // check if question exits with exam id,the question and the url
                do {
                    $random_number = random_int(10000, 9999999);
                    $question_slug = Str::limit(Str::slug($question), 80).'-'.$random_number;
                } while (Questions::where('slug', $question_slug)->exists());

                $questionModel = Questions::firstOrCreate([
                    'question' => $question, 'extract' => $extract, 'exam_id' => $examModel->id,
                ], [
                    'optionA' => $optionA, 'optionB' => $optionB, 'optionC' => $optionC, 'optionD' => $optionD, 'optionE' => $optionE, 'optionF' => $optionF, 'optionG' => $optionG, 'correct_answer' => $correct_answer, 'rationale' => $rationale, 'study_tip' => $study_tip,
                    'slug' => $question_slug,
                ]);

                $this->command->info("   ✅ Successfully inserted : {$questionModel->slug} ");
                $count++;

            } catch (\Exception $e) {
                $failed++;
                
                Log::error('Question Seeder Error: '.$e->getMessage());
                Log::error($e->getTraceAsString());

                $this->command->error($e->getMessage());
            }
        }

        fclose($handle);
        // Final Summary
        $this->command->info("\n🎉 Question seeding completed for ".basename($csvPath));
        $this->command->info("   ✅ Successfully inserted : {$count} questions");
        $this->command->warn("   ⚠️  Skipped               : {$skipped} rows");
        if ($failed > 0) {
            $this->command->error("   ❌ Failed                : {$failed} rows");
        }

    }
}
