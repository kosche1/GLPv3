<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AppliedSubjectsSeeder extends Seeder
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

        // Get the Applied subject type
        $appliedSubjectType = \App\Models\SubjectType::where('code', 'applied')->first();

        // Define applied subjects
        $appliedSubjects = [
            [
                'name' => 'English for Academic and Professional Purposes',
                'description' => 'Develop English language skills for academic and professional contexts.',
                'tasks' => [
                    [
                        'name' => 'Academic Writing Formats',
                        'description' => 'Identify and explain different academic writing formats.',
                        'instructions' => "Task: List and explain five different academic writing formats.\n\nFor each format:\n- Define what it is and its purpose\n- Describe its structure and key components\n- Explain when it is typically used\n- Identify its key formatting and citation requirements\n\nFormats to include: research papers, literature reviews, case studies, annotated bibliographies, and academic essays.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Professional Communication',
                        'description' => 'Identify and explain different types of professional communication.',
                        'instructions' => "Task: Identify and explain five types of professional written communication used in the workplace.\n\nFor each type:\n- Define what it is and its purpose\n- Describe its key components and structure\n- Explain when and why it is used\n- Provide tips for effective writing\n\nTypes to include: business emails, cover letters, resumes/CVs, memorandums, and business reports.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Academic Vocabulary',
                        'description' => 'Identify and use academic vocabulary appropriately.',
                        'instructions' => "Task: Identify 20 common academic words or phrases and explain how to use them correctly.\n\nFor each word or phrase:\n- Provide a clear definition\n- Explain its function in academic writing\n- Give an example sentence showing proper usage\n- Identify any common misuses or errors to avoid\n\nInclude words from different categories such as: transition words, hedging expressions, reporting verbs, and words for analysis and evaluation.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Practical Research 1',
                'description' => 'Learn the fundamentals of quantitative research methods and their applications.',
                'tasks' => [
                    [
                        'name' => 'Quantitative Research Design',
                        'description' => 'Identify and explain different quantitative research designs.',
                        'instructions' => "Task: Identify and explain four major quantitative research designs.\n\nFor each research design:\n- Define what it is and its key characteristics\n- Explain when it is most appropriate to use\n- Describe the typical process or steps involved\n- Discuss its strengths and limitations\n\nResearch designs to include: experimental, quasi-experimental, correlational, and survey research.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Sampling Methods',
                        'description' => 'Identify and explain different sampling methods in quantitative research.',
                        'instructions' => "Task: Identify and explain five sampling methods used in quantitative research.\n\nFor each sampling method:\n- Define what it is and how it works\n- Explain when it is most appropriate to use\n- Discuss its advantages and limitations\n- Provide an example of a research scenario where this method would be suitable\n\nSampling methods to include: simple random sampling, stratified sampling, cluster sampling, systematic sampling, and convenience sampling.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Statistical Analysis Basics',
                        'description' => 'Identify and explain basic statistical concepts and tests.',
                        'instructions' => "Task: Identify and explain five basic statistical concepts and tests used in quantitative research.\n\nFor each statistical concept/test:\n- Define what it is and what it measures\n- Explain when and why it is used\n- Describe how to interpret its results\n- Provide an example of a research question that could be answered using this test\n\nConcepts/tests to include: measures of central tendency, measures of dispersion, t-test, correlation analysis, and chi-square test.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Practical Research 2',
                'description' => 'Learn the fundamentals of qualitative research methods and their applications.',
                'tasks' => [
                    [
                        'name' => 'Qualitative Research Approaches',
                        'description' => 'Identify and explain different qualitative research approaches.',
                        'instructions' => "Task: Identify and explain four major qualitative research approaches.\n\nFor each research approach:\n- Define what it is and its key characteristics\n- Explain when it is most appropriate to use\n- Describe the typical process or steps involved\n- Discuss its strengths and limitations\n\nApproaches to include: phenomenology, ethnography, grounded theory, and case study research.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Qualitative Data Collection Methods',
                        'description' => 'Identify and explain methods for collecting qualitative data.',
                        'instructions' => "Task: Identify and explain five methods for collecting qualitative data.\n\nFor each method:\n- Define what it is and how it works\n- Explain when it is most appropriate to use\n- Discuss its advantages and limitations\n- Provide tips for implementing it effectively\n\nMethods to include: in-depth interviews, focus group discussions, participant observation, document analysis, and photo/video elicitation.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Qualitative Data Analysis',
                        'description' => 'Identify and explain approaches to qualitative data analysis.',
                        'instructions' => "Task: Identify and explain four approaches to qualitative data analysis.\n\nFor each approach:\n- Define what it is and its key characteristics\n- Explain the process or steps involved\n- Discuss its advantages and limitations\n- Provide an example of a research question that could be addressed using this approach\n\nApproaches to include: thematic analysis, content analysis, discourse analysis, and narrative analysis.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Filipino sa Piling Larangan (Akademik, Isports, Sining, Tech-Voc)',
                'description' => 'Apply Filipino language skills in specialized fields and professional contexts.',
                'tasks' => [
                    [
                        'name' => 'Filipino sa Akademikong Larangan',
                        'description' => 'Identify and use Filipino terminology in academic contexts.',
                        'instructions' => "Task: Ilista at ipaliwanag ang 15 terminolohiyang Filipino na ginagamit sa akademikong larangan.\n\nPara sa bawat terminolohiya:\n- Ibigay ang kahulugan nito\n- Ipaliwanag kung paano ito ginagamit sa akademikong konteksto\n- Magbigay ng halimbawang pangungusap\n- Tukuyin ang katumbas nito sa Ingles (kung mayroon)\n\nPumili ng mga terminolohiya mula sa iba't ibang disiplina tulad ng agham, matematika, kasaysayan, at literatura.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Filipino sa Propesyonal na Larangan',
                        'description' => 'Identify and use Filipino terminology in professional contexts.',
                        'instructions' => "Task: Ilista at ipaliwanag ang 15 terminolohiyang Filipino na ginagamit sa propesyonal na larangan.\n\nPara sa bawat terminolohiya:\n- Ibigay ang kahulugan nito\n- Ipaliwanag kung paano ito ginagamit sa propesyonal na konteksto\n- Magbigay ng halimbawang pangungusap\n- Tukuyin ang katumbas nito sa Ingles (kung mayroon)\n\nPumili ng mga terminolohiya mula sa iba't ibang propesyon tulad ng negosyo, teknolohiya, kalusugan, at batas.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Pagsulat ng Propesyonal na Dokumento',
                        'description' => 'Identify and explain different types of professional documents in Filipino.',
                        'instructions' => "Task: Ilista at ipaliwanag ang limang uri ng propesyonal na dokumento na isinusulat sa Filipino.\n\nPara sa bawat uri ng dokumento:\n- Ipaliwanag kung ano ito at ang layunin nito\n- Ilarawan ang istraktura at mga pangunahing bahagi nito\n- Magbigay ng mga halimbawa kung kailan ito ginagamit\n- Magbigay ng mga tip para sa epektibong pagsulat nito\n\nMga uri ng dokumento na dapat isama: liham-aplikasyon, resume, memorandum, ulat, at liham-pangkalakal.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Empowerment Technologies',
                'description' => 'Develop skills in using technology for personal and professional empowerment.',
                'tasks' => [
                    [
                        'name' => 'Digital Tools for Productivity',
                        'description' => 'Identify and explain digital tools for personal and professional productivity.',
                        'instructions' => "Task: Identify and explain five digital tools or applications that enhance productivity.\n\nFor each tool:\n- Describe what it is and its main purpose\n- Explain its key features and functions\n- Discuss how it can improve personal or professional productivity\n- Identify its advantages over traditional methods\n\nInclude tools from different categories such as: project management, time management, note-taking, file organization, and communication tools.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Online Collaboration Platforms',
                        'description' => 'Identify and explain platforms for online collaboration and teamwork.',
                        'instructions' => "Task: Identify and explain five online platforms for collaboration and teamwork.\n\nFor each platform:\n- Describe what it is and its primary purpose\n- Explain its key features and functions\n- Discuss how it facilitates collaboration and teamwork\n- Identify what types of projects or teams it works best for\n\nInclude platforms for different collaboration needs such as: document sharing, video conferencing, project management, design collaboration, and code collaboration.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Digital Citizenship',
                        'description' => 'Identify and explain principles of responsible digital citizenship.',
                        'instructions' => "Task: Identify and explain five principles of responsible digital citizenship.\n\nFor each principle:\n- Define what it means and why it's important\n- Explain how it applies to online behavior and activities\n- Provide examples of both responsible and irresponsible practices\n- Suggest ways to promote this principle in digital communities\n\nPrinciples to include: digital etiquette, digital security, digital rights and responsibilities, digital literacy, and digital health and wellness.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Entrepreneurship',
                'description' => 'Develop knowledge and skills for starting and managing business ventures.',
                'tasks' => [
                    [
                        'name' => 'Business Models',
                        'description' => 'Identify and explain different business models.',
                        'instructions' => "Task: Identify and explain five different business models used by successful companies.\n\nFor each business model:\n- Define what it is and how it works\n- Provide an example of a well-known company using this model\n- Explain the key revenue streams in this model\n- Discuss the advantages and potential challenges of this model\n\nBusiness models to include: subscription model, freemium model, marketplace model, franchise model, and direct sales model.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Marketing Strategies',
                        'description' => 'Identify and explain different marketing strategies for businesses.',
                        'instructions' => "Task: Identify and explain five marketing strategies that entrepreneurs can use to promote their products or services.\n\nFor each strategy:\n- Define what it is and how it works\n- Explain when and why it would be effective\n- Provide an example of how a small business might implement it\n- Discuss the potential costs and benefits\n\nStrategies to include: content marketing, social media marketing, email marketing, influencer marketing, and search engine optimization (SEO).",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Financial Management Basics',
                        'description' => 'Identify and explain basic financial concepts for entrepreneurs.',
                        'instructions' => "Task: Identify and explain five basic financial concepts that entrepreneurs need to understand.\n\nFor each concept:\n- Define what it is in simple terms\n- Explain why it's important for business success\n- Describe how it's calculated or implemented\n- Provide an example of how it applies to a small business\n\nConcepts to include: cash flow management, profit margins, break-even analysis, startup costs calculation, and basic financial statements (income statement, balance sheet).",
                        'points_reward' => 100,
                    ],
                ]
            ],
        ];

        // Create challenges and tasks
        foreach ($appliedSubjects as $subjectData) {
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
                'subject_type' => 'applied',
                'subject_type_id' => $appliedSubjectType->id,
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

        $this->command->info('Applied Subjects seeded successfully!');
    }
}
