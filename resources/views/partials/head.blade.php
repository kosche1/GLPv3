<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? 'Laravel' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.39.1/src-noconflict/ace.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.39.1/src-noconflict/mode-python.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.39.1/src-noconflict/theme-monokai.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.39.1/src-noconflict/snippets/python.js"></script>
<link href="https://cdn.jsdelivr.net/npm/ace-builds@1.39.1/css/ace.min.css" rel="stylesheet">