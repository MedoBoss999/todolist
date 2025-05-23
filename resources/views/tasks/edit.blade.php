<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Projet</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        header {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            text-align: center;
        }
        .container {
            width: 60%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            margin-top: 0;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #3498db;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #2980b9;
        }
        a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Modifier le Projet</h1>
    </header>
    <div class="container">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="title">Titre :</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required>{{ old('description', $task->description) }}</textarea>
            <label for="status">Statut :</label>
            <select id="status" name="status" required>
                <option value="pending" {{ old('status', $task->status) === 'pending'?'selected' : '' }}>En Attente</option>
                <option value="in_progress" {{ old('status', $task->status) === 'in_progress'?'selected' : '' }}>En Cours</option>
                <option value="completed" {{ old('status', $task->status) === 'completed'?'selected' : '' }}>Terminé</option>
            </select>
            <label for="start_date">Date de Début :</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $task->start_date) }}" required>
            <label for="start_time">Heure de Début (optionnelle):</label>
            <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $task->start_time) }}">
            <label for="end_date">Date de Fin :</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $task->end_date) }}" required>
            <label for="end_time">Heure de Fin (optionnelle):</label>
            <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $task->end_time) }}">
            <button type="submit">Mettre à Jour</button>
        </form>
        <a href="{{ route('tasks.index') }}">Retour à la Liste des Projets</a>
    </div>
    @if ($errors->any())
    <div class="bg-red-500 text-white p-2 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        
</body>
</html>