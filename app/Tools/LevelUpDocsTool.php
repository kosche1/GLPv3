<?php

namespace App\Tools;

use Prism\Prism\Tool;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
// use Prism\Prism\Contracts\Tool;
use Illuminate\Support\Facades\File;
use LevelUp\Experience\Facades\Level;
use LevelUp\Experience\Models\Experience;
use LevelUp\Experience\Facades\Leaderboard;

class LevelUpDocsTool extends Tool
{
    /**
     * The path to the Level-up.md file
     */
    protected string $docsPath = 'Docs/Level-up.md';

    /**
     * The content of the Level-up.md file
     */
    protected ?string $docsContent = null;

    /**
     * The sections of the Level-up.md file
     */
    protected array $sections = [];

    /**
     * Get the name of the tool
     */
    public function name(): string
    {
        return 'level_up_docs';
    }

    /**
     * Get the description of the tool
     */
    public function description(): string
    {
        return 'Fetch information from the Level-up package documentation and retrieve user-specific gamification data. ' .
            'Use this tool to answer questions about the Level-up package (installation, configuration, usage, features) ' .
            'and to get information about the current user\'s level, experience points, and the leaderboard.';
    }

    /**
     * Get the parameters for the tool
     */
    public function parameters(): array
    {
        return [
            'query_type' => [
                'type' => 'string',
                'description' => 'The type of query to perform. Options: "get_section", "search", "get_all_sections", "get_user_level", "get_user_experience", "get_leaderboard"',
                'enum' => ['get_section', 'search', 'get_all_sections', 'get_user_level', 'get_user_experience', 'get_leaderboard'],
            ],
            'section' => [
                'type' => 'string',
                'description' => 'The section to fetch. Required when query_type is "get_section". Options include: "Installation", "Usage", "Experience Points", "Levelling", "Achievements", "Leaderboard", "Auditing", "Streaks", etc.',
                'required' => false,
            ],
            'search_term' => [
                'type' => 'string',
                'description' => 'The term to search for in the documentation. Required when query_type is "search".',
                'required' => false,
            ],
            'limit' => [
                'type' => 'integer',
                'description' => 'The number of results to return for leaderboard queries. Default is 10.',
                'required' => false,
            ],
            'user_id' => [
                'type' => 'integer',
                'description' => 'The ID of the user to get information for. If not provided, the currently authenticated user will be used.',
                'required' => false,
            ],
        ];
    }

    /**
     * Execute the tool
     */
    public function execute(array $parameters): string
    {
        // For documentation-related queries, load and parse the docs
        if (in_array($parameters['query_type'], ['get_section', 'search', 'get_all_sections'])) {
            // Load the documentation content if not already loaded
            $this->loadDocsContent();

            // Parse the documentation into sections if not already parsed
            if (empty($this->sections)) {
                $this->parseDocumentSections();
            }
        }

        // Handle the query based on the query_type
        return match ($parameters['query_type']) {
            'get_section' => $this->getSection($parameters['section'] ?? ''),
            'search' => $this->searchDocs($parameters['search_term'] ?? ''),
            'get_all_sections' => $this->getAllSections(),
            'get_user_level' => $this->getUserLevel($parameters['user_id'] ?? null),
            'get_user_experience' => $this->getUserExperience($parameters['user_id'] ?? null),
            'get_leaderboard' => $this->getLeaderboard($parameters['limit'] ?? 10),
            default => 'Invalid query type. Please use one of the supported query types.',
        };
    }

    /**
     * Load the documentation content
     */
    protected function loadDocsContent(): void
    {
        if ($this->docsContent === null) {
            $path = base_path($this->docsPath);

            if (File::exists($path)) {
                $this->docsContent = File::get($path);
            } else {
                $this->docsContent = 'Documentation file not found.';
            }
        }
    }

    /**
     * Parse the documentation into sections
     */
    protected function parseDocumentSections(): void
    {
        // Split the content by main headers (# Header)
        $mainSections = preg_split('/^# /m', $this->docsContent);

        // The first element is the introduction before any headers
        $introduction = array_shift($mainSections);
        $this->sections['Introduction'] = trim($introduction);

        // Process each main section
        foreach ($mainSections as $section) {
            // Get the section title (first line)
            $lines = explode("\n", $section, 2);
            $title = trim($lines[0]);
            $content = $lines[1] ?? '';

            // Store the section
            $this->sections[$title] = trim($content);

            // Parse subsections (## Subsection)
            $subsections = preg_split('/^## /m', $content);

            // Skip the first element as it's content before any subsection
            array_shift($subsections);

            foreach ($subsections as $subsection) {
                $subLines = explode("\n", $subsection, 2);
                $subTitle = trim($subLines[0]);
                $subContent = $subLines[1] ?? '';

                // Store the subsection
                $this->sections["$title - $subTitle"] = trim($subContent);
            }
        }
    }

    /**
     * Get a specific section from the documentation
     */
    protected function getSection(string $sectionName): string
    {
        // If no section name provided, return all section names
        if (empty($sectionName)) {
            return "Please specify a section name. Available sections: " . implode(', ', array_keys($this->sections));
        }

        // Try to find an exact match
        if (isset($this->sections[$sectionName])) {
            return "## $sectionName\n\n" . $this->sections[$sectionName];
        }

        // Try to find a case-insensitive match
        foreach ($this->sections as $title => $content) {
            if (Str::lower($title) === Str::lower($sectionName)) {
                return "## $title\n\n" . $content;
            }
        }

        // Try to find a partial match
        $matchingSections = [];
        foreach ($this->sections as $title => $content) {
            if (Str::contains(Str::lower($title), Str::lower($sectionName))) {
                $matchingSections[$title] = $content;
            }
        }

        if (count($matchingSections) === 1) {
            $title = array_key_first($matchingSections);
            return "## $title\n\n" . $matchingSections[$title];
        } elseif (count($matchingSections) > 1) {
            return "Multiple sections found matching '$sectionName'. Please be more specific. Matching sections: " .
                implode(', ', array_keys($matchingSections));
        }

        return "Section '$sectionName' not found. Available sections: " . implode(', ', array_keys($this->sections));
    }

    /**
     * Search the documentation for a term
     */
    protected function searchDocs(string $searchTerm): string
    {
        if (empty($searchTerm)) {
            return "Please provide a search term.";
        }

        $results = [];
        $searchTerm = Str::lower($searchTerm);

        foreach ($this->sections as $title => $content) {
            if (Str::contains(Str::lower($content), $searchTerm) || Str::contains(Str::lower($title), $searchTerm)) {
                // Extract a snippet of content around the search term
                $position = stripos($content, $searchTerm);
                if ($position !== false) {
                    $start = max(0, $position - 100);
                    $length = min(strlen($content) - $start, 300);
                    $snippet = substr($content, $start, $length);

                    // Add ellipsis if we're not at the beginning or end
                    if ($start > 0) {
                        $snippet = "..." . $snippet;
                    }
                    if ($start + $length < strlen($content)) {
                        $snippet .= "...";
                    }

                    $results[] = "### $title\n\n$snippet";
                } else {
                    // If the term is only in the title
                    $results[] = "### $title\n\nThis section contains information related to your search.";
                }
            }
        }

        if (empty($results)) {
            return "No results found for '$searchTerm'.";
        }

        return "## Search Results for '$searchTerm'\n\n" . implode("\n\n", $results);
    }

    /**
     * Get all section names
     */
    protected function getAllSections(): string
    {
        $mainSections = [];
        $subSections = [];

        foreach (array_keys($this->sections) as $title) {
            if (!Str::contains($title, ' - ')) {
                $mainSections[] = $title;
            } else {
                $subSections[] = $title;
            }
        }

        return "## Available Sections\n\n### Main Sections\n" .
            implode("\n", array_map(fn($s) => "- $s", $mainSections)) .
            "\n\n### Sub-Sections\n" .
            implode("\n", array_map(fn($s) => "- $s", $subSections));
    }

    /**
     * Get the user's current level
     *
     * @param int|null $userId The user ID (null for current user)
     * @return string Formatted information about the user's level
     */
    protected function getUserLevel(?int $userId = null): string
    {
        try {
            // Get the user
            $user = $userId ? \App\Models\User::find($userId) : Auth::user();

            if (!$user) {
                return "User not found.";
            }

            // Check if the user has the GiveExperience trait
            if (!method_exists($user, 'getLevel')) {
                return "The user model does not have level functionality. Make sure the GiveExperience trait is added to your User model.";
            }

            // Get the user's level
            $level = $user->getLevel();
            $nextLevelAt = $user->nextLevelAt();
            $points = $user->getPoints();

            $response = "## User Level Information\n\n";
            $response .= "- **User**: {$user->name}\n";
            $response .= "- **Current Level**: {$level}\n";
            $response .= "- **Current XP**: {$points} points\n";

            if ($nextLevelAt !== null) {
                $pointsNeeded = $nextLevelAt - $points;
                $response .= "- **Next Level At**: {$nextLevelAt} points\n";
                $response .= "- **Points Needed for Next Level**: {$pointsNeeded} points\n";
            } else {
                $response .= "- **Max Level Reached**: Yes\n";
            }

            return $response;

        } catch (\Exception $e) {
            return "Error retrieving user level information: {$e->getMessage()}";
        }
    }

    /**
     * Get the user's experience details
     *
     * @param int|null $userId The user ID (null for current user)
     * @return string Formatted information about the user's experience
     */
    protected function getUserExperience(?int $userId = null): string
    {
        try {
            // Get the user
            $user = $userId ? \App\Models\User::find($userId) : Auth::user();

            if (!$user) {
                return "User not found.";
            }

            // Check if the user has the GiveExperience trait
            if (!method_exists($user, 'getPoints')) {
                return "The user model does not have experience functionality. Make sure the GiveExperience trait is added to your User model.";
            }

            // Get the user's experience
            $points = $user->getPoints();
            $level = $user->getLevel();

            // Get experience history if auditing is enabled
            $hasAuditHistory = method_exists($user, 'experienceHistory');

            $response = "## User Experience Information\n\n";
            $response .= "- **User**: {$user->name}\n";
            $response .= "- **Total XP**: {$points} points\n";
            $response .= "- **Current Level**: {$level}\n";

            // Add experience history if available
            if ($hasAuditHistory) {
                $history = $user->experienceHistory()->latest()->take(5)->get();

                if ($history->count() > 0) {
                    $response .= "\n### Recent Experience History\n\n";

                    foreach ($history as $entry) {
                        $date = $entry->created_at->format('Y-m-d H:i');
                        $response .= "- **{$date}**: {$entry->points} points ({$entry->type})";

                        if ($entry->reason) {
                            $response .= " - {$entry->reason}";
                        }

                        $response .= "\n";
                    }
                } else {
                    $response .= "\n*No experience history available.*\n";
                }
            }

            return $response;

        } catch (\Exception $e) {
            return "Error retrieving user experience information: {$e->getMessage()}";
        }
    }

    /**
     * Get the leaderboard
     *
     * @param int $limit The number of users to include
     * @return string Formatted leaderboard information
     */
    protected function getLeaderboard(int $limit = 10): string
    {
        try {
            // Generate the leaderboard
            $leaderboard = Leaderboard::generate()->take($limit);

            if ($leaderboard->isEmpty()) {
                return "No leaderboard data available.";
            }

            $response = "## Experience Leaderboard\n\n";
            $response .= "| Rank | User | Level | XP |\n";
            $response .= "|------|------|-------|-----|\n";

            $rank = 1;
            foreach ($leaderboard as $entry) {
                $userName = $entry->name ?? 'Unknown';
                $level = $entry->level->level ?? 'N/A';
                $points = $entry->experience->points ?? 0;

                $response .= "| {$rank} | {$userName} | {$level} | {$points} |\n";
                $rank++;
            }

            // Add current user's rank if authenticated
            if (Auth::check()) {
                $currentUser = Auth::user();
                $allUsers = Leaderboard::generate();

                $userRank = 0;
                foreach ($allUsers as $index => $entry) {
                    if ($entry->id === $currentUser->id) {
                        $userRank = $index + 1;
                        break;
                    }
                }

                if ($userRank > 0) {
                    $response .= "\n### Your Ranking\n\n";
                    $response .= "You are currently ranked **#{$userRank}** on the leaderboard.\n";
                }
            }

            return $response;

        } catch (\Exception $e) {
            return "Error retrieving leaderboard: {$e->getMessage()}";
        }
    }
}
