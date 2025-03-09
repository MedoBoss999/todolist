<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Projet</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(19, 27, 39) !important;
        }

        .inline-flex .items-center {
            display: flex;
            align-items: center;
            gap: 5px;
            /* Espace entre la case et le texte */
        }


        header {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            text-align: center;
        }

        .big-container {
            display: flex;
            max-width: 100% !important;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 60%;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            left: 10%;
        }


        h1 {
            margin-top: 0;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: background-color 0.3s;
            background-color: #fff;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        .rembnr {
            margin-bottom: 10px;
            background-color: #2980b9 left: 0
        }

        input:focus,
        textarea:focus,
        select:focus {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            outline: none;
        }

        input[type="submit"] {
            background-color: #3498db;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        a {
            text-decoration: none;
            color: #3498db;
        }

        a:hover {
            text-decoration: underline;
            color: black !important;
        }

        button {
            background-color: #3498db !important;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2980b9 !important;
        }

        a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .inputy {
            color: rgb(22, 20, 20) !important;
        }
    </style>
    <x-guest-layout>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <h1>TO DO LIST :!: </h1>
        <h2>Connectez Vous!</h2>
        <div>
            <div class="container">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label class="inputy" for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label class="inputy" for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rembnr" name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-primary-button class="ms-3">
                            {{ __('Log in') }}
                        </x-primary-button>
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                            href="{{ route('register') }}">
                            {{ __('SubsCribE') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </x-guest-layout>

    </body>
