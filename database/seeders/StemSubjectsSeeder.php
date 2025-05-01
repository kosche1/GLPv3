<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class StemSubjectsSeeder extends Seeder
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

        // Get the Specialized subject type
        $specializedSubjectType = \App\Models\SubjectType::where('code', 'specialized')->first();

        // Get the STEM strand
        $stemStrand = \App\Models\Strand::where('code', 'stem')->first();

        // Define STEM subjects
        $stemSubjects = [
            [
                'name' => 'Advanced Mathematics',
                'description' => 'Develop advanced mathematical skills and understanding of complex mathematical concepts.',
                'tech_category' => 'stem',
                'tasks' => [
                    [
                        'name' => 'Calculus Fundamentals',
                        'description' => 'Understand and apply the fundamental concepts of calculus.',
                        'instructions' => "Task: Explain the fundamental concepts of calculus and solve related problems.\n\nComplete the following:\n- Define derivatives and integrals in your own words\n- Explain the relationship between derivatives and integrals (Fundamental Theorem of Calculus)\n- Solve three derivative problems (provided below)\n- Solve two integral problems (provided below)\n- Explain a real-world application of calculus\n\nDerivative Problems:\n1. Find the derivative of f(x) = 3x^4 - 2x^2 + 5x - 7\n2. Find the derivative of g(x) = sin(x) * cos(x)\n3. Find the derivative of h(x) = e^(2x) / (x^2 + 1)\n\nIntegral Problems:\n1. Find the indefinite integral of f(x) = 4x^3 - 6x + 2\n2. Calculate the definite integral of g(x) = x^2 from x = 0 to x = 3",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Linear Algebra Applications',
                        'description' => 'Apply linear algebra concepts to solve problems.',
                        'instructions' => "Task: Demonstrate understanding of linear algebra concepts and their applications.\n\nComplete the following:\n- Explain matrices and their operations\n- Define eigenvalues and eigenvectors\n- Solve a system of linear equations using matrices\n- Perform matrix transformations\n- Describe a real-world application of linear algebra in computer graphics or data science\n\nMatrix Operations Problem:\nGiven matrices A = [[2, 1], [3, 4]] and B = [[5, 6], [7, 8]], find:\n1. A + B\n2. A - B\n3. A × B\n4. The determinant of A\n5. The inverse of A\n\nLinear System Problem:\nSolve the following system of equations using matrices:\n2x + y + 3z = 5\n4x - 2y + z = 3\nx + y + z = 6",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Statistical Analysis',
                        'description' => 'Apply statistical methods to analyze data and draw conclusions.',
                        'instructions' => "Task: Demonstrate understanding of statistical concepts and methods for data analysis.\n\nComplete the following:\n- Explain measures of central tendency and dispersion\n- Describe the difference between descriptive and inferential statistics\n- Calculate mean, median, mode, and standard deviation for a given dataset\n- Perform hypothesis testing on a sample dataset\n- Interpret correlation and regression analysis results\n\nDataset for Analysis:\nThe following dataset represents test scores of 15 students:\n78, 85, 92, 65, 70, 88, 72, 90, 83, 79, 95, 68, 74, 81, 87\n\n1. Calculate the mean, median, and mode\n2. Calculate the range, variance, and standard deviation\n3. Determine if the data follows a normal distribution\n4. If the population mean is assumed to be 75, perform a hypothesis test to determine if this sample suggests a different population mean (use α = 0.05)\n5. Interpret your findings in context",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Research in Physical Sciences',
                'description' => 'Develop skills in scientific research methods and understanding of physical science concepts.',
                'tech_category' => 'stem',
                'tasks' => [
                    [
                        'name' => 'Scientific Method Application',
                        'description' => 'Apply the scientific method to investigate a physical science phenomenon.',
                        'instructions' => "Task: Demonstrate understanding of the scientific method by designing a research investigation.\n\nComplete the following:\n- Identify a research question related to physics or chemistry\n- Formulate a testable hypothesis\n- Design an experimental procedure with clear variables (independent, dependent, controlled)\n- Describe data collection methods and tools\n- Explain how you would analyze results and draw conclusions\n- Discuss potential sources of error and limitations\n\nYour research proposal should be structured with the following sections:\n1. Research Question\n2. Background Information\n3. Hypothesis\n4. Materials and Methods\n5. Expected Results\n6. Data Analysis Plan\n7. Potential Applications\n8. Limitations and Future Directions",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Physics Principles and Applications',
                        'description' => 'Understand and apply fundamental physics principles to real-world scenarios.',
                        'instructions' => "Task: Explain key physics principles and solve related problems.\n\nComplete the following:\n- Explain Newton's Laws of Motion and provide examples\n- Describe the principles of energy conservation\n- Solve problems related to motion, forces, and energy\n- Explain a practical application of physics principles in technology\n- Analyze a physical phenomenon using physics concepts\n\nPhysics Problems:\n1. A 2kg object is pushed with a force of 10N. Calculate its acceleration.\n2. A ball is thrown upward with an initial velocity of 15 m/s. Calculate the maximum height it reaches.\n3. A 1500kg car is moving at 20 m/s. How much kinetic energy does it possess? If it needs to stop, how much work must be done?\n4. Two objects with masses 5kg and 3kg are separated by 2m. Calculate the gravitational force between them.\n5. A simple pendulum has a length of 1m. Calculate its period on Earth (g = 9.8 m/s²).",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Chemistry Fundamentals',
                        'description' => 'Understand and apply fundamental chemistry concepts.',
                        'instructions' => "Task: Demonstrate understanding of chemistry fundamentals and their applications.\n\nComplete the following:\n- Explain atomic structure and the periodic table organization\n- Describe different types of chemical bonds and their properties\n- Balance chemical equations and perform stoichiometric calculations\n- Explain acid-base reactions and pH scale\n- Describe a real-world application of chemistry in industry or medicine\n\nChemistry Problems:\n1. Balance the following chemical equations:\n   a) C₃H₈ + O₂ → CO₂ + H₂O\n   b) Fe + O₂ → Fe₂O₃\n   c) Al + H₂SO₄ → Al₂(SO₄)₃ + H₂\n\n2. Calculate the molar mass of C₆H₁₂O₆ (glucose)\n\n3. If 25g of CaCO₃ decomposes according to the equation CaCO₃ → CaO + CO₂, calculate:\n   a) The mass of CaO produced\n   b) The volume of CO₂ produced at STP\n\n4. Calculate the pH of a solution with [H⁺] = 3.2 × 10⁻⁵ M\n\n5. Identify the type of bond in each compound: NaCl, CO₂, H₂O, CH₄",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Engineering and Technology',
                'description' => 'Develop understanding of engineering principles and technological applications.',
                'tech_category' => 'stem',
                'tasks' => [
                    [
                        'name' => 'Engineering Design Process',
                        'description' => 'Apply the engineering design process to solve a problem.',
                        'instructions' => "Task: Demonstrate understanding of the engineering design process by developing a solution to a problem.\n\nComplete the following:\n- Identify a problem that can be solved through engineering\n- Research existing solutions and constraints\n- Brainstorm and evaluate multiple potential solutions\n- Select and develop a detailed design for your best solution\n- Create a prototype plan (conceptual or actual)\n- Develop a testing and evaluation strategy\n\nYour engineering design proposal should include:\n1. Problem Statement\n2. Background Research\n3. Design Requirements and Constraints\n4. Alternative Solutions (at least 3)\n5. Decision Matrix for Solution Selection\n6. Detailed Design Description (with diagrams if possible)\n7. Materials and Construction Plan\n8. Testing and Evaluation Methods\n9. Potential Improvements and Iterations",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Renewable Energy Technologies',
                        'description' => 'Understand and evaluate different renewable energy technologies.',
                        'instructions' => "Task: Research and analyze renewable energy technologies and their applications.\n\nComplete the following:\n- Explain the principles behind at least three renewable energy sources (solar, wind, hydroelectric, geothermal, biomass, etc.)\n- Compare the efficiency, cost, and environmental impact of these technologies\n- Analyze the suitability of different renewable energy sources for specific geographical locations\n- Design a renewable energy system for a specific application (home, school, community)\n- Discuss challenges and future developments in renewable energy\n\nYour analysis should include:\n1. Description of Each Technology\n2. Working Principles and Energy Conversion Methods\n3. Comparative Analysis (efficiency, cost, environmental impact)\n4. Case Studies of Successful Implementations\n5. Location-Specific Considerations\n6. Detailed Design for Your Chosen Application\n7. Implementation Challenges\n8. Future Trends and Innovations",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Structural Engineering Principles',
                        'description' => 'Understand and apply principles of structural engineering.',
                        'instructions' => "Task: Demonstrate understanding of structural engineering principles and their applications.\n\nComplete the following:\n- Explain basic concepts of forces, loads, and structural stability\n- Describe different types of structures and their characteristics\n- Analyze forces and stresses in simple structures\n- Design a simple structure to meet specific requirements\n- Evaluate existing structures for their engineering principles\n\nStructural Analysis Problems:\n1. Calculate the reactions at the supports of a simply supported beam of length 6m with a point load of 10kN at the center.\n\n2. Determine the maximum bending moment and shear force in a cantilever beam of length 3m with a uniformly distributed load of 5kN/m.\n\n3. Analyze the forces in each member of a simple truss structure (diagram provided).\n\n4. Design a column to support a compressive load of 50kN with a safety factor of 2.\n\n5. For your design project, create a bridge design that can span 30cm and support a minimum load of 1kg using only paper and adhesive. Explain your design choices and how they relate to structural engineering principles.",
                        'points_reward' => 100,
                    ],
                ]
            ],
        ];

        // Create challenges and tasks
        foreach ($stemSubjects as $subjectData) {
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
                'subject_type_id' => $specializedSubjectType->id,
                'strand_id' => $stemStrand->id,
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

        $this->command->info('STEM Subjects seeded successfully!');
    }
}
