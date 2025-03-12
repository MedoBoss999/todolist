<?php

// app/Jobs/SendTaskStartedNotification.php

namespace App\Jobs;

use App\Models\Task;
use App\Notifications\TaskStarted;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTaskStartedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function handle()
    {
        // Envoyer la notification
        $this->task->user->notify(new TaskStarted($this->task));
    }
}
