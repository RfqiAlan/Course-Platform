<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')
                ->constrained('lessons')
                ->cascadeOnDelete();

            $table->enum('type', ['text', 'file', 'video', 'quiz']);
            $table->string('title')->nullable();

            // text: HTML dari editor
            $table->longText('body')->nullable();

            // file & video
            $table->string('file_path')->nullable();
            $table->string('video_path')->nullable();

            // quiz terhubung
            $table->foreignId('quiz_id')
                ->nullable()
                ->constrained('quizzes')
                ->nullOnDelete();

            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
