<x-layouts.app>
    <div class="container mx-auto">
        <!-- Single Container with Header and App -->
        <div id="invest-smart-container" class="relative overflow-hidden">
            <!-- Decorative background elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-emerald-400/20 to-transparent rounded-full blur-2xl -z-0"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-emerald-600/20 to-transparent rounded-full blur-2xl -z-0"></div>

            <!-- Header Bar -->
            <!-- <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 p-4 rounded-t-lg shadow-sm relative z-10 flex items-center gap-3">
                <div class="h-8 w-1 bg-gradient-to-b from-emerald-300 to-emerald-500 rounded-full"></div>
                <h1 class="text-2xl font-bold text-white tracking-tight">InvestSmart - Investment Strategy Simulation</h1>
            </div> -->

            <!-- InvestSmart Game Container -->
            <div id="invest-smart-app" class="emerald-theme bg-zinc-50 dark:bg-zinc-800 overflow-hidden border-x border-b border-emerald-500/30 rounded-b-lg shadow-lg shadow-emerald-900/20"></div>
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

                        // Apply emerald theme to Highcharts
                        if (window.Highcharts) {
                            Highcharts.setOptions({
                                colors: ['#10b981', '#34d399', '#059669', '#047857', '#065f46', '#064e3b'],
                                chart: {
                                    backgroundColor: {
                                        linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
                                        stops: [
                                            [0, '#1f2937'],
                                            [1, '#111827']
                                        ]
                                    },
                                    style: {
                                        fontFamily: 'Instrument Sans, ui-sans-serif, system-ui, sans-serif'
                                    }
                                },
                                title: {
                                    style: {
                                        color: '#f9fafb',
                                        fontWeight: 'bold'
                                    }
                                },
                                subtitle: {
                                    style: {
                                        color: '#d1d5db'
                                    }
                                },
                                xAxis: {
                                    gridLineColor: 'rgba(16, 185, 129, 0.1)',
                                    labels: {
                                        style: {
                                            color: '#9ca3af'
                                        }
                                    },
                                    lineColor: 'rgba(16, 185, 129, 0.2)',
                                    tickColor: 'rgba(16, 185, 129, 0.2)'
                                },
                                yAxis: {
                                    gridLineColor: 'rgba(16, 185, 129, 0.1)',
                                    labels: {
                                        style: {
                                            color: '#9ca3af'
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(17, 24, 39, 0.9)',
                                    borderColor: '#10b981',
                                    style: {
                                        color: '#f9fafb'
                                    }
                                },
                                legend: {
                                    itemStyle: {
                                        color: '#d1d5db'
                                    },
                                    itemHoverStyle: {
                                        color: '#f9fafb'
                                    }
                                }
                            });
                        }

                        // The emerald-theme class is already added in the HTML
                    }
                }, 2000);
            });
        </script>
    @endpush

    @push('styles')
        <style>
            /* Global style override to ensure emerald theme is applied immediately */
            :root {
                --invest-header-bg: linear-gradient(to right, #059669, #10b981);
                --invest-primary: #10b981;
                --invest-primary-hover: #059669;
                --invest-accent: #047857;
            }
            /* Single container styling */
            #invest-smart-container {
                border-radius: 8px;
                overflow: hidden;
                transition: all 0.3s ease;
                box-shadow: 0 4px 20px rgba(16, 185, 129, 0.1);
            }

            #invest-smart-app {
                height: 700px;
                overflow: hidden;
                transition: all 0.3s ease;
            }

            /* Custom styles for InvestSmart components */
            :root {
                --invest-primary: #10b981;
                --invest-primary-light: #34d399;
                --invest-primary-dark: #059669;
                --invest-accent: #047857;
                --invest-text: #f9fafb;
                --invest-bg-light: #f3f4f6;
                --invest-bg-dark: #1f2937;
            }

            /* Add hover effect to the container */
            .container:hover #invest-smart-container {
                box-shadow: 0 8px 30px rgba(16, 185, 129, 0.2);
            }

            /* Custom scrollbar for the app */
            #invest-smart-app ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            #invest-smart-app ::-webkit-scrollbar-track {
                background: rgba(16, 185, 129, 0.05);
                border-radius: 4px;
            }

            #invest-smart-app ::-webkit-scrollbar-thumb {
                background: rgba(16, 185, 129, 0.3);
                border-radius: 4px;
            }

            #invest-smart-app ::-webkit-scrollbar-thumb:hover {
                background: rgba(16, 185, 129, 0.5);
            }

            /* Emerald theme overrides for Vue components - with !important to ensure immediate application */
            #invest-smart-app.emerald-theme .app-header,
            #invest-smart-app .app-header {
                background: linear-gradient(to right, #059669, #10b981) !important;
                border-bottom: 1px solid rgba(16, 185, 129, 0.3) !important;
            }

            /* Override the default Vue styling immediately */
            .invest-smart-game .app-header,
            .app-header {
                background: linear-gradient(to right, #059669, #10b981) !important;
                border-bottom: 1px solid rgba(16, 185, 129, 0.3) !important;
            }

            .invest-smart-game .app-footer,
            .app-footer {
                background: linear-gradient(to right, rgba(5, 150, 105, 0.8), rgba(16, 185, 129, 0.8)) !important;
                color: white !important;
            }

            #invest-smart-app.emerald-theme .main-nav button {
                color: white;
                transition: all 0.2s ease;
            }

            #invest-smart-app.emerald-theme .main-nav button:hover {
                background-color: rgba(255, 255, 255, 0.1);
                transform: translateY(-2px);
            }

            #invest-smart-app.emerald-theme .main-nav button.active {
                background-color: rgba(255, 255, 255, 0.2);
                border-bottom: 2px solid white;
            }

            #invest-smart-app.emerald-theme .primary-button,
            #invest-smart-app.emerald-theme .confirm-button,
            #invest-smart-app .primary-button,
            #invest-smart-app .confirm-button,
            .primary-button,
            .confirm-button {
                background-color: #10b981 !important;
                border: none !important;
                color: white !important;
                transition: all 0.3s ease !important;
            }

            #invest-smart-app.emerald-theme .primary-button:hover,
            #invest-smart-app.emerald-theme .confirm-button:hover,
            #invest-smart-app .primary-button:hover,
            #invest-smart-app .confirm-button:hover,
            .primary-button:hover,
            .confirm-button:hover {
                background-color: #059669 !important;
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important;
                transform: translateY(-2px) !important;
            }

            #invest-smart-app.emerald-theme .cancel-button {
                border: 1px solid #10b981;
                color: #10b981;
                background-color: transparent;
                transition: all 0.3s ease;
            }

            #invest-smart-app.emerald-theme .cancel-button:hover {
                background-color: rgba(16, 185, 129, 0.1);
            }

            /* Modal styling */
            #invest-smart-app.emerald-theme .modal-overlay {
                backdrop-filter: blur(8px);
                background-color: rgba(0, 0, 0, 0.2) !important;
            }

            #invest-smart-app.emerald-theme .modal-container {
                border: 1px solid rgba(16, 185, 129, 0.3);
                box-shadow: 0 8px 30px rgba(16, 185, 129, 0.2);
            }

            /* Summary cards */
            #invest-smart-app.emerald-theme .summary-card {
                border: 1px solid rgba(16, 185, 129, 0.3);
                transition: all 0.3s ease;
            }

            #invest-smart-app.emerald-theme .summary-card:hover {
                border-color: rgba(16, 185, 129, 0.6);
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
                transform: translateY(-2px);
            }

            /* Table styling */
            #invest-smart-app.emerald-theme table th {
                background-color: rgba(16, 185, 129, 0.1);
                color: #10b981;
            }

            #invest-smart-app.emerald-theme table tr:hover {
                background-color: rgba(16, 185, 129, 0.05);
            }

            /* Footer styling */
            #invest-smart-app.emerald-theme .app-footer {
                border-top: 1px solid rgba(16, 185, 129, 0.3);
                background: linear-gradient(to right, rgba(5, 150, 105, 0.1), rgba(16, 185, 129, 0.1));
            }
        </style>
    @endpush
</x-layouts.app>
