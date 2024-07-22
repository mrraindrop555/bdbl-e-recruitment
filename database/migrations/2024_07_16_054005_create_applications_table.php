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

            $table->string('class_x_school_name');
            $table->year('class_x_completion_year');
            $table->json('class_x_marks');
            $table->double('class_x_avg');

            $table->string('class_xii_school_name');
            $table->enum('class_xii_stream', ['science', 'commerce', 'arts']);
            $table->year('class_xii_completion_year');
            $table->json('class_xii_marks');
            $table->double('class_xii_avg');

            $table->double('final_score');

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
