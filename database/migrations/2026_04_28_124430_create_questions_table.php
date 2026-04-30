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
            $table->string('optionA');
            $table->string('optionB');
            $table->string('optionC');
            $table->string('optionD');
            $table->string('optionE')->nullable();
            $table->string('optionF')->nullable();
            $table->string('optionG')->nullable();
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
