document.addEventListener('DOMContentLoaded', function() {
    const techCategorySelect = document.getElementById('tech_category');
    const programmingLanguageSelect = document.getElementById('programming_language');
    const challengeGrid = document.getElementById('challenge-grid');

    function filterChallenges() {
        const selectedCategory = techCategorySelect.value.toLowerCase();
        const selectedLanguage = programmingLanguageSelect.value.toLowerCase();
        const challengeCards = challengeGrid.children;

        Array.from(challengeCards).forEach(card => {
            const category = card.getAttribute('data-category').toLowerCase();
            const language = card.getAttribute('data-language').toLowerCase();
            
            const categoryMatch = !selectedCategory || category === selectedCategory;
            const languageMatch = !selectedLanguage || language === selectedLanguage;

            card.style.display = (categoryMatch && languageMatch) ? 'flex' : 'none';
        });
    }

    techCategorySelect.addEventListener('change', filterChallenges);
    programmingLanguageSelect.addEventListener('change', filterChallenges);
}