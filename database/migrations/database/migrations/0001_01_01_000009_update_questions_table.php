<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            if (! Schema::hasColumn('questions', 'is_marked')) {
                $table->boolean('is_marked')->default(false);
            }
            if (! Schema::hasColumn('questions', 'study_tip')) {
                $table->string('study_tip')->nullable();
            }
            if (! Schema::hasColumn('questions', 'extract')) {
                $table->text('extract')->nullable();
            }
            if (! Schema::hasColumn('questions', 'optionE')) {
                $table->string('optionE')->nullable();
            }
            if (! Schema::hasColumn('questions', 'optionF')) {
                $table->string('optionF')->nullable();
            }
            if (! Schema::hasColumn('questions', 'optionG')) {
                $table->string('optionG')->nullable();
            }
            if (! Schema::hasColumn('questions', 'question_type')) {
                $table->string('question_type')->default('regular');
            }
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['is_marked', 'study_tip', 'extract', 'optionE', 'optionF', 'optionG', 'question_type']);
        });
    }
};
