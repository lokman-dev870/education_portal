<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type'); // apuntes, presentacion, articulo, guia
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type'); // pdf, docx, pptx, etc.
            $table->integer('file_size'); // en bytes
            $table->string('career')->nullable();
            $table->string('subject')->nullable(); // Materia/asignatura
            $table->integer('semester')->nullable();
            $table->json('tags')->nullable();
            $table->integer('downloads')->default(0);
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
