<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Task $task, private readonly string $type, private readonly string $message, private readonly ?string $reminder = null) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        return ['type' => $this->type, 'task_id' => $this->task->id, 'task_code' => $this->task->task_code, 'title' => $this->task->title, 'message' => $this->message, 'url' => route('tasks.show', $this->task, false), 'priority' => $this->task->priority?->name, 'deadline' => $this->task->deadline?->toDateString(), 'reminder' => $this->reminder];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new MailMessage)->subject("[{$data['task_code']}] {$data['type']}")->line($data['message'])->line("Deadline: {$data['deadline']}")->action('Lihat Tugas', route('tasks.show', $this->task));
    }
}
