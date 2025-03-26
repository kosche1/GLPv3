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

    <!-- Monaco Editor -->
    <script>
        // Configure Monaco loader
        window.MonacoEnvironment = {
            getWorkerUrl: function(workerId, label) {
                return `data:text/javascript;charset=utf-8,${encodeURIComponent(`
                    self.MonacoEnvironment = {
                        baseUrl: '${window.location.origin}/js/monaco-editor/min/'
                    };
                    importScripts('${window.location.origin}/js/monaco-editor/min/vs/base/worker/workerMain.js');
                `)}`;
            }
        };
    </script>
    <script src="{{ asset('js/monaco-editor/min/vs/loader.js') }}"></script>
    <script>
        require.config({
            paths: {
                'vs': '{{ asset('js/monaco-editor/min/vs') }}'
            }
        });
        
        // Preload Monaco features for faster initialization
        if (document.querySelector('#monaco-editor-container')) {
            require(['vs/editor/editor.main'], function() {
                // Preload language contributions
                require([
                    'vs/basic-languages/php/php.contribution',
                    'vs/basic-languages/sql/sql.contribution',
                    'vs/basic-languages/java/java.contribution',
                    'vs/basic-languages/python/python.contribution',
                    'vs/basic-languages/javascript/javascript.contribution',
                    'vs/basic-languages/html/html.contribution',
                    'vs/basic-languages/css/css.contribution'
                ], function() {
                    console.log('Monaco language modules preloaded');
                });
            });
        }
    </script>
