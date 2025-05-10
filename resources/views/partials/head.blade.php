<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@auth
<meta name="user-role" content="{{ Auth::check() && method_exists(Auth::user(), 'hasRole') ? (Auth::user()->hasRole('faculty') ? 'faculty' : (Auth::user()->hasRole('admin') ? 'admin' : 'student')) : 'student' }}">
<meta name="user-name" content="{{ Auth::user()->name }}">
<meta name="user-id" content="{{ Auth::user()->id }}">
@endauth

<title>{{ $title ?? 'GameLearnPro' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
@mingles
{{-- @stack('/mingles') --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.39.1/src-noconflict/ace.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.39.1/src-noconflict/mode-python.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.39.1/src-noconflict/theme-monokai.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.39.1/src-noconflict/snippets/python.js"></script>
<link href="https://cdn.jsdelivr.net/npm/ace-builds@1.39.1/css/ace.min.css" rel="stylesheet">

<!-- Recipe Builder Fixes -->
<script src="{{ asset('js/recipe-badge-fix.js') }}"></script>
<link href="{{ asset('css/modal-fix.css') }}" rel="stylesheet">

<!-- Chemistry Lab Fixes -->
<link rel="preload" href="{{ asset('css/chemistry-lab-drag-fix.css') }}" as="style">
<link rel="preload" href="{{ asset('js/chemistry-lab-drag-fix.js') }}" as="script">

<!-- Custom Scrollbar Styles -->
<style>
    /* Alpine.js x-cloak directive to hide elements until Alpine initializes */
    [x-cloak] { display: none !important; }

    /* Custom scrollbar styles */
    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: #1f2937;
        border-radius: 10px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #10b981;
        border-radius: 10px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #0d9488;
    }

    .scrollbar-thumb-rounded-full::-webkit-scrollbar-thumb {
        border-radius: 9999px;
    }

    .scrollbar-track-rounded-full::-webkit-scrollbar-track {
        border-radius: 9999px;
    }
</style>
