<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskNotification;
use Illuminate\Console\Command;

class SendTaskDeadlineReminders extends Command
{
    protected $signature = 'tasks:send-deadline-reminders';
    protected $description = 'Send one daily deadline reminder per eligible task';

    public function handle(): int
    {
        Task::with(['pic.user', 'priority', 'status'])->whereHas('status', fn ($query) => $query->where('code', '!=', 'completed'))->whereNotNull('deadline')->each(function (Task $task): void {
            $days = today()->diffInDays($task->deadline, false);
            $reminder = match ($days) { 3 => 'H-3', 1 => 'H-1', 0 => 'H', default => $days < 0 ? 'overdue' : null };
            $user = $task->pic?->user;

            if (! $reminder || ! $user || $user->notifications()->where('data->task_id', $task->id)->where('data->reminder', $reminder)->exists()) return;

            $message = $reminder === 'overdue' ? "Tugas {$task->task_code} telah melewati deadline." : "Pengingat {$reminder}: tugas {$task->task_code} memiliki deadline {$task->deadline->format('d M Y')}.";
            $user->notify(new TaskNotification($task, 'Deadline Reminder', $message, $reminder));
        });

        return self::SUCCESS;
    }
}
