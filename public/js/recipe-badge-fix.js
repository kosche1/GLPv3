// Script to fix the contrast of recipe badges
document.addEventListener('DOMContentLoaded', function() {
    // Function to update all recipe badges in the DOM
    function updateRecipeBadges() {
        // Find all badges in recipe cards
        const allBadges = document.querySelectorAll('.px-2.py-1.rounded-full.text-xs.font-medium');

        allBadges.forEach(badge => {
            // Check if this is a balanced or unbalanced badge
            if (badge.textContent.trim() === 'Balanced') {
                // Remove all color classes
                badge.classList.remove(
                    'bg-green-200', 'text-green-800', 'dark:bg-green-700', 'dark:text-white',
                    'bg-amber-200', 'text-amber-800', 'dark:bg-amber-700', 'dark:text-white',
                    'bg-gray-200', 'text-gray-800', 'dark:bg-gray-700', 'dark:text-gray-200'
                );

                // Add light blue classes for Balanced
                badge.classList.add('bg-blue-200', 'text-blue-800', 'dark:bg-blue-600', 'dark:text-white');

                // Update inline styles if needed
                if (badge.style.backgroundColor) {
                    badge.style.backgroundColor = 'rgb(191, 219, 254)'; // blue-200 equivalent
                    badge.style.color = 'rgb(30, 64, 175)'; // blue-800 equivalent
                }
            }
            else if (badge.textContent.trim() === 'Unbalanced') {
                // Remove all color classes
                badge.classList.remove(
                    'bg-green-200', 'text-green-800', 'dark:bg-green-700', 'dark:text-white',
                    'bg-amber-200', 'text-amber-800', 'dark:bg-amber-700', 'dark:text-white',
                    'bg-gray-200', 'text-gray-800', 'dark:bg-gray-700', 'dark:text-gray-200'
                );

                // Add red classes for Unbalanced
                badge.classList.add('bg-red-200', 'text-red-800', 'dark:bg-red-600', 'dark:text-white');

                // Update inline styles if needed
                if (badge.style.backgroundColor) {
                    badge.style.backgroundColor = 'rgb(254, 202, 202)'; // red-200 equivalent
                    badge.style.color = 'rgb(153, 27, 27)'; // red-800 equivalent
                }
            }
        });

        // Also update the balance status badges in the nutrition section
        const balanceStatusBadges = document.querySelectorAll('#balance-status, #nutrition-status');
        balanceStatusBadges.forEach(badge => {
            if (badge.textContent.includes('Balanced')) {
                badge.classList.remove('bg-gray-200', 'text-gray-800', 'dark:bg-gray-700', 'dark:text-gray-200');
                badge.classList.add('bg-blue-200', 'text-blue-800', 'dark:bg-blue-600', 'dark:text-white');
            }
            else if (badge.textContent.includes('Unbalanced')) {
                badge.classList.remove('bg-gray-200', 'text-gray-800', 'dark:bg-gray-700', 'dark:text-gray-200');
                badge.classList.add('bg-red-200', 'text-red-800', 'dark:bg-red-600', 'dark:text-white');
            }
        });
    }

    // Run initially
    updateRecipeBadges();

    // Set up a mutation observer to watch for dynamically added badges
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                updateRecipeBadges();
            }
        });
    });

    // Start observing the document body for changes
    observer.observe(document.body, { childList: true, subtree: true });

    // Also run when recipes are loaded or updated
    const recipeList = document.getElementById('recipe-list');
    if (recipeList) {
        observer.observe(recipeList, { childList: true, subtree: true });
    }
});
