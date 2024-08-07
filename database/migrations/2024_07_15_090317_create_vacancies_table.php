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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('position_title');
            $table->double('benchmark');
            $table->integer('number_of_slots');
            $table->date('close_datetime');
            $table->enum('closure', ["Auto", "Manual"]);
            $table->json('employment_type');
            $table->json('qualifications');
            $table->json('salary_and_benefits');
            $table->enum('type', ["Internal", "External", "Experience"]);
            $table->enum('status', ["Open", "Closed", "Shortlisted"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
