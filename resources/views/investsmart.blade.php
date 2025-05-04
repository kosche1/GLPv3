<x-layouts.app>
    <div class="container mx-auto">
        <div class="bg-orange-500 rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-6">InvestSmart - Investment Strategy Simulation</h1>

            <!-- InvestSmart Game Container -->
            <div id="invest-smart-app" class="bg-gray-50 rounded-lg overflow-hidden"></div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.highcharts.com/stock/highstock.js"></script>
        <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>
        @vite(['resources/js/components/InvestSmart/index.js'])
        <script>
            // Debug script to check for errors
            document.addEventListener('DOMContentLoaded', function() {
                console.log('InvestSmart page loaded from Blade');
                console.log('App container exists:', !!document.getElementById('invest-smart-app'));

                // Check if Vue is loaded
                setTimeout(function() {
                    if (document.querySelector('#invest-smart-app').children.length === 0) {
                        console.error('Vue component did not render after 2 seconds');
                    } else {
                        console.log('Vue component rendered successfully');
                    }
                }, 2000);
            });
        </script>
    @endpush

    @push('styles')
        <style>
            #invest-smart-app {
                height: 700px;
                border-radius: 8px;
                overflow: hidden;
            }
        </style>
    @endpush
</x-layouts.app>
