<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tâches</title>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;700&display=swap" rel="stylesheet">
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    @vite('resources/css/app.css')
    @if (!Request::is('login') && !Request::is('register'))
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif

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

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: #ffffff;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        a,
        .btn {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }

        .btn {
            background-color: #3498db;
            color: #ffffff;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: #ffffff;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s;
            margin-left: 10px;
            margin-right: 10px;
            font-size: 14px;
        }

        .btn-del {
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            border: none;
            margin-left: 10px;
            margin-right: 10px;
            font-size: 14px;
            cursor: pointer;
            background-color: #e26b5e;
            color: #ffffff;
            transition: background-color 0.3s;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;

        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .container {
            display: flex;
            justify-content: space-between;
        }

        li {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: inline-block;
        }

        .entete {
            flex-grow: 1;
            text-align: center;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            header .btn-danger {
                margin-left: 0;
                margin-right: 0;
                font-size: 16px;
                margin-bottom: 10px;
                margin-top: 0;
                padding: 10px 0;
                cursor: pointer;
                left: 0;
            }

            header {
                display: flex;
                text-align: center;
                align-items: center;
                justify-content: center;
            }

            .btn {
                font-size: 14px;
                padding: 6px 10px;
            }

            .btn-container {
                display: flex;
                flex-direction: column;
                gap: 10px;
                align-items: center;
            }

            .btn-retour {
                margin-top: 15px;
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>


<body>
    <header>
        <div class="container">

            <div class="entete">
                @if (Auth::check())
                    <h3 class="text-3xl font-bold text-center mt-6 mb-4 leading-tight">Bienvenue!</h2>
                @endif
                <h2 class="text-4xl font-bold text-center mt-6 mb-4 leading-tight">Planification de mes tâches</h1>
                <a href="{{ route('tasks.create') }}" class="btn">Créer une Nouvelle Tâche</a>
            </div>

            <div class="logout">

                @if (Auth::check())
                    <!-- L'utilisateur est connecté -->
                    {{--  <form action="{{ route('logout') }}" method="POST" <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-danger btn-link nav-link "  >Se déconnecter</button>
                        </form>
                        </li>
                    </form>
                   
                @else
                    <!-- L'utilisateur est déconnecté -->
                    <a href="{{ route('login') }}" class="btn btn-primary">Se Connecter</a>
                    <a href="{{ route('register') }}" class="btn btn-success">S'inscrire</a>
                @endif --}}
                    <form method="POST" action="{{ route('logout') }}">
                        <li class="nav-item">
                            @csrf
                            <!-- Utiliser les classes Tailwind pour la responsivité -->
                            <button type="submit"
                                class=" btn-danger btn bg-blue-500 text-white py-2 px-4 rounded text-sm sm:text-base sm:py-3 sm:px-6 hover:bg-blue-600">
                                Logout
                            </button>
                        </li>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="btn bg-green-500 text-white py-2 px-4 rounded text-sm sm:text-base sm:py-3 sm:px-6 hover:bg-green-600">Se
                        connecter</a>
                    <a href="{{ route('register') }}"
                        class="btn bg-purple-500 text-white py-2 px-4 rounded text-sm sm:text-base sm:py-3 sm:px-6 hover:bg-purple-600">S'inscrire</a>
                @endif
            </div>
        </div>
    </header>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th class="px-4 py-2 hidden sm:table-cell">Description</th>
                <th>Statut</th>
                <th>Date de Début</th>
                <th>Heure début</th>
                <th class="px-4 py-2 hidden sm:table-cell">Date de Fin</th>
                <th class="px-4 py-2 hidden sm:table-cell">Heure de Fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($tasks))
                @if ($tasks->isEmpty())
                    <td colspan="4">Aucune tâche disponible. 
                        veuillez en creer une nouvelle.</td>
                    </td>
                @else
                    @foreach ($tasks as $task)
                        <tr>
                            <td><a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a></td>
                            <td class="px-4 py-2 hidden sm:table-cell">{{ $task->description }}</td>
                            <td>{{ $task->status }}</td>
                            <td>{{ $task->start_date }}</td>
                            <td>{{ $task->start_time }}</td>
                            <td class="px-4 py-2 hidden sm:table-cell">{{ $task->end_date }}</td>
                            <td class="px-4 py-2 hidden sm:table-cell">{{ $task->end_time }}</td>
                            <td>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn">Modifier</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class=" btn-del">🗙</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @else
                <tr>
                    <td colspan="4">Aucune tâche disponible.
                        veuillez vous inscrire ou vous connecter pour voir les tâches.</td>
                    </td>
                </tr>

            @endif

        </tbody>
    </table>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

</body>

</html>
