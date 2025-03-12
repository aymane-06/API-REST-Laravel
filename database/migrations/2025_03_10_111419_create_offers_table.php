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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->string('company_name');
            $table->decimal('salary', 10, 2)->nullable();
            $table->enum('job_type', ['full-time', 'part-time', 'contract', 'freelance', 'internship']);
            $table->enum('experience_level', ['entry', 'junior', 'mid', 'senior', 'executive'])->nullable();
            $table->json('skills')->nullable();
            $table->date(column: 'application_deadline')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
