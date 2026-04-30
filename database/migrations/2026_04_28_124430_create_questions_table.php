<?php

use App\Models\Exam;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Exam::class);
            $table->text('question');
            $table->text('extract')->nullable();
            $table->text('optionA');
            $table->text('optionB');
            $table->text('optionC');
            $table->text('optionD');
            $table->text('optionE')->nullable();
            $table->text('optionF')->nullable();
            $table->text('optionG')->nullable();
            $table->string('correct_answer');
            $table->text('rationale');
            $table->text('study_tip')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
