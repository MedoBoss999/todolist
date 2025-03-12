<?php

// app/Notifications/TaskStarted.php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskStarted extends Notification
{
    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail']; // Envoyer un email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('La tâche a commencé')
            ->line('La tâche "' . $this->task->title . '" a commencé.')
            ->line('Démarrez la tâche et suivez son évolution.')
            ->action('Voir la tâche', url('/tasks/' . $this->task->id));  // URL de la tâche
    }
}
