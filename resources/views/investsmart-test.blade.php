<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - InvestSmart Test</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        h1 {
            color: #ff5722;
            margin-top: 0;
        }
        #invest-smart-app {
            margin-top: 2rem;
            min-height: 400px;
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 1rem;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/js/components/InvestSmart/index.js'])
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>InvestSmart Test Page</h1>
            <p>This is a standalone test page for the InvestSmart Vue component.</p>
            
            <!-- InvestSmart Game Container -->
            <div id="invest-smart-app"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Test page loaded');
            console.log('App container exists:', !!document.getElementById('invest-smart-app'));
        });
    </script>
</body>
</html>
