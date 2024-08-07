<?php

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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('cid');
            $table->string('name');
            $table->string('email');

            $table->string('class_x_school_name')->nullable();
            $table->year('class_x_completion_year')->nullable();
            $table->json('class_x_marks')->nullable();
            $table->double('class_x_avg')->nullable();

            $table->string('class_xii_school_name')->nullable();
            $table->enum('class_xii_stream', ['science', 'commerce', 'arts'])->nullable();
            $table->year('class_xii_completion_year')->nullable();
            $table->json('class_xii_marks')->nullable();
            $table->double('class_xii_avg')->nullable();

            $table->string('university_or_college_name')->nullable();
            $table->string('university_or_college_course_name')->nullable();
            $table->year('university_or_college_completion_year')->nullable();
            $table->double('university_or_college_percentage')->nullable();

            $table->string('masters_institution_name')->nullable();
            $table->string('masters_course_name')->nullable();
            $table->year('masters_completion_year')->nullable();
            $table->double('masters_percentage')->nullable();

            $table->double('final_score')->nullable();

            $table->boolean('is_shortlisted');

            $table->foreignId('vacancy_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
