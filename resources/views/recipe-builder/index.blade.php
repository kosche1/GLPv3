<x-layouts.app>
    <div id="recipe-builder-app">
        <div class="max-w-8xl mx-auto">
            <!-- Animated Header with Orange Gradient Background -->
            <div class="relative mb-8 overflow-hidden rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 p-8 shadow-lg">
                <div class="absolute -top-24 -right-24 h-64 w-64 rounded-full bg-white opacity-20 blur-3xl"></div>
                <div class="absolute -bottom-16 -left-16 h-40 w-40 rounded-full bg-white opacity-20 blur-3xl"></div>
                <!-- Additional decorative elements for the orange gradient -->
                <div class="absolute top-1/2 left-1/4 h-32 w-32 rounded-full bg-orange-300 opacity-20 blur-2xl"></div>
                <div class="absolute bottom-1/3 right-1/3 h-24 w-24 rounded-full bg-yellow-400 opacity-15 blur-2xl"></div>

                <div class="relative flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Recipe Builder</h1>
                        <p class="text-yellow-50 max-w-xl">Create balanced, nutritious meals and learn about food composition in this interactive cooking game!</p>
                    </div>
                    <div class="flex space-x-2">
                        <button id="start-new-recipe" class="group relative px-6 py-3 bg-white text-orange-600 font-medium rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:bg-orange-50 flex items-center hover:translate-y-[-2px] hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50">
                            <span class="absolute -inset-0.5 bg-gradient-to-r from-orange-100 to-orange-200 opacity-0 group-hover:opacity-30 rounded-lg blur transition-all duration-300"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="relative">Start New Recipe</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Recipe Challenges Section -->
            <div id="recipe-challenges" class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 mb-8 border border-orange-200 dark:border-orange-900">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Recipe Challenges</h2>
                    </div>
                    <span id="challenge-count" class="px-3 py-1 bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200 rounded-full text-sm font-medium">
                        Available Challenges
                    </span>
                </div>

                <div id="challenge-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Challenge cards will be populated here via JavaScript -->
                </div>

                <div id="empty-challenge-message" class="hidden bg-white dark:bg-gray-800 rounded-xl p-8 text-center border border-gray-300 dark:border-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No Challenges Available</h3>
                    <p class="text-gray-700 dark:text-gray-400 mb-6">There are no recipe challenges available at the moment. Check back later!</p>
                </div>
            </div>

            <!-- Recipe Builder Game Interface -->
            <div id="recipe-builder-container" class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 mb-6 hidden transform transition-all duration-500 ease-in-out">
                <!-- Active Challenge Info Panel (hidden by default) -->
                <div id="active-challenge-panel" class="mb-6 hidden">
                    <div class="bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 rounded-lg border border-orange-200 dark:border-orange-800 p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <h3 id="active-challenge-name" class="text-lg font-bold text-gray-900 dark:text-white">Challenge Name</h3>
                            </div>
                            <button id="cancel-challenge" class="text-sm text-gray-500 hover:text-red-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel Challenge
                            </button>
                        </div>
                        <p id="active-challenge-description" class="text-sm text-black dark:text-gray-300 mb-3">Challenge description goes here.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm">
                                <h4 class="text-sm font-semibold mb-2 text-black dark:text-gray-200">Requirements</h4>
                                <ul id="challenge-requirements" class="text-xs space-y-1 text-black dark:text-gray-300">
                                    <!-- Requirements will be populated here -->
                                </ul>
                            </div>
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm">
                                <h4 class="text-sm font-semibold mb-2 text-black dark:text-gray-200">Progress</h4>
                                <ul id="challenge-progress" class="text-xs space-y-1 text-black dark:text-gray-300">
                                    <!-- Progress will be populated here -->
                                </ul>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs text-black dark:text-gray-300">
                            <span>Difficulty: <span id="challenge-difficulty" class="font-medium">Beginner</span></span>
                            <span>Reward: <span id="challenge-reward" class="font-medium text-amber-600 dark:text-amber-400">100 points</span></span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Left Column: Ingredients -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 h-full">
                        <div class="p-5">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <h2 class="text-xl font-bold">Ingredients</h2>
                            </div>

                            <!-- Ingredient Categories -->
                            <div class="mb-5">
                                <div class="flex flex-wrap gap-2 mb-4" id="ingredient-categories">
                                    <button class="category-btn px-3 py-1.5 rounded-full text-sm font-medium bg-amber-500 text-white shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105" data-category="all">All</button>
                                    <button class="category-btn px-3 py-1.5 rounded-full text-sm font-medium bg-amber-100 text-amber-800 dark:bg-gray-700 dark:text-gray-200 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105" data-category="protein">Proteins</button>
                                    <button class="category-btn px-3 py-1.5 rounded-full text-sm font-medium bg-amber-100 text-amber-800 dark:bg-gray-700 dark:text-gray-200 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105" data-category="vegetable">Vegetables</button>
                                    <button class="category-btn px-3 py-1.5 rounded-full text-sm font-medium bg-amber-100 text-amber-800 dark:bg-gray-700 dark:text-gray-200 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105" data-category="grain">Grains</button>
                                    <button class="category-btn px-3 py-1.5 rounded-full text-sm font-medium bg-amber-100 text-amber-800 dark:bg-gray-700 dark:text-gray-200 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105" data-category="dairy">Dairy</button>
                                    <button class="category-btn px-3 py-1.5 rounded-full text-sm font-medium bg-amber-100 text-amber-800 dark:bg-gray-700 dark:text-gray-200 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105" data-category="fruit">Fruits</button>
                                    <button class="category-btn px-3 py-1.5 rounded-full text-sm font-medium bg-amber-100 text-amber-800 dark:bg-gray-700 dark:text-gray-200 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105" data-category="fat">Fats</button>
                                </div>
                            </div>

                            <!-- Search Box -->
                            <div class="relative mb-4">
                                <input type="text" id="ingredient-search" placeholder="Search ingredients..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-amber-400 dark:border-gray-600 focus:ring-2 focus:ring-amber-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>

                            <!-- Ingredient List -->
                            <div style="max-height: 500px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 0.5rem;">
                                <div id="ingredients-list" class="space-y-1">
                                    <!-- Ingredients will be populated here via JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Middle Column: Recipe Building Area -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 h-full">
                        <div class="p-5">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <h2 class="text-xl font-bold">Your Recipe</h2>
                            </div>

                            <!-- Recipe Name with Animation -->
                            <div class="mb-4 transform transition duration-500 hover:scale-[1.02]">
                                <label for="recipe-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Recipe Name</label>
                                <div class="relative">
                                    <input type="text" id="recipe-name" placeholder="Enter a creative name..." class="mt-1 block w-full pl-10 pr-4 py-2.5 rounded-lg border border-emerald-400 dark:border-gray-600 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 bg-white dark:bg-gray-800 text-gray-800 dark:text-white transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Recipe Description with Animation -->
                            <div class="mb-5 transform transition duration-500 hover:scale-[1.02]">
                                <label for="recipe-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description (Optional)</label>
                                <div class="relative">
                                    <textarea id="recipe-description" rows="2" placeholder="Describe your culinary creation..." class="mt-1 block w-full pl-10 pr-4 py-2.5 rounded-lg border border-emerald-400 dark:border-gray-600 shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 bg-white dark:bg-gray-800 text-gray-800 dark:text-white transition-all duration-300"></textarea>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Selected Ingredients with Visual Enhancement -->
                            <div class="mb-5">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">Selected Ingredients</h3>
                                    <span id="ingredient-count" class="text-xs font-medium px-2 py-1 bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-full">0 items</span>
                                </div>
                                <div class="relative">
                                    <div id="selected-ingredients" class="h-[200px] overflow-y-auto border rounded-lg p-3">
                                        <!-- Selected ingredients will be populated here via JavaScript -->
                                        <div class="text-sm text-gray-700 dark:text-gray-200 italic flex items-center justify-center h-full" id="empty-ingredients-message">
                                            <div class="text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-gray-400 dark:text-gray-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <p>Add ingredients from the left panel</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Save Recipe Button with Animation -->
                            <button id="save-recipe" class="w-full group relative px-6 py-3 bg-amber-500 dark:bg-amber-600 text-white font-medium rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:translate-y-[-3px] hover:scale-[1.02] hover:bg-amber-600 dark:hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50">
                                <span class="relative flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    Save Recipe
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Right Column: Nutritional Information & Challenge -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 h-full">
                        <div class="p-5">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <h2 class="text-xl font-bold">Nutrition Analysis</h2>
                            </div>

                            <!-- Nutritional Summary with Visual Enhancements -->
                            <div class="mb-5 bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-300 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">Nutritional Summary</h3>
                                    <div id="nutrition-status" class="text-xs font-medium px-2 py-1 bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-full">Analyzing...</div>
                                </div>

                                <div class="space-y-3">
                                    <!-- Calories with animated counter -->
                                    <div class="flex items-center justify-between p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                                            </svg>
                                            <span class="text-sm font-medium">Calories:</span>
                                        </div>
                                        <span id="total-calories" class="text-sm font-bold text-red-600 dark:text-red-300 tabular-nums transition-all duration-300">0</span>
                                    </div>

                                    <!-- Protein with animated counter -->
                                    <div class="flex items-center justify-between p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                            <span class="text-sm font-medium">Protein:</span>
                                        </div>
                                        <span id="total-protein" class="text-sm font-bold text-blue-600 dark:text-blue-300 tabular-nums transition-all duration-300">0g</span>
                                    </div>

                                    <!-- Carbs with animated counter -->
                                    <div class="flex items-center justify-between p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                                            </svg>
                                            <span class="text-sm font-medium">Carbs:</span>
                                        </div>
                                        <span id="total-carbs" class="text-sm font-bold text-green-600 dark:text-green-300 tabular-nums transition-all duration-300">0g</span>
                                    </div>

                                    <!-- Fat with animated counter -->
                                    <div class="flex items-center justify-between p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            <span class="text-sm font-medium">Fat:</span>
                                        </div>
                                        <span id="total-fat" class="text-sm font-bold text-yellow-600 dark:text-yellow-300 tabular-nums transition-all duration-300">0g</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Macronutrient Distribution with Enhanced Visuals -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">Macronutrient Balance</h3>
                                    <div id="balance-status" class="text-xs font-medium px-2 py-1 bg-red-200 text-red-800 dark:bg-red-600 dark:text-white rounded-full">Unbalanced</div>
                                </div>

                                <!-- Circular progress chart (visual enhancement) -->
                                <div class="flex justify-center mb-4">
                                    <div class="relative w-32 h-32">
                                        <!-- Background circle -->
                                        <svg class="w-full h-full -rotate-90" viewBox="0 0 100 100">
                                            <circle class="text-gray-200 dark:text-gray-700" stroke-width="10" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" />
                                            <!-- Protein arc -->
                                            <circle id="protein-circle" class="text-blue-500 transition-all duration-1000 ease-in-out" stroke-width="10" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" stroke-dasharray="0 251.2" stroke-dashoffset="0" />
                                            <!-- Carbs arc -->
                                            <circle id="carbs-circle" class="text-green-500 transition-all duration-1000 ease-in-out" stroke-width="10" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" stroke-dasharray="0 251.2" stroke-dashoffset="0" />
                                            <!-- Fat arc -->
                                            <circle id="fat-circle" class="text-yellow-500 transition-all duration-1000 ease-in-out" stroke-width="10" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" stroke-dasharray="0 251.2" stroke-dashoffset="0" />
                                        </svg>
                                        <!-- Center text -->
                                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                                            <span class="text-xs font-medium text-gray-700 dark:text-gray-200">Balance</span>
                                            <span id="balance-percent" class="text-lg font-bold text-gray-800 dark:text-gray-200">0%</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Traditional bar chart (keeping for clarity) -->
                                <div class="h-4 w-full bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden shadow-inner">
                                    <div class="flex h-full transition-all duration-1000 ease-in-out">
                                        <div id="protein-bar" class="bg-blue-500" style="width: 0%"></div>
                                        <div id="carbs-bar" class="bg-green-500" style="width: 0%"></div>
                                        <div id="fat-bar" class="bg-yellow-500" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div class="flex justify-between text-xs mt-2">
                                    <span class="flex items-center text-gray-800 dark:text-gray-200">
                                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-1"></span>
                                        Protein: <span id="protein-percent" class="font-medium">0%</span>
                                    </span>
                                    <span class="flex items-center text-gray-800 dark:text-gray-200">
                                        <span class="w-3 h-3 bg-green-500 rounded-full mr-1"></span>
                                        Carbs: <span id="carbs-percent" class="font-medium">0%</span>
                                    </span>
                                    <span class="flex items-center text-gray-800 dark:text-gray-200">
                                        <span class="w-3 h-3 bg-yellow-500 rounded-full mr-1"></span>
                                        Fat: <span id="fat-percent" class="font-medium">0%</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Nutrition Tips -->
                            <div class="p-3 bg-blue-50 dark:bg-blue-900 rounded-lg border border-blue-200 dark:border-blue-800 text-sm">
                                <div class="flex items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium text-gray-800 dark:text-gray-200">Nutrition Tip:</span>
                                </div>
                                <p id="nutrition-tip" class="text-gray-800 dark:text-gray-200">A balanced meal typically contains 10-35% protein, 45-65% carbs, and 20-35% fat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recipe History with Enhanced Design -->
            <div id="recipe-history" class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 border border-gray-300 dark:border-gray-700">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Your Recipe Collection</h2>
                    </div>
                    <span id="recipe-count" class="px-3 py-1 bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 rounded-full text-sm font-medium">
                        0 recipes
                    </span>
                </div>

                <div id="recipe-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Recipe cards will be populated here via JavaScript -->
                </div>

                <div id="empty-recipe-message" class="bg-white dark:bg-gray-800 rounded-xl p-8 text-center border border-gray-300 dark:border-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No Recipes Yet</h3>
                    <p class="text-gray-700 dark:text-gray-400 mb-6">You haven't created any recipes yet. Start building your first culinary masterpiece!</p>
                </div>
            </div>

            <!-- Recipe Result Modal with Enhanced Design -->
            <div id="recipe-result-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden transition-all duration-300">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-500 scale-100 opacity-100">
                    <!-- Modal header with gradient -->
                    <div class="h-2 bg-gradient-to-r from-gray-500 to-gray-600 dark:from-gray-600 dark:to-gray-700 rounded-t-xl"></div>

                    <div class="p-6">
                        <!-- Success icon -->
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        <h3 id="result-title" class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-4">Recipe Saved!</h3>

                        <div id="result-content" class="mb-6 text-center">
                            <!-- Result content will be populated here via JavaScript -->
                        </div>

                        <div class="flex justify-center">
                            <button id="close-result-modal" class="group relative px-6 py-3 bg-amber-500 dark:bg-amber-600 text-white font-medium rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:translate-y-[-3px] hover:scale-[1.02] hover:bg-amber-600 dark:hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50">
                                <span class="relative flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Awesome!
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div id="delete-confirmation-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden transition-all duration-300">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-500 scale-100 opacity-100">
                    <!-- Modal header with gradient -->
                    <div class="h-2 bg-gradient-to-r from-red-500 to-red-600 dark:from-red-600 dark:to-red-700 rounded-t-xl"></div>

                    <div class="p-6">
                        <!-- Warning icon -->
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-4">Delete Recipe?</h3>

                        <div class="mb-6 text-center">
                            <p class="text-gray-700 dark:text-gray-300">Are you sure you want to delete this recipe? This action cannot be undone.</p>
                        </div>

                        <div class="flex justify-center space-x-4">
                            <button id="confirm-delete" class="px-6 py-3 bg-red-500 dark:bg-red-600 text-white font-medium rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:translate-y-[-2px] hover:scale-[1.02] hover:bg-red-600 dark:hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                                Delete
                            </button>
                            <button id="cancel-delete" class="px-6 py-3 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white font-medium rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:translate-y-[-2px] hover:scale-[1.02] hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recipe approval notifications are now handled by the global recipe-approval-modal component -->

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Recipe approval notifications are now handled by the global recipe-approval-modal component
        // Mock data for ingredients
        const ingredients = [
            {
                id: 1,
                name: "Chicken Breast",
                category: "protein",
                calories: 165,
                protein: 31,
                carbs: 0,
                fat: 3.6
            },
            {
                id: 2,
                name: "Salmon",
                category: "protein",
                calories: 206,
                protein: 22,
                carbs: 0,
                fat: 13
            },
            {
                id: 3,
                name: "Tofu",
                category: "protein",
                calories: 76,
                protein: 8,
                carbs: 2,
                fat: 4.5
            },
            {
                id: 4,
                name: "Brown Rice",
                category: "grain",
                calories: 216,
                protein: 5,
                carbs: 45,
                fat: 1.8
            },
            {
                id: 5,
                name: "Quinoa",
                category: "grain",
                calories: 222,
                protein: 8,
                carbs: 39,
                fat: 3.6
            },
            {
                id: 6,
                name: "Sweet Potato",
                category: "vegetable",
                calories: 112,
                protein: 2,
                carbs: 26,
                fat: 0.1
            },
            {
                id: 7,
                name: "Broccoli",
                category: "vegetable",
                calories: 55,
                protein: 3.7,
                carbs: 11.2,
                fat: 0.6
            },
            {
                id: 8,
                name: "Spinach",
                category: "vegetable",
                calories: 23,
                protein: 2.9,
                carbs: 3.6,
                fat: 0.4
            },
            {
                id: 9,
                name: "Avocado",
                category: "fat",
                calories: 240,
                protein: 3,
                carbs: 12,
                fat: 22
            },
            {
                id: 10,
                name: "Olive Oil",
                category: "fat",
                calories: 119,
                protein: 0,
                carbs: 0,
                fat: 13.5
            },
            {
                id: 11,
                name: "Greek Yogurt",
                category: "dairy",
                calories: 100,
                protein: 10,
                carbs: 4,
                fat: 5
            },
            {
                id: 12,
                name: "Cheddar Cheese",
                category: "dairy",
                calories: 113,
                protein: 7,
                carbs: 0.4,
                fat: 9.3
            },
            {
                id: 13,
                name: "Banana",
                category: "fruit",
                calories: 105,
                protein: 1.3,
                carbs: 27,
                fat: 0.4
            },
            {
                id: 14,
                name: "Blueberries",
                category: "fruit",
                calories: 57,
                protein: 0.7,
                carbs: 14.5,
                fat: 0.3
            },
            {
                id: 15,
                name: "Almonds",
                category: "fat",
                calories: 164,
                protein: 6,
                carbs: 6,
                fat: 14
            }
        ];

        // State variables
        let selectedIngredients = [];
        let selectedCategory = 'all';
        let searchQuery = '';
        let userRecipes = [];

        // DOM elements
        const startNewRecipeBtn = document.getElementById('start-new-recipe');
        const startFirstRecipeBtn = document.getElementById('start-first-recipe-btn');
        const recipeBuilderContainer = document.getElementById('recipe-builder-container');
        const ingredientsList = document.getElementById('ingredients-list');
        const ingredientSearch = document.getElementById('ingredient-search');
        const categoryButtons = document.querySelectorAll('.category-btn');
        const selectedIngredientsList = document.getElementById('selected-ingredients');
        const emptyIngredientsMessage = document.getElementById('empty-ingredients-message');
        const ingredientCount = document.getElementById('ingredient-count');
        const recipeName = document.getElementById('recipe-name');
        const recipeDescription = document.getElementById('recipe-description');
        const saveRecipeBtn = document.getElementById('save-recipe');
        const recipeResultModal = document.getElementById('recipe-result-modal');
        const closeResultModalBtn = document.getElementById('close-result-modal');
        const resultTitle = document.getElementById('result-title');
        const resultContent = document.getElementById('result-content');
        const recipeList = document.getElementById('recipe-list');
        const emptyRecipeMessage = document.getElementById('empty-recipe-message');
        const recipeCount = document.getElementById('recipe-count');

        // Nutrition elements
        const totalCalories = document.getElementById('total-calories');
        const totalProtein = document.getElementById('total-protein');
        const totalCarbs = document.getElementById('total-carbs');
        const totalFat = document.getElementById('total-fat');
        const proteinPercent = document.getElementById('protein-percent');
        const carbsPercent = document.getElementById('carbs-percent');
        const fatPercent = document.getElementById('fat-percent');
        const proteinBar = document.getElementById('protein-bar');
        const carbsBar = document.getElementById('carbs-bar');
        const fatBar = document.getElementById('fat-bar');
        const proteinCircle = document.getElementById('protein-circle');
        const carbsCircle = document.getElementById('carbs-circle');
        const fatCircle = document.getElementById('fat-circle');
        const balancePercent = document.getElementById('balance-percent');
        const balanceStatus = document.getElementById('balance-status');
        const nutritionStatus = document.getElementById('nutrition-status');

        // Initialize the app
        function init() {
            renderIngredients();
            loadUserRecipes(); // Load recipes from database
            setupEventListeners();
        }

        // Event listeners
        function setupEventListeners() {
            // Start new recipe
            startNewRecipeBtn.addEventListener('click', startNewRecipe);
            if (startFirstRecipeBtn) {
                startFirstRecipeBtn.addEventListener('click', startNewRecipe);
                console.log('First recipe button listener added');
            }

            // Ingredient search
            ingredientSearch.addEventListener('input', function() {
                searchQuery = this.value.toLowerCase();
                renderIngredients();
            });

            // Category filter
            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    selectedCategory = this.dataset.category;
                    // Update active state
                    categoryButtons.forEach(btn => {
                        if (btn.dataset.category === selectedCategory) {
                            btn.classList.remove('bg-amber-100', 'text-amber-800');
                            btn.classList.add('bg-amber-500', 'text-white');
                        } else {
                            btn.classList.remove('bg-amber-500', 'text-white');
                            btn.classList.add('bg-amber-100', 'text-amber-800');
                        }
                    });
                    renderIngredients();
                });
            });

            // Save recipe
            saveRecipeBtn.addEventListener('click', saveRecipe);

            // Close result modal
            closeResultModalBtn.addEventListener('click', function() {
                recipeResultModal.classList.add('hidden');
                // Make sure recipe list is updated when modal is closed
                updateRecipeList();
                // Scroll to recipe collection
                document.getElementById('recipe-history').scrollIntoView({ behavior: 'smooth' });
            });

            // Delete confirmation modal buttons
            if (cancelDeleteBtn) {
                cancelDeleteBtn.addEventListener('click', hideDeleteConfirmation);
            }

            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', performDelete);
            }

            // Close delete modal when clicking outside
            deleteConfirmationModal.addEventListener('click', function(e) {
                if (e.target === deleteConfirmationModal) {
                    hideDeleteConfirmation();
                }
            });
        }

        // Start a new recipe
        function startNewRecipe() {
            // Make sure the container is visible
            recipeBuilderContainer.classList.remove('hidden');
            recipeBuilderContainer.style.display = 'block';

            // Reset the form
            selectedIngredients = [];
            recipeName.value = '';
            recipeDescription.value = '';
            updateSelectedIngredients();
            updateNutrition();

            // Scroll to the builder
            setTimeout(() => {
                recipeBuilderContainer.scrollIntoView({ behavior: 'smooth' });
            }, 100);

            // Log for debugging
            console.log('Recipe builder opened');
        }


        // Render ingredients list
        function renderIngredients() {
            const filteredIngredients = ingredients.filter(ingredient => {
                const matchesCategory = selectedCategory === 'all' || ingredient.category === selectedCategory;
                const matchesSearch = ingredient.name.toLowerCase().includes(searchQuery);
                return matchesCategory && matchesSearch;
            });

            ingredientsList.innerHTML = '';

            if (filteredIngredients.length === 0) {
                ingredientsList.innerHTML = `
                    <div class="p-4 bg-amber-50 dark:bg-amber-900/30 rounded-lg text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-amber-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <p class="text-amber-800 dark:text-amber-200">No ingredients found. Try a different search or category.</p>
                    </div>
                `;
                return;
            }

            filteredIngredients.forEach(ingredient => {
                const ingredientEl = document.createElement('div');
                ingredientEl.className = 'flex items-center p-2 bg-amber-50 dark:bg-gray-700 rounded-lg hover:bg-amber-100 dark:hover:bg-gray-600 transition-colors cursor-pointer mb-1 w-full';
                ingredientEl.innerHTML = `
                    <div class="h-8 w-8 rounded-full bg-amber-200 dark:bg-amber-800 flex items-center justify-center mr-2">
                        <span class="text-black dark:text-black text-xs">${ingredient.name.charAt(0)}</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900 dark:text-white text-sm">${ingredient.name}</h3>
                        <div class="flex space-x-2 text-xs text-gray-500 dark:text-gray-400">
                            <span>${ingredient.calories} cal</span>
                            <span>•</span>
                            <span>${ingredient.protein}g protein</span>
                        </div>
                    </div>
                    <button class="ml-1 px-2 py-1 bg-amber-500 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transform transition-all duration-200 hover:scale-105 hover:bg-amber-600 hover:translate-y-[-1px] focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add
                        </span>
                    </button>
                `;
                // Add click event to the entire ingredient element
                ingredientEl.addEventListener('click', () => addIngredient(ingredient));

                // Also add specific click event to the Add button
                const addButton = ingredientEl.querySelector('button');
                if (addButton) {
                    addButton.addEventListener('click', (e) => {
                        e.stopPropagation(); // Prevent triggering the parent click event
                        addIngredient(ingredient);
                    });
                }

                ingredientsList.appendChild(ingredientEl);
            });
        }

        // Add ingredient to recipe
        function addIngredient(ingredient) {
            if (!selectedIngredients.some(item => item.id === ingredient.id)) {
                selectedIngredients.push(ingredient);
                updateSelectedIngredients();
                updateNutrition();
            }
        }

        // Remove ingredient from recipe
        function removeIngredient(ingredientId) {
            selectedIngredients = selectedIngredients.filter(item => item.id !== ingredientId);
            updateSelectedIngredients();
            updateNutrition();
        }

        // Update selected ingredients list
        function updateSelectedIngredients() {
            ingredientCount.textContent = `${selectedIngredients.length} items`;

            if (selectedIngredients.length === 0) {
                if (emptyIngredientsMessage) {
                    emptyIngredientsMessage.style.display = 'flex';
                }
                selectedIngredientsList.innerHTML = `
                    <div class="text-sm text-gray-700 dark:text-gray-200 italic flex items-center justify-center h-full" id="empty-ingredients-message">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-gray-400 dark:text-gray-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>Add ingredients from the left panel</p>
                        </div>
                    </div>
                `;
                return;
            }

            if (emptyIngredientsMessage) {
                emptyIngredientsMessage.style.display = 'none';
            }

            selectedIngredientsList.innerHTML = '';
            selectedIngredients.forEach(ingredient => {
                const ingredientEl = document.createElement('div');
                ingredientEl.className = 'flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded-lg group mb-2';
                ingredientEl.innerHTML = `
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-amber-100 dark:bg-amber-800 flex items-center justify-center mr-2">
                            <span class="text-black dark:text-white text-xs">${ingredient.name.charAt(0)}</span>
                        </div>
                        <div>
                            <h4 class="font-medium text-sm">${ingredient.name}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">${ingredient.calories} cal</p>
                        </div>
                    </div>
                    <button class="transition-opacity text-red-500 hover:text-red-700 hover:bg-red-50 p-1 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;
                ingredientEl.querySelector('button').addEventListener('click', () => removeIngredient(ingredient.id));
                selectedIngredientsList.appendChild(ingredientEl);
            });
        }

        // Update nutrition information
        function updateNutrition() {
            const totalCals = selectedIngredients.reduce((sum, item) => sum + item.calories, 0);
            const totalProt = selectedIngredients.reduce((sum, item) => sum + item.protein, 0);
            const totalCarb = selectedIngredients.reduce((sum, item) => sum + item.carbs, 0);
            const totalFats = selectedIngredients.reduce((sum, item) => sum + item.fat, 0);

            totalCalories.textContent = totalCals;
            totalProtein.textContent = totalProt.toFixed(1) + 'g';
            totalCarbs.textContent = totalCarb.toFixed(1) + 'g';
            totalFat.textContent = totalFats.toFixed(1) + 'g';

            const totalMacros = totalProt + totalCarb + totalFats;

            const protPercent = totalMacros > 0 ? Math.round((totalProt / totalMacros) * 100) : 0;
            const carbPercent = totalMacros > 0 ? Math.round((totalCarb / totalMacros) * 100) : 0;
            const fatPercent = totalMacros > 0 ? Math.round((totalFats / totalMacros) * 100) : 0;

            proteinPercent.textContent = protPercent + '%';
            carbsPercent.textContent = carbPercent + '%';
            fatPercent.textContent = fatPercent + '%';

            proteinBar.style.width = protPercent + '%';
            carbsBar.style.width = carbPercent + '%';
            fatBar.style.width = fatPercent + '%';

            // Update circular chart
            proteinCircle.setAttribute('stroke-dasharray', `${protPercent * 2.51} 251.2`);
            carbsCircle.setAttribute('stroke-dasharray', `${carbPercent * 2.51} 251.2`);
            carbsCircle.setAttribute('stroke-dashoffset', `${-protPercent * 2.51}`);
            fatCircle.setAttribute('stroke-dasharray', `${fatPercent * 2.51} 251.2`);
            fatCircle.setAttribute('stroke-dashoffset', `${-(protPercent + carbPercent) * 2.51}`);

            // Check if the recipe is balanced (10-35% protein, 45-65% carbs, 20-35% fat)
            const isBalanced =
                protPercent >= 10 &&
                protPercent <= 35 &&
                carbPercent >= 45 &&
                carbPercent <= 65 &&
                fatPercent >= 20 &&
                fatPercent <= 35;

            // Calculate balance percentage
            const idealProtein = 20; // middle of 10-35%
            const idealCarbs = 55; // middle of 45-65%
            const idealFat = 25; // middle of 20-35%

            const proteinDiff = Math.abs(protPercent - idealProtein);
            const carbsDiff = Math.abs(carbPercent - idealCarbs);
            const fatDiff = Math.abs(fatPercent - idealFat);

            const maxPossibleDiff = 100; // theoretical maximum difference
            const actualDiff = proteinDiff + carbsDiff + fatDiff;
            const balancePercentValue = Math.max(0, Math.round(100 - (actualDiff / maxPossibleDiff) * 100));

            balancePercent.textContent = balancePercentValue + '%';

            if (isBalanced) {
                balanceStatus.textContent = 'Balanced';
                balanceStatus.classList.remove('bg-gray-200', 'text-gray-800', 'bg-red-200', 'text-red-800', 'dark:bg-red-600', 'dark:text-white');
                balanceStatus.classList.add('bg-blue-200', 'text-blue-800', 'dark:bg-blue-600', 'dark:text-white');

                nutritionStatus.textContent = 'Balanced';
                nutritionStatus.classList.remove('bg-gray-200', 'text-gray-800', 'bg-red-200', 'text-red-800', 'dark:bg-red-600', 'dark:text-white');
                nutritionStatus.classList.add('bg-blue-200', 'text-blue-800', 'dark:bg-blue-600', 'dark:text-white');
            } else {
                balanceStatus.textContent = 'Unbalanced';
                balanceStatus.classList.remove('bg-blue-200', 'text-blue-800', 'dark:bg-blue-600', 'dark:text-white');
                balanceStatus.classList.add('bg-red-200', 'text-red-800', 'dark:bg-red-600', 'dark:text-white');

                nutritionStatus.textContent = 'Unbalanced';
                nutritionStatus.classList.remove('bg-blue-200', 'text-blue-800', 'dark:bg-blue-600', 'dark:text-white');
                nutritionStatus.classList.add('bg-red-200', 'text-red-800', 'dark:bg-red-600', 'dark:text-white');
            }
        }

        // Save recipe
        function saveRecipe() {
            if (recipeName.value.trim() === '') {
                alert('Please enter a recipe name');
                return;
            }

            if (selectedIngredients.length === 0) {
                alert('Please add at least one ingredient');
                return;
            }

            // Calculate nutrition values for display
            const totalCals = selectedIngredients.reduce((sum, item) => sum + item.calories, 0);
            const totalProt = selectedIngredients.reduce((sum, item) => sum + item.protein, 0);
            const totalCarb = selectedIngredients.reduce((sum, item) => sum + item.carbs, 0);
            const totalFats = selectedIngredients.reduce((sum, item) => sum + item.fat, 0);

            const totalMacros = totalProt + totalCarb + totalFats;
            const protPercent = totalMacros > 0 ? Math.round((totalProt / totalMacros) * 100) : 0;
            const carbPercent = totalMacros > 0 ? Math.round((totalCarb / totalMacros) * 100) : 0;
            const fatPercent = totalMacros > 0 ? Math.round((totalFats / totalMacros) * 100) : 0;

            const isBalanced =
                protPercent >= 10 &&
                protPercent <= 35 &&
                carbPercent >= 45 &&
                carbPercent <= 65 &&
                fatPercent >= 20 &&
                fatPercent <= 35;

            // Calculate balance percentage
            const idealProtein = 20;
            const idealCarbs = 55;
            const idealFat = 25;

            const proteinDiff = Math.abs(protPercent - idealProtein);
            const carbsDiff = Math.abs(carbPercent - idealCarbs);
            const fatDiff = Math.abs(fatPercent - idealFat);

            const maxPossibleDiff = 100;
            const actualDiff = proteinDiff + carbsDiff + fatDiff;
            const balancePercentValue = Math.max(0, Math.round(100 - (actualDiff / maxPossibleDiff) * 100));

            // Prepare recipe data for server
            const recipeData = {
                name: recipeName.value,
                description: recipeDescription.value,
                template_id: null, // No template selected in this version
                ingredients: selectedIngredients.map(ingredient => ({
                    id: ingredient.id,
                    quantity: 1 // Default quantity
                }))
            };

            // Send to server using AJAX
            fetch('/recipe-builder/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(recipeData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Recipe saved to database:', data.recipe);
                    // Show success modal
                    showResultModal(data.recipe);
                    // Reload recipes from server
                    loadUserRecipes();
                } else {
                    alert('Error saving recipe: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error saving recipe:', error);
                alert('Error saving recipe. Please try again.');
            });
        }

        // Show result modal
        function showResultModal(recipe) {
            resultTitle.textContent = 'Recipe Saved!';
            resultContent.innerHTML = `
                <p class="mb-2">
                    Your recipe <span class="font-semibold">${recipe.name}</span> has been saved to your collection.
                </p>
                <p class="mb-2">
                    ${recipe.isBalanced
                        ? `Congratulations! Your recipe is nutritionally balanced with a score of ${recipe.score}%.`
                        : `Your recipe has a balance score of ${recipe.score}%. Try adding more ingredients to improve the balance.`
                    }
                </p>
                <p class="mt-4 text-amber-400 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Your recipe will be reviewed by a teacher. You'll receive ${recipe.potential_points} points after approval.
                </p>
            `;
            recipeResultModal.classList.remove('hidden');
        }

        // Load user recipes from the server
        function loadUserRecipes() {
            fetch('/recipe-builder/user-recipes')
                .then(response => response.json())
                .then(data => {
                    userRecipes = data;
                    updateRecipeList();
                })
                .catch(error => {
                    console.error('Error loading recipes:', error);
                });
        }

        // Update recipe list
        function updateRecipeList() {
            recipeCount.textContent = `${userRecipes.length} ${userRecipes.length === 1 ? 'recipe' : 'recipes'}`;
            console.log('Updating recipe list. Recipes count:', userRecipes.length);

            if (userRecipes.length === 0) {
                recipeList.innerHTML = '';
                if (emptyRecipeMessage) {
                    emptyRecipeMessage.style.display = 'block';
                }
                return;
            }

            if (emptyRecipeMessage) {
                emptyRecipeMessage.style.display = 'none';
            }
            recipeList.innerHTML = '';

            userRecipes.forEach(recipe => {
                const recipeEl = document.createElement('div');
                recipeEl.className = 'group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02] overflow-hidden border border-gray-300 dark:border-gray-700';

                // Format date - handle both database and JS date formats
                let formattedDate;
                if (recipe.created_at) {
                    // Database format
                    formattedDate = new Date(recipe.created_at).toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    });
                } else if (recipe.createdAt) {
                    // JS memory format
                    formattedDate = new Date(recipe.createdAt).toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    });
                } else {
                    formattedDate = 'Unknown date';
                }

                // Handle different property naming between JS and database
                const isBalanced = recipe.is_balanced !== undefined ? recipe.is_balanced : recipe.isBalanced;
                const totalCalories = recipe.total_calories !== undefined ? recipe.total_calories : recipe.totalCalories;
                const score = recipe.score !== undefined ? recipe.score : recipe.score;
                const totalProtein = recipe.total_protein !== undefined ? recipe.total_protein : recipe.totalProtein;
                const totalCarbs = recipe.total_carbs !== undefined ? recipe.total_carbs : recipe.totalCarbs;

                recipeEl.innerHTML = `
                    <div class="h-3 bg-amber-400"></div>
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">${recipe.name}</h3>
                            <span class="px-2 py-1 bg-${isBalanced ? 'blue' : 'red'}-200 text-${isBalanced ? 'blue' : 'red'}-800 dark:bg-${isBalanced ? 'blue' : 'red'}-600 dark:text-white rounded-full text-xs font-medium">
                                ${isBalanced ? 'Balanced' : 'Unbalanced'}
                            </span>
                        </div>

                        <p class="text-sm text-gray-700 dark:text-gray-400 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            ${formattedDate}
                        </p>

                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="flex items-center bg-gray-100 dark:bg-gray-700 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                </svg>
                                <span class="text-xs font-medium">${totalCalories} cal</span>
                            </div>
                            <div class="flex items-center bg-gray-100 dark:bg-gray-700 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                <span class="text-xs font-medium">${score} pts</span>
                            </div>
                            <div class="flex items-center bg-gray-100 dark:bg-gray-700 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span class="text-xs font-medium">${Math.round(totalProtein)}g protein</span>
                            </div>
                            <div class="flex items-center bg-gray-100 dark:bg-gray-700 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                                </svg>
                                <span class="text-xs font-medium">${Math.round(totalCarbs)}g carbs</span>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <button class="view-recipe flex-1 bg-gray-700 dark:bg-gray-600 hover:bg-gray-800 dark:hover:bg-gray-500 text-white px-4 py-2 rounded-lg flex items-center justify-center" data-id="${recipe.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View
                            </button>
                            <button class="delete-recipe-btn hover:bg-red-100 hover:text-red-700 dark:hover:bg-red-900 dark:hover:text-red-200 border border-gray-300 dark:border-gray-600 px-3 py-2 rounded-lg" data-id="${recipe.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    `;

                recipeList.appendChild(recipeEl);

                // Add view event listener
                recipeEl.querySelector('.view-recipe').addEventListener('click', function() {
                    const recipeId = this.dataset.id;
                    viewRecipe(recipeId);
                });

                // Add delete event listener
                recipeEl.querySelector('.delete-recipe-btn').addEventListener('click', function() {
                    const recipeId = this.dataset.id;
                    deleteRecipe(recipeId);
                });
            });
        }

        // View recipe details
        function viewRecipe(recipeId) {
            fetch(`/recipe-builder/user-recipe/${recipeId}`)
                .then(response => response.json())
                .then(recipe => {
                    resultTitle.textContent = 'Recipe Details';

                    let content = `
                        <div class="mb-4">
                            <h4 class="font-medium text-lg">${recipe.name}</h4>
                            ${recipe.description ? `<p class="text-gray-600 dark:text-gray-400">${recipe.description}</p>` : ''}
                        </div>

                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="flex items-center bg-gray-100 dark:bg-gray-700 p-2 rounded-lg">
                                <span class="text-xs font-medium">${recipe.total_calories} calories</span>
                            </div>
                            <div class="flex items-center bg-gray-100 dark:bg-gray-700 p-2 rounded-lg">
                                <span class="text-xs font-medium">${recipe.score} points</span>
                            </div>
                        </div>
                    `;

                    // Add ingredients list
                    if (recipe.ingredients && recipe.ingredients.length > 0) {
                        content += `
                            <div>
                                <h5 class="font-medium">Ingredients</h5>
                                <ul class="list-disc list-inside mt-2">
                                    ${recipe.ingredients.map(ingredient =>
                                        `<li>${ingredient.pivot.quantity} × ${ingredient.name}</li>`
                                    ).join('')}
                                </ul>
                            </div>
                        `;
                    }

                    resultContent.innerHTML = content;
                    recipeResultModal.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error loading recipe:', error);
                    alert('Error loading recipe details. Please try again.');
                });
        }

        // Variables for delete confirmation modal
        const deleteConfirmationModal = document.getElementById('delete-confirmation-modal');
        const cancelDeleteBtn = document.getElementById('cancel-delete');
        const confirmDeleteBtn = document.getElementById('confirm-delete');
        let recipeToDelete = null;

        // Show delete confirmation modal
        function showDeleteConfirmation(recipeId) {
            recipeToDelete = recipeId;
            deleteConfirmationModal.classList.remove('hidden');
        }

        // Hide delete confirmation modal
        function hideDeleteConfirmation() {
            deleteConfirmationModal.classList.add('hidden');
            recipeToDelete = null;
        }

        // Delete recipe
        function deleteRecipe(recipeId) {
            // Show the confirmation modal instead of using browser confirm
            showDeleteConfirmation(recipeId);
        }

        // Actual delete function that gets called after confirmation
        function performDelete() {
            if (!recipeToDelete) return;

            const recipeId = recipeToDelete;

            // Hide the modal
            hideDeleteConfirmation();

            fetch(`/recipe-builder/delete/${recipeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload recipes from server
                    loadUserRecipes();
                } else {
                    alert('Error deleting recipe: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error deleting recipe:', error);
                alert('Error deleting recipe. Please try again.');
            });
        }

        // Challenge-related variables
        let availableChallenges = [];
        let activeChallenge = null;

        // Challenge-related DOM elements
        const challengeList = document.getElementById('challenge-list');
        const emptyChallengeMessage = document.getElementById('empty-challenge-message');
        const challengeCount = document.getElementById('challenge-count');
        const activeChallengePanel = document.getElementById('active-challenge-panel');
        const activeChallengeName = document.getElementById('active-challenge-name');
        const activeChallengeDescription = document.getElementById('active-challenge-description');
        const challengeRequirements = document.getElementById('challenge-requirements');
        const challengeProgress = document.getElementById('challenge-progress');
        const challengeDifficulty = document.getElementById('challenge-difficulty');
        const challengeReward = document.getElementById('challenge-reward');
        const cancelChallengeBtn = document.getElementById('cancel-challenge');

        // Load available challenges
        function loadChallenges() {
            fetch('/recipe-builder/templates')
                .then(response => response.json())
                .then(data => {
                    availableChallenges = data;
                    updateChallengeList();
                })
                .catch(error => {
                    console.error('Error loading challenges:', error);
                });
        }

        // Update challenge list
        function updateChallengeList() {
            challengeCount.textContent = `${availableChallenges.length} ${availableChallenges.length === 1 ? 'Challenge' : 'Challenges'}`;

            if (availableChallenges.length === 0) {
                challengeList.innerHTML = '';
                emptyChallengeMessage.classList.remove('hidden');
                return;
            }

            emptyChallengeMessage.classList.add('hidden');
            challengeList.innerHTML = '';

            availableChallenges.forEach(challenge => {
                const challengeEl = document.createElement('div');
                challengeEl.className = 'group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02] overflow-hidden border border-orange-200 dark:border-orange-900';

                // Determine difficulty badge color
                let difficultyColor = 'green';
                if (challenge.difficulty_level === 'intermediate') {
                    difficultyColor = 'yellow';
                } else if (challenge.difficulty_level === 'advanced') {
                    difficultyColor = 'red';
                }

                challengeEl.innerHTML = `
                    <div class="h-2 bg-orange-400"></div>
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">${challenge.name}</h3>
                            <span class="px-2 py-1 bg-${difficultyColor}-200 text-black dark:bg-${difficultyColor}-600 dark:text-black rounded-full text-xs font-medium">
                                ${challenge.difficulty_level.charAt(0).toUpperCase() + challenge.difficulty_level.slice(1)}
                            </span>
                        </div>

                        <p class="text-sm text-black dark:text-gray-400 mb-4 line-clamp-2">${challenge.description}</p>

                        <div class="flex items-center justify-between mb-4 text-xs text-black dark:text-gray-400">
                            <span>Calories: ${challenge.target_calories_min}-${challenge.target_calories_max}</span>
                            <span>Reward: ${challenge.points_reward} pts</span>
                        </div>

                        <button class="start-challenge-btn w-full bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg flex items-center justify-center" data-id="${challenge.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Start Challenge
                        </button>
                    </div>
                `;

                challengeList.appendChild(challengeEl);

                // Add event listener to start challenge button
                challengeEl.querySelector('.start-challenge-btn').addEventListener('click', function() {
                    const challengeId = this.dataset.id;
                    startChallenge(challengeId);
                });
            });
        }

        // Start a challenge
        function startChallenge(challengeId) {
            const challenge = availableChallenges.find(c => c.id == challengeId);
            if (!challenge) return;

            activeChallenge = challenge;

            // Update active challenge panel
            activeChallengeName.textContent = challenge.name;
            activeChallengeDescription.textContent = challenge.description;
            challengeDifficulty.textContent = challenge.difficulty_level.charAt(0).toUpperCase() + challenge.difficulty_level.slice(1);
            challengeReward.textContent = `${challenge.points_reward} points`;

            // Update requirements list
            challengeRequirements.innerHTML = '';

            // Add calorie requirement
            const calorieItem = document.createElement('li');
            calorieItem.className = 'flex items-center justify-between';
            calorieItem.innerHTML = `
                <span>Calories:</span>
                <span class="font-medium">${challenge.target_calories_min} - ${challenge.target_calories_max}</span>
            `;
            challengeRequirements.appendChild(calorieItem);

            // Add macronutrient requirements if they exist
            if (challenge.target_protein_min) {
                const proteinItem = document.createElement('li');
                proteinItem.className = 'flex items-center justify-between';
                proteinItem.innerHTML = `
                    <span>Protein:</span>
                    <span class="font-medium">${challenge.target_protein_min}g - ${challenge.target_protein_max}g</span>
                `;
                challengeRequirements.appendChild(proteinItem);
            }

            if (challenge.target_carbs_min) {
                const carbsItem = document.createElement('li');
                carbsItem.className = 'flex items-center justify-between';
                carbsItem.innerHTML = `
                    <span>Carbs:</span>
                    <span class="font-medium">${challenge.target_carbs_min}g - ${challenge.target_carbs_max}g</span>
                `;
                challengeRequirements.appendChild(carbsItem);
            }

            if (challenge.target_fat_min) {
                const fatItem = document.createElement('li');
                fatItem.className = 'flex items-center justify-between';
                fatItem.innerHTML = `
                    <span>Fat:</span>
                    <span class="font-medium">${challenge.target_fat_min}g - ${challenge.target_fat_max}g</span>
                `;
                challengeRequirements.appendChild(fatItem);
            }

            // Add required categories if they exist
            if (challenge.required_categories && challenge.required_categories.length > 0) {
                const categoriesItem = document.createElement('li');
                categoriesItem.className = 'flex items-center justify-between';
                categoriesItem.innerHTML = `
                    <span>Required Categories:</span>
                    <span class="font-medium">${challenge.required_categories.join(', ')}</span>
                `;
                challengeRequirements.appendChild(categoriesItem);
            }

            // Add max ingredients if it exists
            if (challenge.max_ingredients) {
                const maxIngredientsItem = document.createElement('li');
                maxIngredientsItem.className = 'flex items-center justify-between';
                maxIngredientsItem.innerHTML = `
                    <span>Max Ingredients:</span>
                    <span class="font-medium">${challenge.max_ingredients}</span>
                `;
                challengeRequirements.appendChild(maxIngredientsItem);
            }

            // Show active challenge panel
            activeChallengePanel.classList.remove('hidden');

            // Start a new recipe
            startNewRecipe();

            // Update progress (initially all requirements are not met)
            updateChallengeProgress();
        }

        // Cancel active challenge
        function cancelChallenge() {
            activeChallenge = null;
            activeChallengePanel.classList.add('hidden');
        }

        // Update challenge progress based on current recipe
        function updateChallengeProgress() {
            if (!activeChallenge) return;

            challengeProgress.innerHTML = '';

            // Calculate current nutritional values
            const totalCals = selectedIngredients.reduce((sum, item) => sum + item.calories, 0);
            const totalProt = selectedIngredients.reduce((sum, item) => sum + item.protein, 0);
            const totalCarb = selectedIngredients.reduce((sum, item) => sum + item.carbs, 0);
            const totalFats = selectedIngredients.reduce((sum, item) => sum + item.fat, 0);

            // Check calorie requirement
            const calorieItem = document.createElement('li');
            calorieItem.className = 'flex items-center justify-between';
            const caloriesInRange = totalCals >= activeChallenge.target_calories_min && totalCals <= activeChallenge.target_calories_max;
            calorieItem.innerHTML = `
                <span>Calories:</span>
                <span class="font-medium flex items-center">
                    ${totalCals}
                    ${caloriesInRange
                        ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>'
                        : '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>'}
                </span>
            `;
            challengeProgress.appendChild(calorieItem);

            // Check protein requirement if it exists
            if (activeChallenge.target_protein_min) {
                const proteinItem = document.createElement('li');
                proteinItem.className = 'flex items-center justify-between';
                const proteinInRange = totalProt >= activeChallenge.target_protein_min && totalProt <= activeChallenge.target_protein_max;
                proteinItem.innerHTML = `
                    <span>Protein:</span>
                    <span class="font-medium flex items-center">
                        ${totalProt.toFixed(1)}g
                        ${proteinInRange
                            ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>'
                            : '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>'}
                    </span>
                `;
                challengeProgress.appendChild(proteinItem);
            }

            // Check carbs requirement if it exists
            if (activeChallenge.target_carbs_min) {
                const carbsItem = document.createElement('li');
                carbsItem.className = 'flex items-center justify-between';
                const carbsInRange = totalCarb >= activeChallenge.target_carbs_min && totalCarb <= activeChallenge.target_carbs_max;
                carbsItem.innerHTML = `
                    <span>Carbs:</span>
                    <span class="font-medium flex items-center">
                        ${totalCarb.toFixed(1)}g
                        ${carbsInRange
                            ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>'
                            : '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>'}
                    </span>
                `;
                challengeProgress.appendChild(carbsItem);
            }

            // Check fat requirement if it exists
            if (activeChallenge.target_fat_min) {
                const fatItem = document.createElement('li');
                fatItem.className = 'flex items-center justify-between';
                const fatInRange = totalFats >= activeChallenge.target_fat_min && totalFats <= activeChallenge.target_fat_max;
                fatItem.innerHTML = `
                    <span>Fat:</span>
                    <span class="font-medium flex items-center">
                        ${totalFats.toFixed(1)}g
                        ${fatInRange
                            ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>'
                            : '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>'}
                    </span>
                `;
                challengeProgress.appendChild(fatItem);
            }

            // Check required categories if they exist
            if (activeChallenge.required_categories && activeChallenge.required_categories.length > 0) {
                const categoriesItem = document.createElement('li');
                categoriesItem.className = 'flex items-center justify-between';

                // Get unique categories from selected ingredients
                const selectedCategories = [...new Set(selectedIngredients.map(ingredient => ingredient.category))];

                // Check if all required categories are included
                const allCategoriesIncluded = activeChallenge.required_categories.every(category =>
                    selectedCategories.includes(category)
                );

                categoriesItem.innerHTML = `
                    <span>Categories:</span>
                    <span class="font-medium flex items-center">
                        ${selectedCategories.join(', ')}
                        ${allCategoriesIncluded
                            ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>'
                            : '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>'}
                    </span>
                `;
                challengeProgress.appendChild(categoriesItem);
            }

            // Check max ingredients if it exists
            if (activeChallenge.max_ingredients) {
                const maxIngredientsItem = document.createElement('li');
                maxIngredientsItem.className = 'flex items-center justify-between';
                const withinMaxIngredients = selectedIngredients.length <= activeChallenge.max_ingredients;
                maxIngredientsItem.innerHTML = `
                    <span>Ingredients Count:</span>
                    <span class="font-medium flex items-center">
                        ${selectedIngredients.length}/${activeChallenge.max_ingredients}
                        ${withinMaxIngredients
                            ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>'
                            : '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>'}
                    </span>
                `;
                challengeProgress.appendChild(maxIngredientsItem);
            }
        }

        // Add ingredient to recipe (override the existing function)
        function addIngredient(ingredient) {
            if (!selectedIngredients.some(item => item.id === ingredient.id)) {
                selectedIngredients.push(ingredient);
                updateSelectedIngredients();
                updateNutrition();

                // Update challenge progress if a challenge is active
                if (activeChallenge) {
                    updateChallengeProgress();
                }
            }
        }

        // Remove ingredient from recipe (override the existing function)
        function removeIngredient(ingredientId) {
            selectedIngredients = selectedIngredients.filter(item => item.id !== ingredientId);
            updateSelectedIngredients();
            updateNutrition();

            // Update challenge progress if a challenge is active
            if (activeChallenge) {
                updateChallengeProgress();
            }
        }

        // Save recipe (override the existing function)
        function saveRecipe() {
            if (recipeName.value.trim() === '') {
                alert('Please enter a recipe name');
                return;
            }

            if (selectedIngredients.length === 0) {
                alert('Please add at least one ingredient');
                return;
            }

            // Calculate nutrition values for display
            const totalCals = selectedIngredients.reduce((sum, item) => sum + item.calories, 0);
            const totalProt = selectedIngredients.reduce((sum, item) => sum + item.protein, 0);
            const totalCarb = selectedIngredients.reduce((sum, item) => sum + item.carbs, 0);
            const totalFats = selectedIngredients.reduce((sum, item) => sum + item.fat, 0);

            const totalMacros = totalProt + totalCarb + totalFats;
            const protPercent = totalMacros > 0 ? Math.round((totalProt / totalMacros) * 100) : 0;
            const carbPercent = totalMacros > 0 ? Math.round((totalCarb / totalMacros) * 100) : 0;
            const fatPercent = totalMacros > 0 ? Math.round((totalFats / totalMacros) * 100) : 0;

            const isBalanced =
                protPercent >= 10 &&
                protPercent <= 35 &&
                carbPercent >= 45 &&
                carbPercent <= 65 &&
                fatPercent >= 20 &&
                fatPercent <= 35;

            // Calculate balance percentage
            const idealProtein = 20;
            const idealCarbs = 55;
            const idealFat = 25;

            const proteinDiff = Math.abs(protPercent - idealProtein);
            const carbsDiff = Math.abs(carbPercent - idealCarbs);
            const fatDiff = Math.abs(fatPercent - idealFat);

            const maxPossibleDiff = 100;
            const actualDiff = proteinDiff + carbsDiff + fatDiff;
            const balancePercentValue = Math.max(0, Math.round(100 - (actualDiff / maxPossibleDiff) * 100));

            // Prepare recipe data for server
            const recipeData = {
                name: recipeName.value,
                description: recipeDescription.value,
                template_id: activeChallenge ? activeChallenge.id : null,
                ingredients: selectedIngredients.map(ingredient => ({
                    id: ingredient.id,
                    quantity: 1 // Default quantity
                }))
            };

            // Send to server using AJAX
            fetch('/recipe-builder/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(recipeData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Recipe saved to database:', data.recipe);
                    // Show success modal
                    showResultModal(data.recipe);
                    // Reload recipes from server
                    loadUserRecipes();
                    // Reset active challenge if there was one
                    if (activeChallenge) {
                        cancelChallenge();
                    }
                } else {
                    alert('Error saving recipe: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error saving recipe:', error);
                alert('Error saving recipe. Please try again.');
            });
        }

        // Add event listeners for challenge-related elements
        function setupChallengeEventListeners() {
            // Cancel challenge button
            if (cancelChallengeBtn) {
                cancelChallengeBtn.addEventListener('click', cancelChallenge);
            }
        }

        // Extend the init function to include challenge initialization
        const originalInit = init;
        init = function() {
            originalInit();
            loadChallenges();
            setupChallengeEventListeners();
        };

        // Initialize the app
        init();
    });
    </script>
</x-layouts.app>