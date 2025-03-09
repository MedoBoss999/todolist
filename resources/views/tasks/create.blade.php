<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Projet</title>
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

        form {
            width: 60%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #3498db;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2980b9;
        }

        a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header>
        <h1>Créer un Nouveau Projet</h1>
    </header>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required>{{ old('description') }}</textarea>

        <label for="status">Statut :</label>
        <select id="status" name="status" required>
            <option value="" disabled selected>Choisissez un statut</option>
            <option value="pending">En Attente</option>
            <option value="in_progress">En Cours</option>
            <option value="completed">Complété</option>
        </select>

        <label for="start_date">Date de Début :</label>
        <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required>

        <label for="end_date">Date de Fin :</label>
        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required>

        <label for="start_time">Heure de début :</label>
        <input type="time" id="start_time" name="start_time"
            value="{{ old('start_time', isset($task) ? $task->start_time : '') }}" required>

        <label for="end_time">Heure de fin :</label>
        <input type="time" id="end_time" name="end_time"
            value="{{ old('end_time', isset($task) ? $task->end_time : '') }}" required>

        <button type="submit">Créer la Tâche</button>
    </form>


    <a href="{{ route('tasks.index') }}">Retour à la Liste des Projets</a>
</body>

</html>
