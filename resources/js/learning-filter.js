document.addEventListener('DOMContentLoaded', function() {
    const techCategorySelect = document.getElementById('tech_category');
    const programmingLanguageSelect = document.getElementById('programming_language');
    const challengeGrid = document.getElementById('challenge-grid');

    function filterChallenges() {
        const selectedCategory = techCategorySelect.value.toLowerCase();
        const selectedLanguage = programmingLanguageSelect.value.toLowerCase();
        const challenges = challengeGrid.getElementsByClassName('flex');

        Array.from(challenges).forEach(challenge => {
            const category = challenge.dataset.category;
            const language = challenge.dataset.language;
            const shouldShow = (!selectedCategory || category === selectedCategory) &&
                             (!selectedLanguage || language === selectedLanguage);

            challenge.style.opacity = shouldShow ? '1' : '0';
            challenge.style.transform = shouldShow ? 'scale(1)' : 'scale(0.95)';
            
            setTimeout(() => {
                challenge.style.display = shouldShow ? 'flex' : 'none';
            }, shouldShow ? 0 : 300);
        });
    }

    techCategorySelect.addEventListener('change', filterChallenges);
    programmingLanguageSelect.addEventListener('change', filterChallenges);
}));