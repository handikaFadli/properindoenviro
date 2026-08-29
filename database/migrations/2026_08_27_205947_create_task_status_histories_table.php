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
        Schema::create('task_status_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('task_id')
                ->constrained('tasks')
                ->cascadeOnDelete();

            $table->foreignId('task_status_id')
                ->constrained('task_statuses')
                ->restrictOnDelete();

            $table->text('note')
                ->nullable();

            $table->foreignId('changed_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();

            $table->index([
                'task_id',
                'created_at'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_status_histories');
    }
};
