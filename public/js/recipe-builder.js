/**
 * Recipe Builder Game
 *
 * This script handles the interactive functionality of the Recipe Builder game.
 * Enhanced with animations and interactive features.
 */

document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const startNewRecipeBtn = document.getElementById('start-new-recipe');
    const startFirstRecipeBtn = document.getElementById('start-first-recipe');
    const recipeBuilderContainer = document.getElementById('recipe-builder-container');
    const recipeHistoryContainer = document.getElementById('recipe-history');
    const ingredientsList = document.getElementById('ingredients-list');
    const selectedIngredientsList = document.getElementById('selected-ingredients');
    const recipeNameInput = document.getElementById('recipe-name');
    const recipeDescriptionInput = document.getElementById('recipe-description');
    const recipeChallengeSelect = document.getElementById('recipe-challenge');
    const challengeDescription = document.getElementById('challenge-description');
    const saveRecipeBtn = document.getElementById('save-recipe');
    const categoryButtons = document.querySelectorAll('.ingredient-category-btn');
    const ingredientSearchInput = document.getElementById('ingredient-search');
    const ingredientCountEl = document.getElementById('ingredient-count');

    // Nutritional information elements
    const totalCaloriesEl = document.getElementById('total-calories');
    const totalProteinEl = document.getElementById('total-protein');
    const totalCarbsEl = document.getElementById('total-carbs');
    const totalFatEl = document.getElementById('total-fat');
    const proteinBarEl = document.getElementById('protein-bar');
    const carbsBarEl = document.getElementById('carbs-bar');
    const fatBarEl = document.getElementById('fat-bar');
    const proteinPercentEl = document.getElementById('protein-percent');
    const carbsPercentEl = document.getElementById('carbs-percent');
    const fatPercentEl = document.getElementById('fat-percent');

    // Enhanced nutritional elements
    const nutritionStatusEl = document.getElementById('nutrition-status');
    const balanceStatusEl = document.getElementById('balance-status');
    const balancePercentEl = document.getElementById('balance-percent');
    const proteinCircleEl = document.getElementById('protein-circle');
    const carbsCircleEl = document.getElementById('carbs-circle');
    const fatCircleEl = document.getElementById('fat-circle');
    const nutritionTipEl = document.getElementById('nutrition-tip');

    // Modal elements
    const recipeResultModal = document.getElementById('recipe-result-modal');
    const resultTitle = document.getElementById('result-title');
    const resultContent = document.getElementById('result-content');
    const closeResultModalBtn = document.getElementById('close-result-modal');

    // State variables
    let allIngredients = [];
    let selectedIngredients = [];
    let currentTemplate = null;
    let filteredIngredients = [];

    // Event Listeners
    startNewRecipeBtn.addEventListener('click', startNewRecipe);
    if (startFirstRecipeBtn) {
        startFirstRecipeBtn.addEventListener('click', startNewRecipe);
    }
    saveRecipeBtn.addEventListener('click', saveRecipe);
    closeResultModalBtn.addEventListener('click', closeResultModal);
    recipeChallengeSelect.addEventListener('change', loadChallengeTemplate);

    // Add search functionality
    if (ingredientSearchInput) {
        ingredientSearchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase().trim();
            if (searchTerm === '') {
                // If search is cleared, revert to current category filter
                const activeCategory = Array.from(categoryButtons).find(btn =>
                    btn.classList.contains('bg-amber-500')).dataset.category;
                filterIngredientsByCategory(activeCategory);
            } else {
                // Filter based on search term
                searchIngredients(searchTerm);
            }
        });
    }

    // Add event listeners to category buttons with enhanced styling
    categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            categoryButtons.forEach(btn => {
                btn.classList.remove('bg-amber-500', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-800', 'dark:bg-gray-600', 'dark:text-gray-200');
            });

            // Add active class to clicked button with animation
            button.classList.remove('bg-gray-100', 'text-gray-800', 'dark:bg-gray-600', 'dark:text-gray-200');
            button.classList.add('bg-amber-500', 'text-white');

            // Apply a subtle animation
            button.classList.add('scale-105');
            setTimeout(() => {
                button.classList.remove('scale-105');
            }, 200);

            // Filter ingredients by category
            filterIngredientsByCategory(button.dataset.category);
        });
    });

    // Initialize by loading all ingredients with loading animation
    loadIngredients();

    // Add event listeners to view and delete recipe buttons
    document.querySelectorAll('.view-recipe').forEach(button => {
        button.addEventListener('click', () => {
            // Add click animation
            button.classList.add('scale-95');
            setTimeout(() => {
                button.classList.remove('scale-95');
                viewRecipe(button.dataset.id);
            }, 150);
        });
    });

    document.querySelectorAll('.delete-recipe').forEach(button => {
        button.addEventListener('click', () => {
            // Add click animation
            button.classList.add('scale-95');
            setTimeout(() => {
                button.classList.remove('scale-95');
                deleteRecipe(button.dataset.id);
            }, 150);
        });
    });

    // Add nutrition tips rotation
    if (nutritionTipEl) {
        const tips = [
            "A balanced meal typically contains 10-35% protein, 45-65% carbs, and 20-35% fat.",
            "Proteins are essential for muscle building and repair.",
            "Complex carbs provide sustained energy throughout the day.",
            "Healthy fats support brain function and hormone production.",
            "Try to include at least 3 different food groups in each meal.",
            "Colorful vegetables indicate a variety of nutrients and antioxidants.",
            "Whole grains provide more fiber and nutrients than refined grains."
        ];

        let tipIndex = 0;
        setInterval(() => {
            tipIndex = (tipIndex + 1) % tips.length;
            // Fade out, change text, fade in
            nutritionTipEl.style.opacity = '0';
            setTimeout(() => {
                nutritionTipEl.textContent = tips[tipIndex];
                nutritionTipEl.style.opacity = '1';
            }, 500);
        }, 8000); // Change tip every 8 seconds
    }

    /**
     * Start a new recipe with animation
     */
    function startNewRecipe() {
        // Fade out history, fade in builder
        recipeHistoryContainer.style.opacity = '0';
        recipeHistoryContainer.style.transform = 'translateY(20px)';

        setTimeout(() => {
            // Hide history, show builder
            recipeBuilderContainer.classList.remove('hidden');
            recipeHistoryContainer.classList.add('hidden');

            // Fade in builder with animation
            recipeBuilderContainer.style.opacity = '0';
            recipeBuilderContainer.style.transform = 'translateY(-20px)';

            setTimeout(() => {
                recipeBuilderContainer.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                recipeBuilderContainer.style.opacity = '1';
                recipeBuilderContainer.style.transform = 'translateY(0)';
            }, 50);

            // Reset form
            recipeNameInput.value = '';
            recipeDescriptionInput.value = '';
            recipeChallengeSelect.value = '';
            challengeDescription.classList.add('hidden');
            selectedIngredients = [];
            updateSelectedIngredientsList();
            updateNutritionInfo();

            // Set focus on recipe name with slight delay for animation
            setTimeout(() => {
                recipeNameInput.focus();
            }, 600);
        }, 300);

        // Reset nutrition status
        if (nutritionStatusEl) nutritionStatusEl.textContent = 'Analyzing...';
        if (balanceStatusEl) balanceStatusEl.textContent = 'Unbalanced';
    }

    /**
     * Load all ingredients from the server with loading animation
     */
    function loadIngredients() {
        // Show loading animation in the ingredients list
        ingredientsList.innerHTML = `
            <div class="animate-pulse space-y-3">
                <div class="flex space-x-4 p-3 bg-white dark:bg-gray-800 rounded-lg">
                    <div class="rounded-full bg-amber-200 dark:bg-gray-700 h-10 w-10"></div>
                    <div class="flex-1 space-y-2 py-1">
                        <div class="h-4 bg-amber-200 dark:bg-gray-700 rounded w-3/4"></div>
                        <div class="h-4 bg-amber-200 dark:bg-gray-700 rounded w-1/2"></div>
                    </div>
                </div>
                <div class="flex space-x-4 p-3 bg-white dark:bg-gray-800 rounded-lg">
                    <div class="rounded-full bg-amber-200 dark:bg-gray-700 h-10 w-10"></div>
                    <div class="flex-1 space-y-2 py-1">
                        <div class="h-4 bg-amber-200 dark:bg-gray-700 rounded w-3/4"></div>
                        <div class="h-4 bg-amber-200 dark:bg-gray-700 rounded w-1/2"></div>
                    </div>
                </div>
                <div class="flex space-x-4 p-3 bg-white dark:bg-gray-800 rounded-lg">
                    <div class="rounded-full bg-amber-200 dark:bg-gray-700 h-10 w-10"></div>
                    <div class="flex-1 space-y-2 py-1">
                        <div class="h-4 bg-amber-200 dark:bg-gray-700 rounded w-3/4"></div>
                        <div class="h-4 bg-amber-200 dark:bg-gray-700 rounded w-1/2"></div>
                    </div>
                </div>
            </div>
        `;

        fetch('/recipe-builder/ingredients')
            .then(response => response.json())
            .then(data => {
                allIngredients = data;
                filteredIngredients = data;

                // Add a slight delay to show the loading animation
                setTimeout(() => {
                    filterIngredientsByCategory('all');
                }, 500);
            })
            .catch(error => {
                console.error('Error loading ingredients:', error);
                ingredientsList.innerHTML = `
                    <div class="p-4 bg-red-50 dark:bg-red-900/30 text-red-800 dark:text-red-200 rounded-lg">
                        <p class="font-medium">Error loading ingredients</p>
                        <p class="text-sm mt-1">Please try refreshing the page</p>
                    </div>
                `;
            });
    }

    /**
     * Filter ingredients by category with animation
     */
    function filterIngredientsByCategory(category) {
        // Apply filter
        if (category !== 'all') {
            filteredIngredients = allIngredients.filter(ingredient => ingredient.category === category);
        } else {
            filteredIngredients = [...allIngredients];
        }

        // Apply any existing search filter
        if (ingredientSearchInput && ingredientSearchInput.value.trim() !== '') {
            const searchTerm = ingredientSearchInput.value.toLowerCase().trim();
            filteredIngredients = filteredIngredients.filter(ingredient =>
                ingredient.name.toLowerCase().includes(searchTerm));
        }

        // Render with fade effect
        ingredientsList.style.opacity = '0.5';
        setTimeout(() => {
            renderIngredientsList(filteredIngredients);
            ingredientsList.style.opacity = '1';
        }, 200);
    }

    /**
     * Search ingredients by name
     */
    function searchIngredients(searchTerm) {
        // Get current category filter
        const activeCategory = Array.from(categoryButtons).find(btn =>
            btn.classList.contains('bg-amber-500')).dataset.category;

        // Apply category filter first
        let baseIngredients = allIngredients;
        if (activeCategory !== 'all') {
            baseIngredients = allIngredients.filter(ingredient => ingredient.category === activeCategory);
        }

        // Then apply search filter
        filteredIngredients = baseIngredients.filter(ingredient =>
            ingredient.name.toLowerCase().includes(searchTerm));

        // Render with fade effect
        ingredientsList.style.opacity = '0.5';
        setTimeout(() => {
            renderIngredientsList(filteredIngredients);
            ingredientsList.style.opacity = '1';
        }, 200);
    }

    /**
     * Render the ingredients list with enhanced visuals
     */
    function renderIngredientsList(ingredients) {
        ingredientsList.innerHTML = '';

        if (ingredients.length === 0) {
            ingredientsList.innerHTML = `
                <div class="p-4 bg-amber-50 dark:bg-amber-900/30 rounded-lg text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-amber-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-sm font-medium text-amber-800 dark:text-amber-200">No ingredients found</p>
                    <p class="text-xs text-amber-600 dark:text-amber-300 mt-1">Try another category or search term</p>
                </div>
            `;
            return;
        }

        // Update ingredient count if element exists
        if (ingredientCountEl) {
            ingredientCountEl.textContent = `${selectedIngredients.length} items`;
        }

        // Create a document fragment for better performance
        const fragment = document.createDocumentFragment();

        ingredients.forEach((ingredient, index) => {
            // Add a slight delay to each item for a staggered animation effect
            const delay = index * 30; // 30ms delay between each item

            const ingredientEl = document.createElement('div');
            ingredientEl.className = 'flex justify-between items-center p-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-amber-50 dark:border-gray-700 mb-2 hover:shadow-md transition-all duration-200 transform opacity-0';
            ingredientEl.style.transform = 'translateY(10px)';

            // Staggered animation
            setTimeout(() => {
                ingredientEl.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                ingredientEl.style.opacity = '1';
                ingredientEl.style.transform = 'translateY(0)';
            }, delay);

            // Left side with icon and name
            const leftSide = document.createElement('div');
            leftSide.className = 'flex items-center flex-1';

            // Category icon
            const iconContainer = document.createElement('div');
            iconContainer.className = 'w-10 h-10 rounded-full flex items-center justify-center mr-3';

            // Set icon and color based on category
            let iconSvg = '';
            let bgColor = '';

            switch(ingredient.category) {
                case 'protein':
                    iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>';
                    bgColor = 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400';
                    break;
                case 'vegetable':
                    iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>';
                    bgColor = 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400';
                    break;
                case 'grain':
                    iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>';
                    bgColor = 'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400';
                    break;
                case 'dairy':
                    iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>';
                    bgColor = 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400';
                    break;
                case 'fruit':
                    iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>';
                    bgColor = 'bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400';
                    break;
                case 'fat':
                    iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>';
                    bgColor = 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400';
                    break;
                default:
                    iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                    bgColor = 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400';
            }

            iconContainer.className += ` ${bgColor}`;
            iconContainer.innerHTML = iconSvg;

            // Name and nutrition info
            const infoContainer = document.createElement('div');
            infoContainer.className = 'flex flex-col';

            const nameSpan = document.createElement('span');
            nameSpan.className = 'text-sm font-medium text-gray-900 dark:text-white';
            nameSpan.textContent = ingredient.name;

            const nutritionSpan = document.createElement('div');
            nutritionSpan.className = 'flex flex-wrap gap-2 mt-1';

            // Calories badge
            const caloriesBadge = document.createElement('span');
            caloriesBadge.className = 'text-xs px-1.5 py-0.5 bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300 rounded';
            caloriesBadge.innerHTML = `<span class="font-medium">${ingredient.calories_per_serving}</span> cal`;

            // Protein badge
            const proteinBadge = document.createElement('span');
            proteinBadge.className = 'text-xs px-1.5 py-0.5 bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 rounded';
            proteinBadge.innerHTML = `<span class="font-medium">${ingredient.protein_grams}</span>g protein`;

            nutritionSpan.appendChild(caloriesBadge);
            nutritionSpan.appendChild(proteinBadge);

            infoContainer.appendChild(nameSpan);
            infoContainer.appendChild(nutritionSpan);

            leftSide.appendChild(iconContainer);
            leftSide.appendChild(infoContainer);

            // Add button with hover effect
            const addBtn = document.createElement('button');
            addBtn.className = 'ml-2 px-3 py-1.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow transform transition-all duration-200 hover:scale-105 hover:translate-y-[-1px] focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50';
            addBtn.innerHTML = `
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add
                </span>
            `;

            // Add click animation
            addBtn.addEventListener('click', (e) => {
                e.preventDefault();
                addBtn.classList.add('scale-90');
                setTimeout(() => {
                    addBtn.classList.remove('scale-90');
                    addIngredient(ingredient);
                }, 150);
            });

            ingredientEl.appendChild(leftSide);
            ingredientEl.appendChild(addBtn);

            fragment.appendChild(ingredientEl);
        });

        ingredientsList.appendChild(fragment);
    }

    /**
     * Add an ingredient to the recipe
     */
    function addIngredient(ingredient) {
        // Check if ingredient is already in the recipe
        const existingIndex = selectedIngredients.findIndex(item => item.id === ingredient.id);

        if (existingIndex >= 0) {
            // Increment quantity if already exists
            selectedIngredients[existingIndex].quantity += 1;
        } else {
            // Add new ingredient with quantity 1
            selectedIngredients.push({
                ...ingredient,
                quantity: 1
            });
        }

        updateSelectedIngredientsList();
        updateNutritionInfo();
    }

    /**
     * Remove an ingredient from the recipe
     */
    function removeIngredient(ingredientId) {
        selectedIngredients = selectedIngredients.filter(item => item.id !== ingredientId);
        updateSelectedIngredientsList();
        updateNutritionInfo();
    }

    /**
     * Update quantity of an ingredient
     */
    function updateIngredientQuantity(ingredientId, newQuantity) {
        const index = selectedIngredients.findIndex(item => item.id === ingredientId);

        if (index >= 0) {
            if (newQuantity <= 0) {
                // Remove if quantity is 0 or less
                removeIngredient(ingredientId);
            } else {
                // Update quantity
                selectedIngredients[index].quantity = newQuantity;
                updateSelectedIngredientsList();
                updateNutritionInfo();
            }
        }
    }

    /**
     * Update the selected ingredients list
     */
    function updateSelectedIngredientsList() {
        selectedIngredientsList.innerHTML = '';

        if (selectedIngredients.length === 0) {
            selectedIngredientsList.innerHTML = '<div class="text-sm text-gray-500 dark:text-gray-400 italic">No ingredients selected yet.</div>';
            return;
        }

        selectedIngredients.forEach(ingredient => {
            const ingredientEl = document.createElement('div');
            ingredientEl.className = 'flex justify-between items-center p-2 bg-white dark:bg-gray-800 rounded-md shadow-sm';

            const nameEl = document.createElement('div');
            nameEl.className = 'flex-1';

            const nameSpan = document.createElement('span');
            nameSpan.className = 'text-sm font-medium text-gray-900 dark:text-white';
            nameSpan.textContent = ingredient.name;

            nameEl.appendChild(nameSpan);

            const quantityContainer = document.createElement('div');
            quantityContainer.className = 'flex items-center space-x-2';

            const decreaseBtn = document.createElement('button');
            decreaseBtn.className = 'w-6 h-6 flex items-center justify-center bg-gray-200 dark:bg-gray-600 rounded-full text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-500';
            decreaseBtn.textContent = '-';
            decreaseBtn.addEventListener('click', () => updateIngredientQuantity(ingredient.id, ingredient.quantity - 1));

            const quantitySpan = document.createElement('span');
            quantitySpan.className = 'text-sm font-medium text-gray-900 dark:text-white';
            quantitySpan.textContent = ingredient.quantity;

            const increaseBtn = document.createElement('button');
            increaseBtn.className = 'w-6 h-6 flex items-center justify-center bg-gray-200 dark:bg-gray-600 rounded-full text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-500';
            increaseBtn.textContent = '+';
            increaseBtn.addEventListener('click', () => updateIngredientQuantity(ingredient.id, ingredient.quantity + 1));

            const removeBtn = document.createElement('button');
            removeBtn.className = 'ml-2 w-6 h-6 flex items-center justify-center bg-red-200 dark:bg-red-900 rounded-full text-red-800 dark:text-red-200 hover:bg-red-300 dark:hover:bg-red-800';
            removeBtn.textContent = '×';
            removeBtn.addEventListener('click', () => removeIngredient(ingredient.id));

            quantityContainer.appendChild(decreaseBtn);
            quantityContainer.appendChild(quantitySpan);
            quantityContainer.appendChild(increaseBtn);
            quantityContainer.appendChild(removeBtn);

            ingredientEl.appendChild(nameEl);
            ingredientEl.appendChild(quantityContainer);

            selectedIngredientsList.appendChild(ingredientEl);
        });
    }

    /**
     * Update nutritional information with animations and enhanced visuals
     */
    function updateNutritionInfo() {
        let totalCalories = 0;
        let totalProtein = 0;
        let totalCarbs = 0;
        let totalFat = 0;

        selectedIngredients.forEach(ingredient => {
            totalCalories += ingredient.calories_per_serving * ingredient.quantity;
            totalProtein += ingredient.protein_grams * ingredient.quantity;
            totalCarbs += ingredient.carbs_grams * ingredient.quantity;
            totalFat += ingredient.fat_grams * ingredient.quantity;
        });

        // Round values for display
        const roundedCalories = Math.round(totalCalories);
        const roundedProtein = Math.round(totalProtein * 10) / 10;
        const roundedCarbs = Math.round(totalCarbs * 10) / 10;
        const roundedFat = Math.round(totalFat * 10) / 10;

        // Animate the counter values with a smooth transition
        animateCounter(totalCaloriesEl, roundedCalories);
        animateCounter(totalProteinEl, roundedProtein, 'g');
        animateCounter(totalCarbsEl, roundedCarbs, 'g');
        animateCounter(totalFatEl, roundedFat, 'g');

        // Update ingredient count
        if (ingredientCountEl) {
            ingredientCountEl.textContent = `${selectedIngredients.length} items`;
        }

        // Calculate macronutrient percentages
        const totalCaloriesFromMacros =
            (totalProtein * 4) +
            (totalCarbs * 4) +
            (totalFat * 9);

        if (totalCaloriesFromMacros > 0) {
            const proteinPercent = (totalProtein * 4) / totalCaloriesFromMacros * 100;
            const carbsPercent = (totalCarbs * 4) / totalCaloriesFromMacros * 100;
            const fatPercent = (totalFat * 9) / totalCaloriesFromMacros * 100;

            // Update progress bars with smooth transition
            proteinBarEl.style.transition = 'width 1s ease-in-out';
            carbsBarEl.style.transition = 'width 1s ease-in-out';
            fatBarEl.style.transition = 'width 1s ease-in-out';

            proteinBarEl.style.width = proteinPercent + '%';
            carbsBarEl.style.width = carbsPercent + '%';
            fatBarEl.style.width = fatPercent + '%';

            // Update percentage text
            proteinPercentEl.textContent = Math.round(proteinPercent) + '%';
            carbsPercentEl.textContent = Math.round(carbsPercent) + '%';
            fatPercentEl.textContent = Math.round(fatPercent) + '%';

            // Update circular progress if elements exist
            if (proteinCircleEl && carbsCircleEl && fatCircleEl) {
                const circumference = 2 * Math.PI * 40; // r=40

                // Calculate stroke dasharray values
                const proteinDashArray = (proteinPercent / 100) * circumference;
                const carbsDashArray = (carbsPercent / 100) * circumference;
                const fatDashArray = (fatPercent / 100) * circumference;

                // Calculate stroke dashoffset values (to position each arc correctly)
                const proteinOffset = 0;
                const carbsOffset = proteinDashArray;
                const fatOffset = proteinDashArray + carbsDashArray;

                // Update the SVG circles with animation
                proteinCircleEl.style.transition = 'stroke-dasharray 1s ease-in-out';
                carbsCircleEl.style.transition = 'stroke-dasharray 1s ease-in-out, stroke-dashoffset 1s ease-in-out';
                fatCircleEl.style.transition = 'stroke-dasharray 1s ease-in-out, stroke-dashoffset 1s ease-in-out';

                proteinCircleEl.setAttribute('stroke-dasharray', `${proteinDashArray} ${circumference - proteinDashArray}`);
                carbsCircleEl.setAttribute('stroke-dasharray', `${carbsDashArray} ${circumference - carbsDashArray}`);
                carbsCircleEl.setAttribute('stroke-dashoffset', -proteinOffset);
                fatCircleEl.setAttribute('stroke-dasharray', `${fatDashArray} ${circumference - fatDashArray}`);
                fatCircleEl.setAttribute('stroke-dashoffset', -carbsOffset);

                // Update balance percentage
                if (balancePercentEl) {
                    // Calculate balance score based on ideal macronutrient ranges
                    // Protein: 10-35%, Carbs: 45-65%, Fat: 20-35%
                    let balanceScore = 100;

                    if (proteinPercent < 10) balanceScore -= (10 - proteinPercent) * 2;
                    if (proteinPercent > 35) balanceScore -= (proteinPercent - 35) * 2;

                    if (carbsPercent < 45) balanceScore -= (45 - carbsPercent) * 2;
                    if (carbsPercent > 65) balanceScore -= (carbsPercent - 65) * 2;

                    if (fatPercent < 20) balanceScore -= (20 - fatPercent) * 2;
                    if (fatPercent > 35) balanceScore -= (fatPercent - 35) * 2;

                    // Ensure score is between 0-100
                    balanceScore = Math.max(0, Math.min(100, balanceScore));

                    // Animate the balance score
                    animateCounter(balancePercentEl, Math.round(balanceScore), '%');

                    // Update balance status
                    if (balanceStatusEl) {
                        if (balanceScore >= 90) {
                            balanceStatusEl.textContent = 'Excellent';
                            balanceStatusEl.className = 'text-xs font-medium px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100 rounded-full';
                        } else if (balanceScore >= 70) {
                            balanceStatusEl.textContent = 'Good';
                            balanceStatusEl.className = 'text-xs font-medium px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100 rounded-full';
                        } else if (balanceScore >= 50) {
                            balanceStatusEl.textContent = 'Fair';
                            balanceStatusEl.className = 'text-xs font-medium px-2 py-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100 rounded-full';
                        } else {
                            balanceStatusEl.textContent = 'Poor';
                            balanceStatusEl.className = 'text-xs font-medium px-2 py-1 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100 rounded-full';
                        }
                    }
                }
            }

            // Update nutrition status
            if (nutritionStatusEl) {
                if (totalCalories < 200) {
                    nutritionStatusEl.textContent = 'Very Low Calorie';
                    nutritionStatusEl.className = 'text-xs font-medium px-2 py-1 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100 rounded-full';
                } else if (totalCalories < 500) {
                    nutritionStatusEl.textContent = 'Low Calorie';
                    nutritionStatusEl.className = 'text-xs font-medium px-2 py-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100 rounded-full';
                } else if (totalCalories < 800) {
                    nutritionStatusEl.textContent = 'Moderate Calorie';
                    nutritionStatusEl.className = 'text-xs font-medium px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100 rounded-full';
                } else {
                    nutritionStatusEl.textContent = 'High Calorie';
                    nutritionStatusEl.className = 'text-xs font-medium px-2 py-1 bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-100 rounded-full';
                }
            }
        } else {
            // Reset to 0 if no macros
            proteinBarEl.style.width = '0%';
            carbsBarEl.style.width = '0%';
            fatBarEl.style.width = '0%';
            proteinPercentEl.textContent = '0%';
            carbsPercentEl.textContent = '0%';
            fatPercentEl.textContent = '0%';

            // Reset circular progress if elements exist
            if (proteinCircleEl && carbsCircleEl && fatCircleEl) {
                proteinCircleEl.setAttribute('stroke-dasharray', '0 251.2');
                carbsCircleEl.setAttribute('stroke-dasharray', '0 251.2');
                fatCircleEl.setAttribute('stroke-dasharray', '0 251.2');

                if (balancePercentEl) {
                    balancePercentEl.textContent = '0%';
                }

                if (balanceStatusEl) {
                    balanceStatusEl.textContent = 'Unbalanced';
                    balanceStatusEl.className = 'text-xs font-medium px-2 py-1 bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-full';
                }
            }

            // Reset nutrition status
            if (nutritionStatusEl) {
                nutritionStatusEl.textContent = 'Analyzing...';
                nutritionStatusEl.className = 'text-xs font-medium px-2 py-1 bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-full';
            }
        }
    }

    /**
     * Animate counter with smooth transition
     */
    function animateCounter(element, targetValue, suffix = '') {
        if (!element) return;

        // Get current value
        const currentValue = parseFloat(element.textContent) || 0;

        // Calculate the increment for each frame
        const increment = (targetValue - currentValue) / 20;

        // If the change is very small, just set the value directly
        if (Math.abs(targetValue - currentValue) < 0.1) {
            element.textContent = targetValue + suffix;
            return;
        }

        // Animate the counter
        let currentCount = currentValue;
        const animation = setInterval(() => {
            currentCount += increment;

            // Check if we've reached or passed the target
            if ((increment > 0 && currentCount >= targetValue) ||
                (increment < 0 && currentCount <= targetValue)) {
                clearInterval(animation);
                element.textContent = targetValue + suffix;
            } else {
                element.textContent = Math.round(currentCount * 10) / 10 + suffix;
            }
        }, 20);
    }

    /**
     * Load challenge template
     */
    function loadChallengeTemplate() {
        const templateId = recipeChallengeSelect.value;

        if (!templateId) {
            challengeDescription.classList.add('hidden');
            currentTemplate = null;
            return;
        }

        fetch(`/recipe-builder/template/${templateId}`)
            .then(response => response.json())
            .then(data => {
                currentTemplate = data;

                // Display challenge description
                challengeDescription.innerHTML = `
                    <h4 class="font-medium text-blue-800 dark:text-blue-300 mb-1">${data.name}</h4>
                    <p class="text-blue-700 dark:text-blue-200">${data.description}</p>
                    <div class="mt-2 space-y-1">
                        <div class="flex justify-between text-xs">
                            <span>Target Calories:</span>
                            <span>${data.target_calories_min} - ${data.target_calories_max}</span>
                        </div>
                        ${data.target_protein_min ? `
                        <div class="flex justify-between text-xs">
                            <span>Target Protein:</span>
                            <span>${data.target_protein_min}g - ${data.target_protein_max}g</span>
                        </div>
                        ` : ''}
                        ${data.target_carbs_min ? `
                        <div class="flex justify-between text-xs">
                            <span>Target Carbs:</span>
                            <span>${data.target_carbs_min}g - ${data.target_carbs_max}g</span>
                        </div>
                        ` : ''}
                        ${data.target_fat_min ? `
                        <div class="flex justify-between text-xs">
                            <span>Target Fat:</span>
                            <span>${data.target_fat_min}g - ${data.target_fat_max}g</span>
                        </div>
                        ` : ''}
                        ${data.required_categories ? `
                        <div class="flex justify-between text-xs">
                            <span>Required Categories:</span>
                            <span>${data.required_categories.join(', ')}</span>
                        </div>
                        ` : ''}
                        <div class="flex justify-between text-xs">
                            <span>Max Ingredients:</span>
                            <span>${data.max_ingredients}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span>Points Reward:</span>
                            <span>${data.points_reward}</span>
                        </div>
                    </div>
                `;
                challengeDescription.classList.remove('hidden');
            })
            .catch(error => console.error('Error loading template:', error));
    }

    /**
     * Save the recipe
     */
    function saveRecipe() {
        // Validate recipe
        if (!recipeNameInput.value) {
            alert('Please enter a recipe name');
            recipeNameInput.focus();
            return;
        }

        if (selectedIngredients.length === 0) {
            alert('Please add at least one ingredient to your recipe');
            return;
        }

        // Prepare recipe data
        const recipeData = {
            name: recipeNameInput.value,
            description: recipeDescriptionInput.value,
            template_id: recipeChallengeSelect.value || null,
            ingredients: selectedIngredients.map(ingredient => ({
                id: ingredient.id,
                quantity: ingredient.quantity
            }))
        };

        // Send to server
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
                showResultModal(data.recipe);
            } else {
                alert('Error saving recipe: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error saving recipe:', error);
            alert('Error saving recipe. Please try again.');
        });
    }

    /**
     * Show the result modal with enhanced visuals and animations
     */
    function showResultModal(recipe) {
        // Set title with animation
        resultTitle.textContent = 'Recipe Saved!';

        // Calculate macronutrient percentages for the pie chart
        const totalCaloriesFromMacros =
            (recipe.total_protein * 4) +
            (recipe.total_carbs * 4) +
            (recipe.total_fat * 9);

        const proteinPercent = totalCaloriesFromMacros > 0 ? Math.round((recipe.total_protein * 4) / totalCaloriesFromMacros * 100) : 0;
        const carbsPercent = totalCaloriesFromMacros > 0 ? Math.round((recipe.total_carbs * 4) / totalCaloriesFromMacros * 100) : 0;
        const fatPercent = totalCaloriesFromMacros > 0 ? Math.round((recipe.total_fat * 9) / totalCaloriesFromMacros * 100) : 0;

        // Calculate balance score
        let balanceScore = 100;
        if (totalCaloriesFromMacros > 0) {
            if (proteinPercent < 10) balanceScore -= (10 - proteinPercent) * 2;
            if (proteinPercent > 35) balanceScore -= (proteinPercent - 35) * 2;

            if (carbsPercent < 45) balanceScore -= (45 - carbsPercent) * 2;
            if (carbsPercent > 65) balanceScore -= (carbsPercent - 65) * 2;

            if (fatPercent < 20) balanceScore -= (20 - fatPercent) * 2;
            if (fatPercent > 35) balanceScore -= (fatPercent - 35) * 2;

            balanceScore = Math.max(0, Math.min(100, balanceScore));
        } else {
            balanceScore = 0;
        }

        // Determine balance status text and color
        let balanceStatus, balanceColor;
        if (balanceScore >= 90) {
            balanceStatus = 'Excellent';
            balanceColor = 'green';
        } else if (balanceScore >= 70) {
            balanceStatus = 'Good';
            balanceColor = 'blue';
        } else if (balanceScore >= 50) {
            balanceStatus = 'Fair';
            balanceColor = 'yellow';
        } else {
            balanceStatus = 'Poor';
            balanceColor = 'red';
        }

        // Create enhanced content with animations and visual elements
        let content = `
            <div class="mb-6 text-center">
                <h4 class="font-bold text-xl text-gray-900 dark:text-white mb-2">${recipe.name}</h4>
                ${recipe.description ? `<p class="text-gray-600 dark:text-gray-400">${recipe.description}</p>` : ''}
            </div>

            <!-- Score Card -->
            <div class="mb-6 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-lg p-4 border border-emerald-100 dark:border-emerald-800 text-center">
                <div class="flex justify-center items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    <h5 class="font-semibold text-lg text-emerald-800 dark:text-emerald-300">Recipe Score</h5>
                </div>
                <div class="text-4xl font-bold text-emerald-600 dark:text-emerald-400 mb-1" id="score-counter">0</div>
                <div class="text-sm text-emerald-700 dark:text-emerald-300">points earned</div>
            </div>

            <!-- Nutritional Information with Visual Elements -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <h5 class="font-semibold text-gray-800 dark:text-gray-200">Nutritional Information</h5>
                    <span class="px-2 py-1 bg-${balanceColor}-100 text-${balanceColor}-800 dark:bg-${balanceColor}-900 dark:text-${balanceColor}-200 rounded-full text-xs font-medium">${balanceStatus} Balance</span>
                </div>

                <!-- Macronutrient Distribution Pie Chart -->
                <div class="flex justify-center mb-4">
                    <div class="relative w-32 h-32">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <!-- Background circle -->
                            <circle class="text-gray-200 dark:text-gray-700" stroke-width="10" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" />

                            <!-- Protein arc -->
                            <circle class="text-blue-500 protein-arc" stroke-width="10" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50"
                                stroke-dasharray="0 251.2" stroke-dashoffset="0" />

                            <!-- Carbs arc -->
                            <circle class="text-green-500 carbs-arc" stroke-width="10" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50"
                                stroke-dasharray="0 251.2" stroke-dashoffset="0" />

                            <!-- Fat arc -->
                            <circle class="text-yellow-500 fat-arc" stroke-width="10" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50"
                                stroke-dasharray="0 251.2" stroke-dashoffset="0" />
                        </svg>

                        <!-- Center text -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Balance</span>
                            <span class="text-lg font-bold text-${balanceColor}-600 dark:text-${balanceColor}-400" id="balance-score-counter">0%</span>
                        </div>
                    </div>
                </div>

                <!-- Nutrition Details -->
                <div class="grid grid-cols-2 gap-3">
                    <!-- Calories -->
                    <div class="flex items-center p-2 bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                        </svg>
                        <div>
                            <div class="text-xs text-red-700 dark:text-red-300">Calories</div>
                            <div class="font-semibold text-red-900 dark:text-red-100" id="calories-counter">0</div>
                        </div>
                    </div>

                    <!-- Protein -->
                    <div class="flex items-center p-2 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <div>
                            <div class="text-xs text-blue-700 dark:text-blue-300">Protein</div>
                            <div class="font-semibold text-blue-900 dark:text-blue-100" id="protein-counter">0g</div>
                        </div>
                    </div>

                    <!-- Carbs -->
                    <div class="flex items-center p-2 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                        </svg>
                        <div>
                            <div class="text-xs text-green-700 dark:text-green-300">Carbs</div>
                            <div class="font-semibold text-green-900 dark:text-green-100" id="carbs-counter">0g</div>
                        </div>
                    </div>

                    <!-- Fat -->
                    <div class="flex items-center p-2 bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <div>
                            <div class="text-xs text-yellow-700 dark:text-yellow-300">Fat</div>
                            <div class="font-semibold text-yellow-900 dark:text-yellow-100" id="fat-counter">0g</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Challenge Results (if applicable) -->
            ${recipe.recipe_template_id ? `
            <div class="mb-6 p-3 bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-lg border border-purple-100 dark:border-purple-800">
                <div class="flex items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <h5 class="font-semibold text-purple-800 dark:text-purple-300">Challenge Results</h5>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-purple-700 dark:text-purple-300">Requirements Met:</span>
                    <span class="px-2 py-1 bg-${recipe.meets_requirements ? 'green' : 'red'}-100 text-${recipe.meets_requirements ? 'green' : 'red'}-800 dark:bg-${recipe.meets_requirements ? 'green' : 'red'}-900 dark:text-${recipe.meets_requirements ? 'green' : 'red'}-200 rounded-full text-xs font-medium">
                        ${recipe.meets_requirements ? 'Yes' : 'No'}
                    </span>
                </div>
            </div>
            ` : ''}

            <!-- Ingredients List with Icons -->
            ${recipe.ingredients && recipe.ingredients.length > 0 ? `
            <div>
                <div class="flex items-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h5 class="font-semibold text-gray-800 dark:text-gray-200">Ingredients</h5>
                </div>
                <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-3 border border-amber-100 dark:border-amber-800">
                    <ul class="space-y-2">
                        ${recipe.ingredients.map(ingredient => {
                            // Determine icon based on category
                            let iconSvg = '';
                            let iconColor = '';

                            switch(ingredient.category) {
                                case 'protein':
                                    iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />';
                                    iconColor = 'text-red-500';
                                    break;
                                case 'vegetable':
                                    iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />';
                                    iconColor = 'text-green-500';
                                    break;
                                case 'grain':
                                    iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />';
                                    iconColor = 'text-amber-500';
                                    break;
                                case 'dairy':
                                    iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />';
                                    iconColor = 'text-blue-500';
                                    break;
                                case 'fruit':
                                    iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />';
                                    iconColor = 'text-purple-500';
                                    break;
                                case 'fat':
                                    iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />';
                                    iconColor = 'text-yellow-500';
                                    break;
                                default:
                                    iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
                                    iconColor = 'text-gray-500';
                            }

                            return `
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ${iconColor} mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    ${iconSvg}
                                </svg>
                                <span class="text-sm">
                                    <span class="font-medium">${ingredient.quantity} ×</span> ${ingredient.name}
                                </span>
                            </li>`;
                        }).join('')}
                    </ul>
                </div>
            </div>
            ` : ''}
        `;

        resultContent.innerHTML = content;

        // Show the modal with animation
        recipeResultModal.classList.remove('hidden');

        // Animate the pie chart
        setTimeout(() => {
            const circumference = 2 * Math.PI * 40; // r=40

            // Calculate stroke dasharray values
            const proteinDashArray = (proteinPercent / 100) * circumference;
            const carbsDashArray = (carbsPercent / 100) * circumference;
            const fatDashArray = (fatPercent / 100) * circumference;

            // Get the SVG elements
            const proteinArc = document.querySelector('.protein-arc');
            const carbsArc = document.querySelector('.carbs-arc');
            const fatArc = document.querySelector('.fat-arc');

            if (proteinArc && carbsArc && fatArc) {
                // Set transition
                proteinArc.style.transition = 'stroke-dasharray 1.5s ease-in-out';
                carbsArc.style.transition = 'stroke-dasharray 1.5s ease-in-out, stroke-dashoffset 1.5s ease-in-out';
                fatArc.style.transition = 'stroke-dasharray 1.5s ease-in-out, stroke-dashoffset 1.5s ease-in-out';

                // Update the arcs
                proteinArc.setAttribute('stroke-dasharray', `${proteinDashArray} ${circumference - proteinDashArray}`);

                carbsArc.setAttribute('stroke-dasharray', `${carbsDashArray} ${circumference - carbsDashArray}`);
                carbsArc.setAttribute('stroke-dashoffset', -proteinDashArray);

                fatArc.setAttribute('stroke-dasharray', `${fatDashArray} ${circumference - fatDashArray}`);
                fatArc.setAttribute('stroke-dashoffset', -(proteinDashArray + carbsDashArray));
            }

            // Animate counters
            const scoreCounter = document.getElementById('score-counter');
            const balanceScoreCounter = document.getElementById('balance-score-counter');
            const caloriesCounter = document.getElementById('calories-counter');
            const proteinCounter = document.getElementById('protein-counter');
            const carbsCounter = document.getElementById('carbs-counter');
            const fatCounter = document.getElementById('fat-counter');

            if (scoreCounter) animateCounter(scoreCounter, recipe.score);
            if (balanceScoreCounter) animateCounter(balanceScoreCounter, balanceScore, '%');
            if (caloriesCounter) animateCounter(caloriesCounter, Math.round(recipe.total_calories));
            if (proteinCounter) animateCounter(proteinCounter, Math.round(recipe.total_protein * 10) / 10, 'g');
            if (carbsCounter) animateCounter(carbsCounter, Math.round(recipe.total_carbs * 10) / 10, 'g');
            if (fatCounter) animateCounter(fatCounter, Math.round(recipe.total_fat * 10) / 10, 'g');
        }, 300);

        // Refresh the page after a delay to show updated recipe history
        setTimeout(() => {
            window.location.reload();
        }, 5000); // Increased to 5 seconds to allow for animations
    }

    /**
     * Close the result modal
     */
    function closeResultModal() {
        recipeResultModal.classList.add('hidden');
    }

    /**
     * View a recipe
     */
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

                    <div class="mb-4">
                        <h5 class="font-medium">Nutritional Information</h5>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Calories:</span>
                                <span class="font-medium">${recipe.total_calories}</span>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Protein:</span>
                                <span class="font-medium">${recipe.total_protein}g</span>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Carbs:</span>
                                <span class="font-medium">${recipe.total_carbs}g</span>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Fat:</span>
                                <span class="font-medium">${recipe.total_fat}g</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="font-medium">Results</h5>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Score:</span>
                                <span class="font-medium">${recipe.score}</span>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Balanced:</span>
                                <span class="font-medium">${recipe.is_balanced ? 'Yes' : 'No'}</span>
                            </div>
                            ${recipe.recipe_template_id ? `
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Meets Requirements:</span>
                                <span class="font-medium">${recipe.meets_requirements ? 'Yes' : 'No'}</span>
                            </div>
                            ` : ''}
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
                alert('Error loading recipe. Please try again.');
            });
    }

    /**
     * Delete a recipe
     */
    function deleteRecipe(recipeId) {
        if (!confirm('Are you sure you want to delete this recipe?')) {
            return;
        }

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
                // Refresh the page to update recipe history
                window.location.reload();
            } else {
                alert('Error deleting recipe: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error deleting recipe:', error);
            alert('Error deleting recipe. Please try again.');
        });
    }
});
