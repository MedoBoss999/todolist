<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Notifications\TaskCompletedNotification;
use  App\Jobs\CheckExpiredTasks;
use App\Jobs\SendTaskStartedNotification;
use Illuminate\Support\Facades\Validator;
use App\Notifications\TaskStarted;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function startTask(Task $task)
    {
        // Vérifier que la tâche appartient à l'utilisateur authentifié
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
    
        // Marquer la tâche comme commencée
        $task->status = 'in_progress';
        $task->start_date = now();  // Mettre à jour la date de début
        $task->save();
    
        // Exécuter le job pour envoyer la notification de début de tâche
        SendTaskStartedNotification::dispatch($task);
    
        // Rediriger avec un message de succès
        return redirect()->route('tasks.index')->with('success', 'La tâche a commencé.');
    }

    public function index(Request $request)
    {
        $statusFilter = $request->input('status');

        // Récupérer les tâches de l'utilisateur connecté
        $query = Task::where('user_id', Auth::id());

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        // Appliquer la pagination
        $tasks = $query->paginate(10);


        return view('tasks.index', compact('tasks', 'statusFilter'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        // Définition des règles de validation
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:pending,in_progress,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ];

        // Création de l'instance du validateur
        $validator = Validator::make($request->all(), $rules);

        // Vérification si la validation échoue
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Récupération des données validées
        $validatedData = $validator->validated();

        // Combinaison des dates et heures en objets DateTime
        $startDateTime = Carbon::parse("{$validatedData['start_date']} {$validatedData['start_time']}");
        $endDateTime = Carbon::parse("{$validatedData['end_date']} {$validatedData['end_time']}");

        // Vérification que la date et l'heure de fin sont postérieures à celles de début
        if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
            return redirect()->back()
                ->withErrors(['end_time' => 'La date et l\'heure de fin doivent être postérieures à la date et l\'heure de début.'])
                ->withInput();
        }

        try {
            $task = new Task();
            $task->user_id = Auth::id();
            $task->title = $validatedData['title'];
            $task->description = $validatedData['description'];
            $task->status = $validatedData['status'];
            $task->start_date = $validatedData['start_date'];
            $task->end_date = $validatedData['end_date'];
            $task->start_time = $validatedData['start_time'] ?? null;
            $task->end_time = $validatedData['end_time'] ?? null;
            $task->save();



            return redirect()->route('tasks.index')->with('success', 'Tâche créée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la tâche : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue.');
        }
    }


    public function edit(Request $request, Task $task)
    {
        // Vérifie si l'utilisateur est bien celui qui a créé la tâche
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        // Validation des champs start_time et end_time
        $request->validate([
            'start_time' => ['nullable', 'date_format:H:i'],  // Valide HH:MM
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],  // Vérifie que l'heure de fin est après l'heure de début

        ]);

        // Si la validation passe, afficher la vue
        return view('tasks.edit', compact('task'));
    }


    public function show(Task $task)
    {
        // Vérifie que l'utilisateur connecté est bien le propriétaire de la tâche
        if ($task->user_id !== Auth::id()) {
            abort(403, "Vous n'avez pas accès à cette tâche.");
        }

        return view('tasks.show', compact('task'));
    }
    public function update(Request $request, Task $task)
    {
        // $this->authorize('update', $task);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:pending,in_progress,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',

        ]);

        $task->update($validatedData);

        return redirect()->route('tasks.index')->with('success', 'Tâche mise à jour avec succès.');
    }
    public function markAsCompleted(Task $task)
    {
        $task->status = 'completed';  // Mettre la tâche en "complétée"
        $task->save();

        // Envoyer la notification à l'utilisateur
        $task->user->notify(new TaskCompletedNotification($task));

        return back()->with('success', 'La tâche a été marquée comme terminée et la notification envoyée.');
    }
   
    public function completeTask(Task $task)
    {
        // Vérifier que la tâche appartient à l'utilisateur authentifié
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
    
        // Marquer la tâche comme terminée
        $task->status = 'completed';
        $task->save();
    
        // Exécuter le job pour envoyer la notification
        CheckExpiredTasks::dispatch($task);
    
        // Rediriger avec un message de succès
        return redirect()->route('tasks.index')->with('success', 'La tâche est terminée.');
    }


    public function destroy(Task $task)
    {
        // $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée avec succès.');
    }
}
