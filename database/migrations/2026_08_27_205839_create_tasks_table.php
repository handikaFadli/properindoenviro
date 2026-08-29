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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->string('task_code', 20)
                ->unique();

            $table->string('title', 150);

            $table->text('description')
                ->nullable();

            $table->foreignId('pic_id')
                ->constrained('employees')
                ->restrictOnDelete();

            $table->date('deadline');

            $table->foreignId('task_status_id')
                ->constrained('task_statuses')
                ->restrictOnDelete();

            $table->foreignId('task_priority_id')
                ->constrained('task_priorities')
                ->restrictOnDelete();

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamp('completed_at')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('deadline');
            $table->index('pic_id');
            $table->index('task_status_id');
            $table->index('task_priority_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
