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
        Schema::create('department_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')
                    ->constrained('departments')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreignId('course_id')
                    ->constrained('courses')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->integer('minimum_grade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_requirements');
    }
};
