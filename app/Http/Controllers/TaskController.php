<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
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
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:pending,in_progress,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
        ]);
        try {
            $task = new Task();
            $task->user_id = Auth::id();
            $task->title = $validatedData['title'];
            $task->description = $validatedData['description'];
            $task->status = $validatedData['status'];
            $task->start_date = $validatedData['start_date'];
            $task->end_date = $validatedData['end_date'];
            $task->start_time = $validatedData['start_time']?? null;
            $task->end_time = $validatedData['end_time']?? null;
            $task->save();



            return redirect()->route('tasks.index')->with('success', 'Tâche créée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la tâche : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue.');
        }
    }


   /*  public function edit(Task $task)
    {
        //if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        return view('tasks.edit', compact('task'));
    } */

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

    public function destroy(Task $task)
    {
       // $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée avec succès.');
    }
}
