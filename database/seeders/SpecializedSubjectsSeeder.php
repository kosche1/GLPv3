<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SpecializedSubjectsSeeder extends Seeder
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

        // Define specialized subjects
        $specializedSubjects = [
            [
                'name' => 'Creative Writing',
                'description' => 'Develop skills in creative writing across various genres and formats.',
                'tasks' => [
                    [
                        'name' => 'Elements of Fiction',
                        'description' => 'Identify and explain the key elements of fiction writing.',
                        'instructions' => "Task: Identify and explain the five key elements of fiction writing.\n\nFor each element:\n- Define what it is and why it's important\n- Explain how it contributes to a story's effectiveness\n- Provide examples from well-known literary works\n- Offer tips for developing this element in creative writing\n\nElements to include: plot, character, setting, point of view, and theme.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Poetry Forms',
                        'description' => 'Identify and explain different forms of poetry.',
                        'instructions' => "Task: Identify and explain five different forms of poetry.\n\nFor each form:\n- Define its structure and key characteristics\n- Explain its historical origins (if relevant)\n- Describe the typical themes or purposes associated with this form\n- Provide a short example or excerpt\n\nForms to include: sonnet, haiku, free verse, limerick, and ballad.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Creative Writing Techniques',
                        'description' => 'Identify and explain techniques used in creative writing.',
                        'instructions' => "Task: Identify and explain five techniques commonly used in creative writing.\n\nFor each technique:\n- Define what it is and how it works\n- Explain when and why writers use it\n- Provide an example from literature\n- Offer tips for effectively implementing this technique\n\nTechniques to include: imagery, metaphor and simile, dialogue, foreshadowing, and characterization.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Computer Programming',
                'description' => 'Develop fundamental programming skills and understanding of computer science concepts.',
                'tasks' => [
                    [
                        'name' => 'Programming Fundamentals',
                        'description' => 'Identify and explain fundamental programming concepts.',
                        'instructions' => "Task: Identify and explain five fundamental programming concepts that are common across most programming languages.\n\nFor each concept:\n- Define what it is in simple terms\n- Explain why it's important in programming\n- Describe how it's typically implemented\n- Provide a simple example in pseudocode or a common programming language\n\nConcepts to include: variables and data types, control structures (conditionals and loops), functions/methods, arrays/lists, and input/output operations.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Programming Languages',
                        'description' => 'Identify and compare different programming languages.',
                        'instructions' => "Task: Identify and compare five different programming languages.\n\nFor each language:\n- Describe its key features and design philosophy\n- Explain what types of applications it's commonly used for\n- Discuss its advantages and limitations\n- Provide a simple 'Hello World' example in that language\n\nLanguages to include: Python, JavaScript, Java, C++, and PHP.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Software Development Process',
                        'description' => 'Identify and explain the stages of the software development process.',
                        'instructions' => "Task: Identify and explain the six main stages of the software development life cycle (SDLC).\n\nFor each stage:\n- Define what happens during this stage\n- Explain its importance in the overall process\n- Describe the key activities and deliverables\n- Identify potential challenges or common issues\n\nStages to include: requirements gathering, design, implementation (coding), testing, deployment, and maintenance.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Robotics',
                'description' => 'Develop knowledge and skills in robotics design, programming, and applications.',
                'tasks' => [
                    [
                        'name' => 'Robotics Components',
                        'description' => 'Identify and explain the main components of a robot.',
                        'instructions' => "Task: Identify and explain the five main components of a typical robot.\n\nFor each component:\n- Define what it is and its function\n- Explain how it contributes to the robot's operation\n- Describe different types or variations of this component\n- Provide examples of how this component is implemented in real robots\n\nComponents to include: sensors, actuators, power supply, control systems, and mechanical structure.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Robot Types and Applications',
                        'description' => 'Identify and explain different types of robots and their applications.',
                        'instructions' => "Task: Identify and explain five different types of robots and their real-world applications.\n\nFor each type:\n- Describe its key characteristics and design\n- Explain its primary functions and capabilities\n- Discuss its main applications and use cases\n- Identify advantages and limitations\n\nTypes to include: industrial robots, service robots, medical robots, exploration robots, and educational robots.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Robotics Programming Concepts',
                        'description' => 'Identify and explain key concepts in robotics programming.',
                        'instructions' => "Task: Identify and explain five key concepts in robotics programming.\n\nFor each concept:\n- Define what it is and why it's important\n- Explain how it's implemented in robot programming\n- Describe challenges associated with this concept\n- Provide a simple example of how it might be coded\n\nConcepts to include: motion planning, sensor integration, control algorithms, human-robot interaction, and autonomous navigation.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Animation',
                'description' => 'Develop skills in creating animations using various techniques and tools.',
                'tasks' => [
                    [
                        'name' => 'Animation Principles',
                        'description' => 'Identify and explain the fundamental principles of animation.',
                        'instructions' => "Task: Identify and explain five of the 12 basic principles of animation as developed by Disney animators.\n\nFor each principle:\n- Define what it is and how it works\n- Explain why it's important for creating realistic or appealing animation\n- Describe how it creates a specific effect or impression\n- Provide an example of this principle in action\n\nPrinciples to select from: squash and stretch, anticipation, staging, straight ahead vs. pose to pose, follow through and overlapping action, slow in and slow out, arcs, secondary action, timing, exaggeration, solid drawing, and appeal.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Animation Techniques',
                        'description' => 'Identify and explain different animation techniques.',
                        'instructions' => "Task: Identify and explain five different animation techniques used in the industry.\n\nFor each technique:\n- Describe what it is and how it works\n- Explain the tools and materials typically used\n- Discuss its advantages and limitations\n- Provide examples of notable works created using this technique\n\nTechniques to include: traditional hand-drawn animation, 2D digital animation, 3D computer animation, stop motion animation, and motion graphics.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Animation Production Process',
                        'description' => 'Identify and explain the stages of the animation production process.',
                        'instructions' => "Task: Identify and explain the six main stages of the animation production process.\n\nFor each stage:\n- Define what happens during this stage\n- Explain its importance in the overall process\n- Describe the key activities and deliverables\n- Identify the roles or team members typically involved\n\nStages to include: concept and development, pre-production (storyboarding, design), production (animation), post-production (compositing, effects), sound design, and final output/rendering.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Journalism',
                'description' => 'Develop skills in journalistic writing, reporting, and media production.',
                'tasks' => [
                    [
                        'name' => 'Journalistic Writing Styles',
                        'description' => 'Identify and explain different journalistic writing styles.',
                        'instructions' => "Task: Identify and explain five different journalistic writing styles or formats.\n\nFor each style:\n- Define what it is and its key characteristics\n- Explain when and where it's typically used\n- Describe its structure and components\n- Provide tips for effective writing in this style\n\nStyles to include: news articles, feature stories, opinion pieces/editorials, profiles, and investigative reports.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Journalism Ethics',
                        'description' => 'Identify and explain ethical principles in journalism.',
                        'instructions' => "Task: Identify and explain five key ethical principles that journalists should follow.\n\nFor each principle:\n- Define what it means in the context of journalism\n- Explain why it's important for journalistic integrity\n- Describe potential ethical dilemmas related to this principle\n- Provide an example of how this principle might be applied in a real situation\n\nPrinciples to include: truth and accuracy, independence, fairness and impartiality, accountability, and minimizing harm.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'News Gathering Techniques',
                        'description' => 'Identify and explain techniques for gathering news and information.',
                        'instructions' => "Task: Identify and explain five techniques journalists use to gather news and information.\n\nFor each technique:\n- Describe what it is and how it's conducted\n- Explain when it's most appropriate to use\n- Discuss its strengths and limitations\n- Provide tips for using this technique effectively\n\nTechniques to include: interviews, observation/field reporting, document research, data analysis, and source cultivation.",
                        'points_reward' => 100,
                    ],
                ]
            ],
        ];

        // Create challenges and tasks
        foreach ($specializedSubjects as $subjectData) {
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
                'tech_category' => 'none',
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

        $this->command->info('Specialized Subjects seeded successfully!');
    }
}
