<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class HumssSubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get the Education category
        $educationCategory = Category::firstOrCreate(
            ['slug' => 'education'],
            [
                'name' => 'Education',
                'description' => 'Educational subjects and learning materials',
            ]
        );

        // Define HUMSS subjects
        $humssSubjects = [
            [
                'name' => 'Creative Writing',
                'description' => 'Develop skills in creative writing across various genres and formats.',
                'tech_category' => 'humms',
                'tasks' => [
                    [
                        'name' => 'Narrative Writing',
                        'description' => 'Develop skills in crafting compelling narratives and storytelling.',
                        'instructions' => "Task: Demonstrate understanding of narrative writing techniques and create original narrative content.\n\nComplete the following:\n- Explain the key elements of narrative writing (plot, character, setting, point of view, theme)\n- Analyze different narrative structures and their effects\n- Identify and explain narrative techniques used in literature\n- Create an original short story demonstrating effective narrative techniques\n- Reflect on your creative choices and their intended impact\n\nNarrative Writing Assignment:\n1. Write a short story (800-1000 words) that includes the following elements:\n   a) A clear beginning, middle, and end structure\n   b) At least two well-developed characters\n   c) A specific setting that influences the story\n   d) Dialogue that reveals character and advances the plot\n   e) A central conflict and resolution\n   f) Effective use of at least two narrative techniques (e.g., foreshadowing, flashback, symbolism)\n\n2. Before your story, include a brief outline (200-300 words) explaining:\n   a) Your story's premise and theme\n   b) Character descriptions and motivations\n   c) Plot structure and key events\n   d) Setting details and significance\n   e) Point of view choice and rationale\n\n3. After your story, include a reflection (300-400 words) discussing:\n   a) Your creative process and inspiration\n   b) Specific narrative techniques you employed and why\n   c) Challenges you encountered and how you addressed them\n   d) How your story demonstrates effective narrative writing principles\n   e) What you would develop further if you expanded this story",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Poetry Composition',
                        'description' => 'Develop skills in writing poetry using various forms and techniques.',
                        'instructions' => "Task: Demonstrate understanding of poetic forms and techniques by creating original poetry.\n\nComplete the following:\n- Explain different poetic forms and their characteristics\n- Identify and analyze poetic devices and their effects\n- Create original poems in different forms\n- Apply poetic devices effectively in your writing\n- Reflect on your creative choices and their intended impact\n\nPoetry Composition Assignment:\n1. Create a portfolio of three original poems, each in a different form:\n   a) A sonnet (14 lines with a specific rhyme scheme)\n   b) A free verse poem (no fixed rhyme scheme or meter)\n   c) A form of your choice (haiku, villanelle, ballad, etc.)\n\n2. Each poem should:\n   a) Have a clear theme or subject\n   b) Demonstrate effective use of imagery\n   c) Include at least three different poetic devices (e.g., metaphor, alliteration, assonance, personification)\n   d) Demonstrate awareness of rhythm and sound\n   e) Evoke emotion or provoke thought\n\n3. For each poem, include a brief analysis (150-200 words) explaining:\n   a) The form you've chosen and why\n   b) The theme or subject and its significance\n   c) Specific poetic devices used and their intended effect\n   d) Your creative process and inspiration\n   e) How sound, rhythm, and structure contribute to the poem's meaning\n\n4. Include a final reflection (300-400 words) discussing:\n   a) Your experience writing in different poetic forms\n   b) Challenges you encountered and how you addressed them\n   c) How your understanding of poetry has developed\n   d) Which poetic devices you find most effective in your own writing\n   e) How you might continue to develop your poetry writing skills",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Creative Non-fiction',
                        'description' => 'Develop skills in writing creative non-fiction that combines factual content with literary techniques.',
                        'instructions' => "Task: Demonstrate understanding of creative non-fiction and create an original piece.\n\nComplete the following:\n- Explain what creative non-fiction is and its key characteristics\n- Identify different types of creative non-fiction\n- Analyze techniques used in effective creative non-fiction\n- Create an original creative non-fiction piece\n- Reflect on your creative choices and their intended impact\n\nCreative Non-fiction Assignment:\n1. Write a creative non-fiction piece (800-1000 words) in one of the following forms:\n   a) Personal essay\n   b) Memoir excerpt\n   c) Literary journalism\n   d) Travel writing\n   e) Nature writing\n\n2. Your piece should:\n   a) Be based on real events, people, or experiences\n   b) Incorporate literary techniques (e.g., scene-setting, characterization, dialogue)\n   c) Have a clear theme or purpose\n   d) Engage readers through vivid description and reflection\n   e) Maintain factual accuracy while using creative writing techniques\n\n3. Before your piece, include a brief introduction (200-300 words) explaining:\n   a) The type of creative non-fiction you've chosen\n   b) Your subject matter and why you selected it\n   c) The theme or message you hope to convey\n   d) The specific creative techniques you plan to employ\n   e) How you've ensured factual accuracy\n\n4. After your piece, include a reflection (300-400 words) discussing:\n   a) Your research process (if applicable)\n   b) Specific creative non-fiction techniques you employed and why\n   c) Challenges of balancing factual reporting with creative expression\n   d) Ethical considerations in representing real events or people\n   e) How your piece demonstrates effective creative non-fiction principles",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Social Sciences',
                'description' => 'Develop understanding of human society, behavior, and relationships through various social science disciplines.',
                'tech_category' => 'humms',
                'tasks' => [
                    [
                        'name' => 'Sociological Analysis',
                        'description' => 'Apply sociological perspectives to analyze social issues and phenomena.',
                        'instructions' => "Task: Demonstrate understanding of sociological perspectives and their application to social issues.\n\nComplete the following:\n- Explain major sociological perspectives (functionalism, conflict theory, symbolic interactionism)\n- Apply sociological concepts to analyze social phenomena\n- Evaluate social issues using sociological frameworks\n- Analyze social institutions and their functions\n- Develop evidence-based arguments about social topics\n\nSociological Analysis Assignment:\n1. Choose one of the following social issues to analyze from a sociological perspective:\n   a) Social inequality (economic, racial, gender, etc.)\n   b) Family structure and changes in modern society\n   c) Education systems and educational inequality\n   d) Media influence on social behavior and attitudes\n   e) Urbanization and community development\n\n2. Write an analytical essay (1000-1200 words) that includes:\n   a) An introduction that clearly identifies your chosen issue and its sociological significance\n   b) Analysis of the issue using at least two major sociological perspectives (functionalist, conflict, and/or symbolic interactionist)\n   c) Discussion of relevant sociological concepts and theories\n   d) Examination of empirical evidence and research findings related to the issue\n   e) Consideration of different viewpoints or interpretations\n   f) A conclusion that synthesizes your analysis and offers insights or potential solutions\n\n3. Your analysis should demonstrate:\n   a) Clear understanding of sociological perspectives and concepts\n   b) Critical thinking about social structures and processes\n   c) Ability to connect individual experiences to broader social patterns\n   d) Recognition of the complexity of social issues\n   e) Evidence-based reasoning and argumentation\n\n4. Include a bibliography with at least five credible sources (academic journals, books, reputable organizations) that informed your analysis.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Psychological Concepts',
                        'description' => 'Understand and apply psychological concepts to explain human behavior and mental processes.',
                        'instructions' => "Task: Demonstrate understanding of psychological concepts and their application to human behavior.\n\nComplete the following:\n- Explain key psychological perspectives and their approaches to understanding behavior\n- Identify major areas of psychological study and their focus\n- Apply psychological concepts to analyze human behavior and mental processes\n- Evaluate psychological research methods and findings\n- Relate psychological concepts to real-world situations\n\nPsychological Concepts Assignment:\n1. Choose one of the following psychological topics to explore:\n   a) Memory formation and retrieval\n   b) Personality development and individual differences\n   c) Stress, coping, and resilience\n   d) Social influence and group behavior\n   e) Psychological disorders and treatment approaches\n\n2. Write an analytical essay (1000-1200 words) that includes:\n   a) An introduction that clearly identifies your chosen topic and its significance\n   b) Explanation of relevant psychological theories and concepts\n   c) Discussion of key research findings related to the topic\n   d) Analysis of how different psychological perspectives approach this topic\n   e) Application of these concepts to a real-world example or case study\n   f) A conclusion that synthesizes your understanding and identifies implications\n\n3. Your analysis should demonstrate:\n   a) Accurate understanding of psychological concepts and theories\n   b) Awareness of the scientific basis of psychological knowledge\n   c) Critical evaluation of psychological research and evidence\n   d) Ability to apply psychological concepts to understand behavior\n   e) Recognition of ethical considerations in psychological research and practice\n\n4. Include a bibliography with at least five credible sources (academic journals, books, reputable organizations) that informed your analysis.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Anthropological Perspectives',
                        'description' => 'Understand and apply anthropological perspectives to analyze human cultures and societies.',
                        'instructions' => "Task: Demonstrate understanding of anthropological perspectives and their application to cultural analysis.\n\nComplete the following:\n- Explain the main subfields of anthropology and their focus\n- Identify key anthropological concepts and methods\n- Apply anthropological perspectives to analyze cultural practices\n- Compare and contrast different cultural systems\n- Evaluate the impact of cultural context on human behavior and beliefs\n\nAnthropological Perspectives Assignment:\n1. Choose one of the following cultural topics to analyze from an anthropological perspective:\n   a) Cultural rituals and ceremonies\n   b) Kinship systems and family structures\n   c) Religious beliefs and practices\n   d) Economic systems and exchange\n   e) Language and communication across cultures\n\n2. Write an analytical essay (1000-1200 words) that includes:\n   a) An introduction that clearly identifies your chosen topic and its anthropological significance\n   b) Explanation of relevant anthropological concepts and approaches\n   c) Comparative analysis of this cultural element across at least two different societies\n   d) Discussion of how this cultural element functions within social systems\n   e) Consideration of how cultural context shapes this element\n   f) A conclusion that synthesizes your analysis and offers cross-cultural insights\n\n3. Your analysis should demonstrate:\n   a) Understanding of anthropological perspectives and concepts\n   b) Cultural relativism and avoidance of ethnocentrism\n   c) Recognition of the complexity and diversity of human cultures\n   d) Ability to analyze cultural practices in their social context\n   e) Awareness of the relationship between cultural elements and broader social structures\n\n4. Include a bibliography with at least five credible sources (academic journals, books, ethnographies, reputable organizations) that informed your analysis.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Political Science',
                'description' => 'Develop understanding of political systems, governance, and power relationships in society.',
                'tech_category' => 'humms',
                'tasks' => [
                    [
                        'name' => 'Political Systems Analysis',
                        'description' => 'Analyze different political systems and their characteristics.',
                        'instructions' => "Task: Demonstrate understanding of political systems and their comparative features.\n\nComplete the following:\n- Identify and explain different types of political systems\n- Compare and contrast democratic and non-democratic systems\n- Analyze the institutional structures of government\n- Evaluate the strengths and weaknesses of different political arrangements\n- Apply political science concepts to real-world governance\n\nPolitical Systems Analysis Assignment:\n1. Choose two different political systems from the following categories to compare and contrast:\n   a) Presidential democracy (e.g., United States)\n   b) Parliamentary democracy (e.g., United Kingdom, Canada)\n   c) Semi-presidential system (e.g., France)\n   d) One-party state (e.g., China)\n   e) Constitutional monarchy (e.g., Japan, Sweden)\n   f) Federal system (e.g., Germany, India)\n   g) Unitary system (e.g., France, Japan)\n\n2. Write a comparative analysis essay (1000-1200 words) that includes:\n   a) An introduction that identifies the political systems you've chosen and why they're significant to compare\n   b) Overview of each system's key features and historical development\n   c) Systematic comparison of the following elements:\n      - Constitutional framework and legal foundations\n      - Executive, legislative, and judicial structures\n      - Electoral systems and representation\n      - Distribution of power (centralized vs. decentralized)\n      - Civil liberties and rights protections\n   d) Analysis of each system's strengths and weaknesses\n   e) Evaluation of how effectively each system addresses governance challenges\n   f) A conclusion that synthesizes your comparison and offers insights about political system design\n\n3. Your analysis should demonstrate:\n   a) Accurate understanding of political systems and concepts\n   b) Objective comparison without ideological bias\n   c) Recognition of the complexity of governance arrangements\n   d) Awareness of how historical and cultural contexts shape political systems\n   e) Evidence-based reasoning about institutional effectiveness\n\n4. Include a bibliography with at least five credible sources (academic journals, books, reputable organizations) that informed your analysis.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Political Ideologies',
                        'description' => 'Understand and analyze major political ideologies and their influence on governance.',
                        'instructions' => "Task: Demonstrate understanding of political ideologies and their impact on political systems.\n\nComplete the following:\n- Identify and explain major political ideologies\n- Analyze the historical development of political thought\n- Compare and contrast ideological perspectives on key political issues\n- Evaluate how ideologies shape policy approaches\n- Apply ideological analysis to contemporary political debates\n\nPolitical Ideologies Assignment:\n1. Choose three of the following political ideologies to analyze:\n   a) Liberalism\n   b) Conservatism\n   c) Socialism\n   d) Fascism\n   e) Anarchism\n   f) Feminism\n   g) Environmentalism\n   h) Nationalism\n\n2. Write an analytical essay (1000-1200 words) that includes:\n   a) An introduction that identifies the ideologies you've chosen and their significance\n   b) For each ideology:\n      - Historical origins and development\n      - Core principles and values\n      - Key thinkers and their contributions\n      - Variations within the ideological tradition\n   c) Comparative analysis of how each ideology approaches the following issues:\n      - Role and size of government\n      - Economic organization\n      - Individual rights and freedoms\n      - Social equality and justice\n   d) Evaluation of each ideology's influence on modern politics\n   e) A conclusion that synthesizes your analysis and reflects on ideological evolution\n\n3. Your analysis should demonstrate:\n   a) Accurate understanding of ideological principles and concepts\n   b) Objective analysis without personal bias\n   c) Recognition of the complexity and internal diversity within ideologies\n   d) Awareness of how historical context shapes ideological development\n   e) Critical thinking about the relationship between ideas and political practice\n\n4. Include a bibliography with at least five credible sources (academic journals, books, reputable organizations) that informed your analysis.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'International Relations',
                        'description' => 'Understand and analyze relationships between nations and global political dynamics.',
                        'instructions' => "Task: Demonstrate understanding of international relations theories and global political issues.\n\nComplete the following:\n- Explain major theories of international relations\n- Analyze the role of international organizations and institutions\n- Evaluate factors that influence relations between nations\n- Apply international relations concepts to global challenges\n- Assess the dynamics of power in the international system\n\nInternational Relations Assignment:\n1. Choose one of the following global issues to analyze from an international relations perspective:\n   a) International security and conflict\n   b) Global economic governance\n   c) Human rights and humanitarian intervention\n   d) Climate change and environmental cooperation\n   e) Migration and refugee crises\n   f) Nuclear proliferation and disarmament\n\n2. Write an analytical essay (1000-1200 words) that includes:\n   a) An introduction that identifies your chosen issue and its significance in international relations\n   b) Analysis of the issue using at least two major international relations theories (e.g., realism, liberalism, constructivism)\n   c) Examination of relevant international organizations and their role in addressing the issue\n   d) Case study of how this issue has affected relations between specific countries or regions\n   e) Evaluation of power dynamics and national interests related to the issue\n   f) Assessment of challenges to international cooperation on this issue\n   g) A conclusion that synthesizes your analysis and offers insights about future developments\n\n3. Your analysis should demonstrate:\n   a) Understanding of international relations theories and concepts\n   b) Awareness of the complexity of global governance\n   c) Recognition of how domestic politics influences international behavior\n   d) Ability to analyze multiple levels of interaction (bilateral, regional, global)\n   e) Critical thinking about power, sovereignty, and international norms\n\n4. Include a bibliography with at least five credible sources (academic journals, books, reputable organizations) that informed your analysis.",
                        'points_reward' => 100,
                    ],
                ]
            ],
        ];

        // Create challenges and tasks
        foreach ($humssSubjects as $subjectData) {
            $challenge = Challenge::create([
                'name' => $subjectData['name'],
                'description' => $subjectData['description'],
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(6),
                'points_reward' => 0, // Will be calculated from tasks
                'difficulty_level' => 'beginner',
                'is_active' => true,
                'required_level' => 1,
                'challenge_type' => 'education',
                'programming_language' => 'none',
                'tech_category' => $subjectData['tech_category'],
                'subject_type' => 'specialized',
                'category_id' => $educationCategory->id,
            ]);

            // Create tasks for this challenge
            $order = 1;
            foreach ($subjectData['tasks'] as $taskData) {
                Task::create([
                    'name' => $taskData['name'],
                    'title' => $taskData['name'],
                    'description' => $taskData['description'],
                    'instructions' => $taskData['instructions'],
                    'points_reward' => $taskData['points_reward'],
                    'submission_type' => 'text',
                    'evaluation_type' => 'manual',
                    'is_active' => true,
                    'challenge_id' => $challenge->id,
                    'order' => $order++,
                ]);
            }

            // Update challenge points reward based on tasks
            $challenge->updatePointsReward();
        }

        $this->command->info('HUMSS Subjects seeded successfully!');
    }
}
