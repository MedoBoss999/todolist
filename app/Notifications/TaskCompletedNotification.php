<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TaskCompletedNotification extends Notification
{
    use Queueable;

    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail']; // Tu peux aussi ajouter 'database' pour enregistrer dans la base de données
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Tâche terminée')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('La tâche "' . $this->task->title . '" a été complétée.')
            ->action('Voir la tâche', url('/tasks/' . $this->task->id))
            ->line('Merci d\'utiliser notre application!');
    }

    public function toArray($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'message' => 'La tâche "' . $this->task->title . '" a été complétée.',
        ];
    }
}
