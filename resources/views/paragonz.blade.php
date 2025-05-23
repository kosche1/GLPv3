<x-layouts.app>
    <style>
        .game-container {
            max-width: 400px;
            margin: 0 auto;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100vh;
            color: white;
            background-color: black;
        }
        
        .progress-bar {
            background: linear-gradient(90deg, #9333ea 0%, #4f46e5 100%);
        }
        
        .game-button:active {
            transform: scale(0.95);
        }
        
        .hero-glow {
            filter: drop-shadow(0 0 8px rgba(255, 215, 0, 0.6));
        }
        
        .progress-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                opacity: 0.8;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0.8;
            }
        }
        
        /* Custom colors */
        .bg-game-purple {
            background-color: #2D1B69;
        }
        
        .bg-game-dark {
            background-color: #1A103E;
        }
    </style>

    <div class="game-container">
        <!-- Header -->
        <div class="relative">
            <div class="flex justify-between items-center p-3 bg-black">
                <h1 class="text-xl font-bold">ParagonZ</h1>
                <div class="flex items-center">
                    <button class="text-gray-400 px-2"><i class="fas fa-ellipsis-v"></i></button>
                    <button class="text-gray-400 px-2"><i class="fas fa-times"></i></button>
                </div>
            </div>
            
            <!-- User Stats -->
            <div class="bg-game-purple rounded-lg mx-2 p-2 flex items-center justify-between">
                <div class="flex items-center gap-1">
                    <div class="bg-blue-600 rounded-md p-1 w-7 h-7 flex items-center justify-center">
                        <i class="fas fa-shield-alt text-white text-sm"></i>
                    </div>
                    <div class="bg-orange-500 rounded-md p-1 w-7 h-7 flex items-center justify-center">
                        <i class="fas fa-fire text-white text-sm"></i>
                    </div>
                    <span class="text-white font-semibold text-sm ml-1">Soran@utis</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center">
                        <span class="text-yellow-400 mr-1.5">
                            <i class="fas fa-coins"></i>
                        </span>
                        <span class="text-white text-sm">15,586</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-blue-400 mr-1.5">
                            <i class="fas fa-gem"></i>
                        </span>
                        <span class="text-white text-sm">0.288</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- APR Section -->
        <div class="bg-purple-800 mx-2 mt-3 rounded-lg p-2">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <span class="text-purple-300 font-bold mr-2 text-sm">APR</span>
                    <span class="text-white font-bold text-sm">6,083.33%</span>
                </div>
                <div class="flex items-center">
                    <span class="text-purple-300 mr-1"><i class="fas fa-bolt"></i></span>
                    <span class="text-white text-xs">+2% HERO BONUS</span>
                </div>
            </div>
        </div>

        <!-- Mining Progress -->
        <div class="bg-purple-700 mx-2 mt-2 rounded-lg p-2">
            <div class="flex justify-between items-center mb-1">
                <div class="flex items-center">
                    <span class="text-yellow-400 mr-1"><i class="fas fa-box-open"></i></span>
                    <span class="text-white text-sm">42%</span>
                </div>
                <div class="text-white text-sm">07:56:33</div>
            </div>
            <div class="w-full bg-purple-900 rounded-full h-2.5">
                <div class="progress-bar h-2.5 rounded-full" style="width: 42%"></div>
            </div>
        </div>

        <!-- Currency Display -->
        <div class="flex justify-between mx-2 mt-3">
            <div class="bg-yellow-500 rounded-full py-2 px-4 flex items-center justify-center w-1/2 mr-1">
                <span class="text-yellow-800 mr-2"><i class="fas fa-bolt"></i></span>
                <span class="text-white font-bold">0.105</span>
            </div>
            <div class="bg-blue-500 rounded-full py-2 px-4 flex items-center justify-center w-1/2 ml-1">
                <span class="text-blue-200 mr-2"><i class="fas fa-gem"></i></span>
                <span class="text-white font-bold">0.000003</span>
            </div>
        </div>

        <!-- Game Main Area with Character -->
        <div class="flex-grow relative mt-2">
            <!-- LVL UP Button -->
            <div class="absolute left-6 top-4 flex flex-col items-center">
                <div class="bg-blue-600 rounded-full w-12 h-12 flex items-center justify-center mb-1 shadow-lg">
                    <div class="text-white">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                </div>
                <span class="text-white text-xs">LVL UP</span>
            </div>
            
            <!-- OPEN Button -->
            <div class="absolute right-6 top-4 flex flex-col items-center">
                <div class="bg-red-600 rounded-full w-12 h-12 flex items-center justify-center mb-1 shadow-lg relative">
                    <div class="text-white">
                        <i class="fas fa-dragon"></i>
                    </div>
                    <span class="absolute -top-1 -right-1 bg-white text-red-600 rounded-full text-xs w-5 h-5 flex items-center justify-center font-bold">140</span>
                </div>
                <span class="text-white text-xs">OPEN</span>
            </div>
            
            <!-- HEROES Button -->
            <div class="absolute left-6 bottom-16 flex flex-col items-center">
                <div class="bg-purple-700 rounded-full w-12 h-12 flex items-center justify-center mb-1 shadow-lg">
                    <div class="text-purple-300">
                        <i class="fas fa-ghost"></i>
                    </div>
                </div>
                <span class="text-white text-xs">HEROES</span>
            </div>
            
            <!-- WALLET Button -->
            <div class="absolute left-1/3 bottom-8 flex flex-col items-center">
                <div class="bg-yellow-400 rounded-full w-12 h-12 flex items-center justify-center mb-1 shadow-lg">
                    <div class="text-yellow-700">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
                <span class="text-white text-xs">WALLET</span>
            </div>
            
            <!-- MARKET Button -->
            <div class="absolute right-6 bottom-16 flex flex-col items-center">
                <div class="bg-orange-400 rounded-full w-12 h-12 flex items-center justify-center mb-1 shadow-lg">
                    <div class="text-orange-700">
                        <i class="fas fa-store"></i>
                    </div>
                </div>
                <span class="text-white text-xs">MARKET</span>
            </div>
            
            <!-- Hero Character -->
            <div class="flex justify-center items-center h-full">
                <img src="/placeholder.svg?height=180&width=180" alt="Hero character" class="h-44 hero-glow">
            </div>
            
            <!-- Currency Display at Bottom -->
            <div class="absolute bottom-0 left-0 right-0 flex items-center justify-between px-4 py-2">
                <div class="flex items-center">
                    <span class="text-yellow-400 mr-2"><i class="fas fa-bolt"></i></span>
                    <span class="text-white font-bold">3,825/1,000</span>
                </div>
                <div class="flex items-center">
                    <span class="text-blue-400 mr-1"><i class="fas fa-gem"></i></span>
                    <span class="text-white font-bold">3550</span>
                </div>
            </div>
        </div>

        <!-- Fight Button -->
        <div class="flex justify-center mx-2 mb-4">
            <button class="bg-blue-600 text-white font-bold py-3 px-16 rounded-lg w-full mx-4">
                FIGHT
            </button>
        </div>

        <!-- Navigation Bar -->
        <div class="bg-black flex justify-between items-center p-2 border-t border-gray-800">
            <div class="flex flex-col items-center">
                <i class="fas fa-hammer text-gray-500 text-sm"></i>
                <span class="text-gray-500 text-xs mt-1">DWARF</span>
            </div>
            <div class="flex flex-col items-center">
                <i class="fas fa-scroll text-gray-500 text-sm"></i>
                <span class="text-gray-500 text-xs mt-1">QUEST</span>
            </div>
            <div class="flex flex-col items-center">
                <i class="fas fa-home text-white text-sm"></i>
                <span class="text-white text-xs mt-1">HOME</span>
            </div>
            <div class="flex flex-col items-center">
                <i class="fas fa-users text-gray-500 text-sm"></i>
                <span class="text-gray-500 text-xs mt-1">FRIEND</span>
            </div>
            <div class="flex flex-col items-center">
                <i class="fas fa-trophy text-gray-500 text-sm"></i>
                <span class="text-gray-500 text-xs mt-1">LEADERBOARD</span>
            </div>
        </div>
        
        <!-- Bot Reference -->
        <div class="text-center text-gray-500 text-xs py-1">
            @paragon_mini_app_bot
        </div>
    </div>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script>
        // Game state
        const gameState = {
            coins: 15586,
            gems: 0.288,
            energy: 3825,
            maxEnergy: 1000,
            miningProgress: 42,
            timeRemaining: 7 * 3600 + 56 * 60 + 33, // 07:56:33 in seconds
            heroLevel: 1,
            heroBonus: 2,
            apr: 6083.33,
            token1: 0.105,
            token2: 0.000003,
        }

        // Update the timer display
        function updateTimer() {
            gameState.timeRemaining--
            if (gameState.timeRemaining < 0) {
                gameState.timeRemaining = 0
                gameState.miningProgress = 100
                updateMiningProgress()
                clearInterval(timerInterval)
            }

            const hours = Math.floor(gameState.timeRemaining / 3600)
            const minutes = Math.floor((gameState.timeRemaining % 3600) / 60)
            const seconds = gameState.timeRemaining % 60

            const timeDisplay = document.querySelector(".bg-purple-700 .text-white.text-sm")
            if (timeDisplay) {
                timeDisplay.textContent = `${hours.toString().padStart(2, "0")}:${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`
            }
        }

        // Update the mining progress bar
        function updateMiningProgress() {
            const progressBar = document.querySelector(".progress-bar")
            const progressText = document.querySelector(".bg-purple-700 .flex:first-child .text-white")

            if (progressBar && progressText) {
                progressBar.style.width = `${gameState.miningProgress}%`
                progressText.textContent = `${gameState.miningProgress}%`

                // If mining is complete, add rewards
                if (gameState.miningProgress >= 100) {
                    gameState.token1 += 0.01
                    gameState.token2 += 0.000001
                    updateCurrencyDisplay()

                    // Reset mining
                    setTimeout(() => {
                        gameState.miningProgress = 0
                        gameState.timeRemaining = 8 * 3600 // 8 hours
                        updateTimer()
                        updateMiningProgress()
                        startTimer()
                    }, 3000)
                }
            }
        }

        // Update currency displays
        function updateCurrencyDisplay() {
            const coinDisplay = document.querySelector(".flex.items-center:nth-child(2) .text-white")
            const gemDisplay = document.querySelector(".flex.items-center:nth-child(2) .text-white:nth-child(2)")
            const token1Display = document.querySelector(".bg-yellow-500 .text-white")
            const token2Display = document.querySelector(".bg-blue-500 .text-white")

            if (coinDisplay && gemDisplay && token1Display && token2Display) {
                coinDisplay.textContent = gameState.coins.toLocaleString()
                gemDisplay.textContent = gameState.gems.toFixed(3)
                token1Display.textContent = gameState.token1.toFixed(3)
                token2Display.textContent = gameState.token2.toFixed(6)
            }
        }

        // Fight functionality
        function fight() {
            if (gameState.energy >= 100) {
                gameState.energy -= 100
                gameState.coins += Math.floor(Math.random() * 500) + 100

                // Update displays
                const energyDisplay = document.querySelector(".absolute.bottom-0 .text-white.font-bold")
                if (energyDisplay) {
                    energyDisplay.textContent = `${gameState.energy}/${gameState.maxEnergy}`
                }
                updateCurrencyDisplay()

                // Animation effect
                const fightButton = document.querySelector(".bg-blue-600.text-white.font-bold.py-3")
                if (fightButton) {
                    fightButton.classList.add("bg-green-600")
                    setTimeout(() => {
                        fightButton.classList.remove("bg-green-600")
                    }, 300)
                }
            } else {
                alert("Not enough energy to fight!")
            }
        }

        // Initialize event listeners
        function initializeEvents() {
            // Fight button
            const fightButton = document.querySelector(".bg-blue-600.text-white.font-bold.py-3")
            if (fightButton) {
                fightButton.addEventListener("click", fight)
            }

            // Level up button
            const levelUpButton = document.querySelector(".bg-blue-600.rounded-full")
            if (levelUpButton) {
                levelUpButton.addEventListener("click", () => {
                    if (gameState.coins >= 1000) {
                        gameState.coins -= 1000
                        gameState.heroLevel++
                        gameState.heroBonus += 0.5
                        gameState.maxEnergy += 100

                        const heroBonusDisplay = document.querySelector(".bg-purple-800 .text-white.text-xs")
                        if (heroBonusDisplay) {
                            heroBonusDisplay.textContent = `+${gameState.heroBonus}% HERO BONUS`
                        }

                        updateCurrencyDisplay()
                    } else {
                        alert("Not enough coins to level up!")
                    }
                })
            }

            // Other buttons for visual feedback
            const allButtons = document.querySelectorAll(".rounded-full, .rounded-lg")
            allButtons.forEach((button) => {
                button.addEventListener("click", function() {
                    this.style.transform = "scale(0.95)"
                    setTimeout(() => {
                        this.style.transform = "scale(1)"
                    }, 100)
                })
            })
        }

        // Start the timer
        let timerInterval
        function startTimer() {
            timerInterval = setInterval(updateTimer, 1000)
        }

        // Initialize the game
        function initGame() {
            if (document.readyState === 'complete') {
                setTimeout(() => {
                    updateTimer()
                    updateMiningProgress()
                    updateCurrencyDisplay()
                    initializeEvents()
                    startTimer()
                }, 500)
            } else {
                window.addEventListener('load', () => {
                    setTimeout(() => {
                        updateTimer()
                        updateMiningProgress()
                        updateCurrencyDisplay()
                        initializeEvents()
                        startTimer()
                    }, 500)
                })
            }
        }

        initGame()
    </script>
</x-layouts.app>