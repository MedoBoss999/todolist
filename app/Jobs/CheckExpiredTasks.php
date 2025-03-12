<?php

namespace App\Jobs;

use App\Models\Task;
use App\Notifications\TaskCompleted;
use App\Notifications\TaskCompletedNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class CheckExpiredTasks implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public function handle()
    {
        $tasks = Task::whereNotNull('completed_at')
                     ->where('completed_at', '<=', Carbon::now())
                     ->where('status', '!=', 'completed')
                     ->get();

        foreach ($tasks as $task) {
            // Marquer la tâche comme terminée
            $task->status = 'completed';
            $task->save();

            // Envoyer une notification
            $task->user->notify(new TaskCompletedNotification($task));
        }
    }
}
