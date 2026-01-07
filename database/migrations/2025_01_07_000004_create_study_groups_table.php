<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // creador
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('subject')->nullable();
            $table->string('career')->nullable();
            $table->integer('max_members')->default(10);
            $table->boolean('is_public')->default(true);
            $table->string('meeting_link')->nullable(); // Zoom, Meet, etc.
            $table->timestamps();
        });

        Schema::create('study_group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_group_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role')->default('member'); // admin, member
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamps();
            $table->unique(['study_group_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_group_members');
        Schema::dropIfExists('study_groups');
    }
};
