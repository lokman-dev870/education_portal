<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('career'); // Medicina, Enfermería, Odontología, etc.
            $table->string('university')->nullable();
            $table->integer('semester')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->json('interests')->nullable(); // Áreas de interés
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
