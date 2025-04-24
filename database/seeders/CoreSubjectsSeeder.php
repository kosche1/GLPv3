<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CoreSubjectsSeeder extends Seeder
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

        // Define core subjects
        $coreSubjects = [
            [
                'name' => 'Oral Communication',
                'description' => 'Develop effective speaking and listening skills for various contexts and audiences.',
                'tasks' => [
                    [
                        'name' => 'Speech Analysis',
                        'description' => 'Analyze a famous speech and identify rhetorical devices used.',
                        'instructions' => "Select a famous speech from history, analyze its structure, rhetorical devices, and effectiveness. Submit a 500-word analysis.\n\nQuestions to address:\n1. What rhetorical devices (e.g., repetition, metaphor, ethos/pathos/logos) does the speaker use?\n2. How does the speech's structure contribute to its effectiveness?\n3. What specific language choices make this speech powerful?\n4. How does the historical context influence the speech's impact?",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Persuasive Presentation',
                        'description' => 'Create and deliver a persuasive presentation on a topic of your choice.',
                        'instructions' => "Prepare a 5-minute persuasive presentation on a topic you care about. Record yourself delivering it and submit the video along with your speaking notes.\n\nRequirements:\n1. Choose a topic that requires a clear stance or call to action\n2. Include at least three well-researched supporting points\n3. Address at least one counterargument\n4. Use appropriate visual aids\n5. Incorporate persuasive techniques (emotional appeal, logical reasoning, credibility)\n\nQuestions to answer in your submission:\n1. Why did you choose this topic?\n2. What persuasive techniques did you use and why?\n3. How did you structure your presentation to maximize impact?\n4. What was the most challenging part of creating this presentation?",
                        'points_reward' => 150,
                    ],
                    [
                        'name' => 'Active Listening Exercise',
                        'description' => 'Practice active listening skills through a structured exercise.',
                        'instructions' => "Watch a 10-minute TED talk, take notes, and then summarize the main points, supporting evidence, and your personal reflections.\n\nSpecific Tasks:\n1. Choose from one of these TED talks:\n   - 'The Power of Vulnerability' by Brené Brown\n   - 'How Great Leaders Inspire Action' by Simon Sinek\n   - 'The Danger of a Single Story' by Chimamanda Ngozi Adichie\n\n2. While watching, take detailed notes on:\n   - Main thesis/argument\n   - Key supporting points\n   - Examples or evidence provided\n   - Speaker's delivery techniques\n\n3. Answer these questions in your submission:\n   - What were the 3-5 most important points made in the talk?\n   - What evidence did the speaker use to support their main argument?\n   - What aspects of the speaker's delivery were most effective?\n   - How did this talk change or reinforce your thinking on the topic?\n   - What questions would you ask the speaker if you had the opportunity?",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Reading and Writing',
                'description' => 'Enhance reading comprehension and develop effective writing skills across various genres and formats.',
                'tasks' => [
                    [
                        'name' => 'Literary Analysis',
                        'description' => 'Analyze a short story or poem for themes, literary devices, and meaning.',
                        'instructions' => "Choose a short story or poem from the provided list. Write a 750-word analysis examining the themes, literary devices, and overall meaning of the work.\n\nText Options:\n- 'The Yellow Wallpaper' by Charlotte Perkins Gilman\n- 'Hills Like White Elephants' by Ernest Hemingway\n- 'The Road Not Taken' by Robert Frost\n- 'Do Not Go Gentle Into That Good Night' by Dylan Thomas\n- 'The Tell-Tale Heart' by Edgar Allan Poe\n\nYour analysis should address the following questions:\n1. What is the central theme or message of the work?\n2. How do specific literary devices (metaphor, symbolism, imagery, etc.) contribute to this theme?\n3. How does the author's use of language and structure enhance the meaning?\n4. What historical or cultural context influences the work's significance?\n5. How does this work connect to broader human experiences or universal themes?\n\nInclude specific textual evidence (quotes) to support your analysis.",
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Argumentative Essay',
                        'description' => 'Write a well-structured argumentative essay on a contemporary issue.',
                        'instructions' => "Select a contemporary issue and write a 1000-word argumentative essay. Include a clear thesis, supporting evidence, counterarguments, and a conclusion.\n\nSuggested Topics:\n- Should social media platforms be regulated to combat misinformation?\n- Is universal basic income a viable solution to economic inequality?\n- Should standardized testing be eliminated from education systems?\n\nYour essay must include:\n1. A clear and specific thesis statement\n2. At least three well-developed supporting arguments with evidence\n3. Acknowledgment and refutation of at least one counterargument\n4. A conclusion that reinforces your thesis and offers broader implications\n\nQuestions to consider:\n- What makes this issue significant in today's society?\n- What are the strongest arguments for your position?\n- What evidence best supports your claims?\n- What are the most compelling counterarguments, and how can you address them?",
                        'points_reward' => 150,
                    ],
                    [
                        'name' => 'Reading Comprehension',
                        'description' => 'Demonstrate understanding of complex texts through analysis and reflection.',
                        'instructions' => "Read the provided academic article and answer the comprehension questions. Then write a 300-word reflection on how the information relates to your own experiences.\n\nArticle: \"The Impact of Digital Technology on Learning\" (provided as PDF)\n\nComprehension Questions:\n1. What are the three main ways digital technology impacts learning according to the article?\n2. Summarize the evidence presented for both positive and negative effects of technology on learning.\n3. What recommendations does the author make for effective technology integration in education?\n4. How does the article address different learning styles in relation to technology use?\n5. What limitations does the author acknowledge in the current research?\n\nReflection Prompts:\n- How does your personal experience with technology in learning compare to the findings in the article?\n- Which of the author's points do you find most relevant to your educational experience?\n- How might the conclusions of this article influence your approach to learning in the future?",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Komunikasyon at Pananaliksik sa Wika at Kulturang Pilipino',
                'description' => 'Develop proficiency in Filipino language communication and research skills with focus on Filipino culture and linguistics.',
                'tasks' => [
                    [
                        'name' => 'Pagsusuri ng Teksto',
                        'description' => 'Analyze Filipino texts for cultural and linguistic elements.',
                        'instructions' => "Pumili ng isang maikling kwento sa Filipino at suriin ang mga kultural na elemento, wika, at kahalagahan nito. Isumite ang 500-word na pagsusuri.\n\nMga Maikling Kwento (Piliin isa):\n- \"Ang Kalupi\" ni Liwayway A. Arceo\n- \"Pluma\" ni Alejandro G. Abadilla\n- \"Sandaang Damit\" ni Fanny Garcia\n\nMga Tanong na Dapat Sagutin:\n1. Ano ang pangunahing tema o mensahe ng kwento?\n2. Paano ipinakita ang mga kultural na elemento ng lipunang Pilipino sa kwento?\n3. Anong mga katangian ng wikang Filipino ang makikita sa teksto?\n4. Paano ginamit ng may-akda ang mga talinghaga o simbolismo?\n5. Ano ang kahalagahan ng kwentong ito sa kasalukuyang panahon?",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Pananaliksik sa Kulturang Pilipino',
                        'description' => 'Conduct research on an aspect of Filipino culture.',
                        'instructions' => 'Magsagawa ng pananaliksik tungkol sa isang aspeto ng kulturang Pilipino (hal. tradisyon, pagkain, sining). Isumite ang 800-word na papel na may mga sanggunian.',
                        'points_reward' => 150,
                    ],
                    [
                        'name' => 'Pagsasalin ng Teksto',
                        'description' => 'Translate texts between Filipino and English while preserving meaning and cultural context.',
                        'instructions' => 'Isalin ang ibinigay na teksto mula sa Ingles patungong Filipino, o mula sa Filipino patungong Ingles. Tiyaking mapapanatili ang kahulugan at kontekstong kultural.',
                        'points_reward' => 120,
                    ],
                ]
            ],
            [
                'name' => 'Pagbasa at Pagsusuri ng Iba\'t Ibang Teksto Tungo sa Pananaliksik',
                'description' => 'Develop skills in reading and analyzing various Filipino texts for research purposes.',
                'tasks' => [
                    [
                        'name' => 'Pagsusuri ng Akademikong Artikulo',
                        'description' => 'Analyze academic articles written in Filipino.',
                        'instructions' => 'Basahin at suriin ang ibinigay na akademikong artikulo. Tukuyin ang pangunahing paksa, metodolohiya, at konklusyon. Isumite ang 500-word na pagsusuri.',
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Pagbuo ng Pananaliksik na Balangkas',
                        'description' => 'Develop a research framework on a Filipino cultural or linguistic topic.',
                        'instructions' => 'Bumuo ng balangkas para sa isang pananaliksik tungkol sa wika o kulturang Pilipino. Isama ang research question, methodology, at potential sources.',
                        'points_reward' => 150,
                    ],
                    [
                        'name' => 'Pagsusuri ng Primaryang Dokumento',
                        'description' => 'Analyze primary documents in Filipino for historical and cultural context.',
                        'instructions' => 'Suriin ang ibinigay na primaryang dokumento (hal. liham, journal, pahayagan) at tukuyin ang kahalagahan nito sa kasaysayan at kultura ng Pilipinas.',
                        'points_reward' => 130,
                    ],
                ]
            ],
            [
                'name' => '21st Century Literature from the Philippines and the World',
                'description' => 'Explore contemporary literature from the Philippines and around the world, analyzing themes, styles, and cultural contexts.',
                'tasks' => [
                    [
                        'name' => 'Contemporary Filipino Literature Analysis',
                        'description' => 'Analyze a contemporary Filipino literary work.',
                        'instructions' => 'Select a 21st century Filipino novel, short story, or poem. Write a 750-word analysis of its themes, style, and cultural significance.',
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Comparative Literature Study',
                        'description' => 'Compare Filipino literature with works from another culture.',
                        'instructions' => 'Choose one Filipino literary work and one from another culture published in the 21st century. Write a 1000-word comparative analysis examining themes, styles, and cultural contexts.',
                        'points_reward' => 150,
                    ],
                    [
                        'name' => 'Digital Literature Exploration',
                        'description' => 'Explore and analyze digital forms of contemporary literature.',
                        'instructions' => 'Research and analyze a form of digital literature (e.g., interactive fiction, social media poetry, webcomics). Submit a 600-word analysis of how digital media affects literary expression.',
                        'points_reward' => 110,
                    ],
                ]
            ],
            [
                'name' => 'Contemporary Philippine Arts from the Regions',
                'description' => 'Study and appreciate diverse contemporary art forms from different regions of the Philippines.',
                'tasks' => [
                    [
                        'name' => 'Regional Art Form Analysis',
                        'description' => 'Research and analyze a contemporary art form from a specific Philippine region.',
                        'instructions' => 'Select a contemporary art form from a specific Philippine region. Research its history, cultural significance, and current practice. Submit a 700-word analysis with visual documentation.',
                        'points_reward' => 130,
                    ],
                    [
                        'name' => 'Artist Profile Creation',
                        'description' => 'Create a profile of a contemporary Filipino artist from a specific region.',
                        'instructions' => 'Research and create a profile of a contemporary Filipino artist from a specific region. Include biographical information, artistic style, influences, and significance of their work.',
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Art Exhibition Proposal',
                        'description' => 'Develop a proposal for an exhibition of contemporary Philippine regional arts.',
                        'instructions' => 'Create a proposal for an exhibition featuring contemporary arts from a Philippine region. Include theme, artworks to be featured, layout, and educational components.',
                        'points_reward' => 150,
                    ],
                ]
            ],
            [
                'name' => 'Media and Information Literacy',
                'description' => 'Develop critical thinking skills for analyzing and creating media content in the digital age.',
                'tasks' => [
                    [
                        'name' => 'Media Analysis',
                        'description' => 'Analyze how different media sources cover the same news event.',
                        'instructions' => 'Select a recent news event and analyze how it was covered by three different media sources. Examine bias, framing, language use, and visual elements in a 700-word analysis.',
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Fact-Checking Exercise',
                        'description' => 'Verify claims from social media using fact-checking methodologies.',
                        'instructions' => 'Select three viral claims from social media and verify their accuracy using proper fact-checking methodologies. Document your process and findings in a detailed report.',
                        'points_reward' => 130,
                    ],
                    [
                        'name' => 'Digital Media Creation',
                        'description' => 'Create an informative digital media piece on a social issue.',
                        'instructions' => 'Create an informative digital media piece (video, podcast, infographic, etc.) about an important social issue. Apply principles of ethical and effective communication.',
                        'points_reward' => 150,
                    ],
                ]
            ],
            [
                'name' => 'General Mathematics',
                'description' => 'Develop mathematical reasoning and problem-solving skills applicable to real-world situations.',
                'tasks' => [
                    [
                        'name' => 'Applied Mathematics Problem Set',
                        'description' => 'Solve a set of real-world mathematics problems.',
                        'instructions' => "Complete the provided set of 10 mathematics problems that apply concepts such as functions, equations, and statistics to real-world scenarios.\n\nSample Problems:\n\n1. A local coffee shop finds that their daily profit (P) in pesos is related to the number of specialty drinks (x) they sell by the function P(x) = -0.5x² + 120x - 1000. How many specialty drinks should they sell to maximize their profit? What is the maximum profit?\n\n2. A rectangular garden is being designed with a perimeter of 100 meters. What dimensions will maximize the garden's area? Show your work using calculus.\n\n3. In a survey of 200 students, 85 are taking mathematics, 65 are taking physics, and 40 are taking both. What is the probability that a randomly selected student is taking mathematics or physics?\n\n4. A company manufactures smartphones at a cost of ₱8,000 per unit. Market research suggests that if they price each phone at ₱p, they will sell (20,000 - 1000p) units. What price should they set to maximize profit?\n\n5. The population of a city grows according to the function P(t) = 50,000e^(0.03t), where t is measured in years. How long will it take for the population to double from its initial size?",
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Mathematical Modeling Project',
                        'description' => 'Create a mathematical model for a real-world situation.',
                        'instructions' => 'Develop a mathematical model for a real-world situation of your choice. Explain your variables, equations, assumptions, and limitations in a detailed report.',
                        'points_reward' => 150,
                    ],
                    [
                        'name' => 'Financial Mathematics Application',
                        'description' => 'Apply mathematics to personal financial planning.',
                        'instructions' => 'Create a comprehensive personal financial plan using mathematical concepts such as compound interest, loan amortization, and investment growth calculations.',
                        'points_reward' => 130,
                    ],
                ]
            ],
            [
                'name' => 'Statistics and Probability',
                'description' => 'Learn to collect, analyze, and interpret data using statistical methods and probability theory.',
                'tasks' => [
                    [
                        'name' => 'Data Analysis Project',
                        'description' => 'Analyze a dataset using statistical methods.',
                        'instructions' => 'Using the provided dataset, perform a comprehensive statistical analysis. Include measures of central tendency, dispersion, correlation, and appropriate visualizations.',
                        'points_reward' => 130,
                    ],
                    [
                        'name' => 'Probability Problem Set',
                        'description' => 'Solve a set of probability problems.',
                        'instructions' => 'Complete the provided set of 10 probability problems covering concepts such as conditional probability, independence, and random variables.',
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Statistical Research Design',
                        'description' => 'Design a statistical research study.',
                        'instructions' => 'Design a statistical research study on a topic of your choice. Include research questions, sampling methods, data collection procedures, and planned analysis techniques.',
                        'points_reward' => 150,
                    ],
                ]
            ],
            [
                'name' => 'Earth and Life Science',
                'description' => 'Study the interconnected systems of Earth and the diversity of life forms that inhabit it.',
                'tasks' => [
                    [
                        'name' => 'Ecosystem Analysis',
                        'description' => 'Analyze the components and interactions within a specific ecosystem.',
                        'instructions' => 'Select a specific ecosystem and analyze its biotic and abiotic components, energy flow, nutrient cycling, and human impacts. Submit a 800-word report with diagrams.',
                        'points_reward' => 130,
                    ],
                    [
                        'name' => 'Geological Processes Investigation',
                        'description' => 'Investigate geological processes and their effects on Earth\'s surface.',
                        'instructions' => 'Research a specific geological process (e.g., plate tectonics, weathering, erosion) and create a detailed report on its mechanisms and effects on Earth\'s surface features.',
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Biodiversity Conservation Proposal',
                        'description' => 'Develop a proposal for conserving biodiversity in a specific region.',
                        'instructions' => 'Create a conservation proposal for a specific region facing biodiversity threats. Include assessment of current biodiversity, threats, and specific conservation strategies.',
                        'points_reward' => 150,
                    ],
                ]
            ],
            [
                'name' => 'Physical Science',
                'description' => 'Explore the fundamental principles of physics and chemistry that govern the natural world.',
                'tasks' => [
                    [
                        'name' => 'Physics Experiment',
                        'description' => 'Design and conduct a physics experiment to test a specific principle.',
                        'instructions' => 'Design and conduct an experiment to test a principle of mechanics, electricity, or optics. Document your hypothesis, methodology, results, and conclusions.',
                        'points_reward' => 140,
                    ],
                    [
                        'name' => 'Chemical Reactions Analysis',
                        'description' => 'Analyze different types of chemical reactions and their applications.',
                        'instructions' => 'Investigate three different types of chemical reactions. For each, explain the underlying principles, balanced equations, and real-world applications.',
                        'points_reward' => 130,
                    ],
                    [
                        'name' => 'Energy Transformation Project',
                        'description' => 'Create a project demonstrating energy transformations.',
                        'instructions' => 'Design and build a simple device that demonstrates at least three different energy transformations. Document the process and explain the physics principles involved.',
                        'points_reward' => 150,
                    ],
                ]
            ],
            [
                'name' => 'Introduction to the Philosophy of the Human Person',
                'description' => 'Explore philosophical questions about human existence, consciousness, ethics, and the meaning of life.',
                'tasks' => [
                    [
                        'name' => 'Philosophical Essay',
                        'description' => 'Write an essay exploring a philosophical question about human nature.',
                        'instructions' => "Write a 1000-word philosophical essay exploring one of the provided questions about human nature, consciousness, or personal identity. Engage with the ideas of at least two philosophers.\n\nEssay Topics (choose one):\n1. Is human nature inherently good, evil, or neutral?\n2. Does free will exist, or are our actions determined?\n3. What constitutes personal identity over time?\n4. What is the relationship between mind and body?\n5. Can we know anything with absolute certainty?\n\nRequirements:\n- Clearly state your thesis/position on the philosophical question\n- Discuss the views of at least two philosophers on your chosen topic\n- Present arguments for and against your position\n- Address potential objections to your view\n- Apply the philosophical concepts to a contemporary issue or example\n\nQuestions to consider:\n- How do different philosophical traditions approach this question?\n- What evidence or reasoning supports your position?\n- What are the implications of your view for how we understand humanity?\n- How might your position influence ethical decisions or social policies?",
                        'points_reward' => 140,
                    ],
                    [
                        'name' => 'Ethical Dilemma Analysis',
                        'description' => 'Analyze an ethical dilemma using different philosophical frameworks.',
                        'instructions' => 'Select an ethical dilemma and analyze it using three different philosophical frameworks (e.g., utilitarianism, deontology, virtue ethics). Explain how each approach would address the dilemma.',
                        'points_reward' => 130,
                    ],
                    [
                        'name' => 'Philosophical Dialogue Creation',
                        'description' => 'Create a dialogue between philosophers with different perspectives.',
                        'instructions' => 'Create a dialogue between two or more philosophers with different perspectives on a question about human existence. Show understanding of each philosopher\'s ideas and reasoning.',
                        'points_reward' => 120,
                    ],
                ]
            ],
            [
                'name' => 'Personal Development',
                'description' => 'Develop self-awareness, interpersonal skills, and strategies for personal growth and well-being.',
                'tasks' => [
                    [
                        'name' => 'Self-Assessment and Goal Setting',
                        'description' => 'Conduct a comprehensive self-assessment and develop personal goals.',
                        'instructions' => 'Complete the provided self-assessment tools, analyze your strengths and areas for growth, and develop SMART goals for personal development in three different areas of your life.',
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Stress Management Plan',
                        'description' => 'Create a personalized stress management plan.',
                        'instructions' => 'Research stress management techniques, identify your personal stress triggers, and develop a comprehensive plan incorporating at least five different evidence-based strategies.',
                        'points_reward' => 130,
                    ],
                    [
                        'name' => 'Interpersonal Skills Development',
                        'description' => 'Practice and reflect on interpersonal communication skills.',
                        'instructions' => 'Complete three interpersonal communication exercises with different people. Document the interactions, apply specific communication techniques, and reflect on the outcomes and learnings.',
                        'points_reward' => 140,
                    ],
                ]
            ],
            [
                'name' => 'Understanding Culture, Society, and Politics',
                'description' => 'Examine the interrelationships between culture, society, and politics in local and global contexts.',
                'tasks' => [
                    [
                        'name' => 'Cultural Analysis',
                        'description' => 'Analyze how cultural factors influence social and political systems.',
                        'instructions' => 'Select a specific cultural practice or belief and analyze how it influences and is influenced by social structures and political systems. Submit a 800-word analysis.',
                        'points_reward' => 130,
                    ],
                    [
                        'name' => 'Social Institution Research',
                        'description' => 'Research the evolution and function of a social institution.',
                        'instructions' => 'Select a social institution (e.g., family, education, religion) and research its historical development, current functions, and variations across different societies.',
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Political System Comparative Analysis',
                        'description' => 'Compare different political systems and their cultural contexts.',
                        'instructions' => 'Compare two different political systems, analyzing their historical development, institutional structures, cultural foundations, and effectiveness in addressing societal needs.',
                        'points_reward' => 150,
                    ],
                ]
            ],
        ];

        // Create challenges and tasks
        foreach ($coreSubjects as $subjectData) {
            $challenge = Challenge::create([
                'name' => $subjectData['name'],
                'description' => $subjectData['description'],
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(6),
                'points_reward' => 0, // Will be calculated from tasks
                'difficulty_level' => 'intermediate',
                'is_active' => true,
                'required_level' => 1,
                'challenge_type' => 'education',
                'programming_language' => 'none',
                'tech_category' => 'none',
                'subject_type' => 'core',
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

        $this->command->info('Core Subjects seeded successfully!');
    }
}
