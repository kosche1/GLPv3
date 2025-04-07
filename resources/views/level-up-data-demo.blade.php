<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level-up Data Assistant</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Level-up Gamification Assistant</h1>
        
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Ask About Your Level & Experience</h2>
            <p class="text-gray-600 mb-4">
                This demo uses the LevelUpDataTool to fetch information about your current level, experience points, and leaderboard rankings.
                Try asking questions about your progress in the gamification system.
            </p>
            
            <div class="mb-4">
                <livewire:ai-widget />
            </div>
            
            <div class="mt-8 border-t pt-4">
                <h3 class="text-lg font-semibold mb-2">Example Questions:</h3>
                
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    <li>What level am I currently at?</li>
                    <li>How many experience points do I have?</li>
                    <li>How many more points do I need to level up?</li>
                    <li>Show me my recent experience history.</li>
                    <li>What's my position on the leaderboard?</li>
                    <li>Show me the top 10 users on the leaderboard.</li>
                    <li>What's my current XP?</li>
                    <li>Am I at the maximum level?</li>
                </ul>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">About the Tool</h2>
            <p class="text-gray-600 mb-4">
                The LevelUpDataTool is a custom tool that implements the Prism\Prism\Contracts\Tool interface.
                It integrates with the Level-up package to provide user-specific gamification data.
            </p>
            
            <h3 class="text-lg font-semibold mb-2">Tool Features:</h3>
            <ul class="list-disc pl-5 space-y-2 text-gray-700">
                <li><strong>get_user_level</strong> - Retrieves the current user's level information</li>
                <li><strong>get_user_experience</strong> - Retrieves the current user's experience points and history</li>
                <li><strong>get_leaderboard</strong> - Retrieves the experience leaderboard</li>
            </ul>
            
            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <h3 class="text-lg font-semibold mb-2 text-blue-800">Integration with Level-up Package</h3>
                <p class="text-blue-700 mb-2">
                    This tool demonstrates how to integrate AI with your application's gamification features.
                    Users can ask natural language questions about their progress and get personalized responses.
                </p>
                <p class="text-blue-700">
                    The User model uses the <code>GiveExperience</code> trait from the Level-up package to track experience points and levels.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
