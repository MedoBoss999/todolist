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
            background-color:   rgb(19, 27, 39) !important;
        }
        .mt-1{
            color: black !important;
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

        .container {
            
            
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

        input,
        textarea,
        select {
            padding: 10px;
            /* margin-bottom: 15px; */
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: background-color 0.3s;
            background-color: #fff;
            color: black !important
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
            background-color: #3498db !important ;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
.inputy{
    color: rgb(22, 20, 20) !important;
}
        button:hover {
            background-color: #2980b9 !important ;
        }


        a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
    <x-guest-layout>
        <h1>TO DO LIST :!: </h1>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <div>
            <div>
                <div class="container">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label class="inputy"  for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label class="inputy" for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label class="inputy" for="password" :value="__('Password')" />

                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                required autocomplete="new-password" />

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label class="inputy" for="password_confirmation" :value="__('Confirm Password')" />

                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>

                            <x-primary-button class="ms-4">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-guest-layout>
