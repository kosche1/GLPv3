<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class HeSubjectsSeeder extends Seeder
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

        // Get the HE strand
        $heStrand = \App\Models\Strand::where('code', 'he')->first();

        // Define HE subjects
        $heSubjects = [
            [
                'name' => 'Food and Nutrition',
                'description' => 'Develop understanding of food science, nutrition principles, and their application to health and wellness.',
                'tech_category' => 'he',
                'tasks' => [
                    [
                        'name' => 'Nutrition Fundamentals',
                        'description' => 'Understand and apply fundamental nutrition concepts for health and wellness.',
                        'instructions' => "Task: Demonstrate understanding of nutrition fundamentals and their application to dietary planning.\n\nComplete the following:\n- Explain the six major nutrient groups and their functions\n- Analyze dietary guidelines and nutritional requirements\n- Evaluate food sources for essential nutrients\n- Apply nutritional concepts to meal planning\n- Assess the relationship between nutrition and health\n\nNutrition Fundamentals Assignment:\n1. Create a comprehensive nutrition guide that includes:\n   a) Detailed explanation of the six major nutrient groups:\n      - Carbohydrates\n      - Proteins\n      - Fats\n      - Vitamins\n      - Minerals\n      - Water\n   For each nutrient group, include:\n      - Primary functions in the body\n      - Recommended daily intake\n      - Food sources (include at least 5 examples for each)\n      - Effects of deficiency and excess\n\n2. Analyze current dietary guidelines:\n   a) Explain the key recommendations from the most recent dietary guidelines\n   b) Discuss how these guidelines translate to practical food choices\n   c) Compare dietary recommendations for different life stages (children, adolescents, adults, elderly)\n   d) Evaluate how cultural or regional factors might influence dietary patterns\n\n3. Create a 7-day meal plan for a specific demographic (e.g., adolescent, adult, elderly, pregnant woman):\n   a) Include 3 meals and 2 snacks per day\n   b) Ensure the meal plan meets nutritional requirements for your chosen demographic\n   c) Include a variety of food groups in appropriate proportions\n   d) Consider practical factors like cost, preparation time, and accessibility\n   e) Provide a nutritional analysis showing how the meal plan meets key nutrient requirements\n\n4. Write a reflection (300-400 words) discussing:\n   a) How nutrition knowledge can be applied to improve health outcomes\n   b) Challenges in implementing dietary recommendations\n   c) The relationship between nutrition and common health conditions\n   d) Current trends or controversies in nutrition science",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Food Safety and Sanitation',
                        'description' => 'Understand and apply principles of food safety and sanitation in food preparation.',
                        'instructions' => "Task: Demonstrate understanding of food safety principles and their application in food handling and preparation.\n\nComplete the following:\n- Identify common foodborne illnesses and their causes\n- Explain critical food safety principles and practices\n- Analyze hazards in the food preparation process\n- Develop protocols for safe food handling\n- Evaluate food safety systems and regulations\n\nFood Safety and Sanitation Assignment:\n1. Create a comprehensive food safety guide that includes:\n   a) Detailed information on common foodborne pathogens:\n      - Bacteria (e.g., Salmonella, E. coli, Listeria)\n      - Viruses (e.g., Norovirus, Hepatitis A)\n      - Parasites (e.g., Trichinella)\n      - Fungi (e.g., molds that produce mycotoxins)\n   For each pathogen category, include:\n      - Common sources\n      - Symptoms of illness\n      - Prevention strategies\n      - High-risk foods\n\n2. Develop a complete HACCP (Hazard Analysis Critical Control Point) plan for one of the following:\n   a) A chicken-based meal preparation\n   b) A seafood dish\n   c) A dairy-based dessert\n   d) A buffet service event\n   Your HACCP plan should include:\n      - Flow diagram of the food preparation process\n      - Identification of potential hazards at each step\n      - Critical control points\n      - Critical limits for each control point\n      - Monitoring procedures\n      - Corrective actions\n      - Verification procedures\n      - Record-keeping systems\n\n3. Create an illustrated guide for proper food handling practices that covers:\n   a) Personal hygiene for food handlers\n   b) Proper handwashing technique\n   c) Cross-contamination prevention\n   d) Time and temperature control (the \"danger zone\")\n   e) Safe storage practices\n   f) Cleaning and sanitizing procedures\n   g) Receiving and inspecting food deliveries\n\n4. Develop a food safety training plan for a small food business that includes:\n   a) Key training topics and learning objectives\n   b) Training methods and materials\n   c) Assessment strategies\n   d) Schedule for initial and refresher training\n   e) Documentation and record-keeping procedures",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Meal Planning and Preparation',
                        'description' => 'Apply principles of nutrition, food science, and culinary techniques to meal planning and preparation.',
                        'instructions' => "Task: Demonstrate understanding of meal planning principles and food preparation techniques.\n\nComplete the following:\n- Apply nutritional guidelines to meal planning\n- Develop balanced menus for different needs and occasions\n- Demonstrate understanding of food preparation techniques\n- Apply principles of food science to cooking methods\n- Evaluate meals for nutritional value, cost, and appeal\n\nMeal Planning and Preparation Assignment:\n1. Create a comprehensive meal planning guide that includes:\n   a) Principles of balanced meal planning\n   b) Factors to consider when planning meals (nutritional needs, preferences, budget, time, equipment, skills)\n   c) Menu planning strategies (cycle menus, theme-based planning, seasonal planning)\n   d) Portion size guidelines\n   e) Strategies for meal planning on a budget\n\n2. Develop three complete menu plans for different scenarios:\n   a) A week of family dinners for a household of four with two school-age children\n   b) A day of meals for a special dietary need (gluten-free, diabetic, vegetarian, etc.)\n   c) A three-course dinner party menu for six people\n   \n   For each menu plan, include:\n   - Complete menu with all components\n   - Nutritional analysis showing how it meets dietary guidelines\n   - Shopping list with estimated costs\n   - Preparation timeline and workflow\n   - Equipment needed\n\n3. Create detailed recipes for three dishes from your menu plans that demonstrate different cooking techniques:\n   a) A protein-based main dish\n   b) A vegetable side dish or salad\n   c) A grain-based or starchy side dish\n   \n   For each recipe, include:\n   - Ingredient list with measurements\n   - Step-by-step preparation instructions\n   - Cooking techniques used and their purpose\n   - Food science principles applied\n   - Nutritional information per serving\n   - Presentation suggestions\n   - Potential variations or substitutions\n\n4. Write a reflection (400-500 words) discussing:\n   a) How meal planning contributes to nutrition, budgeting, and time management\n   b) Challenges in meal planning and strategies to overcome them\n   c) How understanding food science improves cooking outcomes\n   d) Adaptations for special dietary needs or preferences\n   e) Sustainable and ethical considerations in meal planning",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Culinary Arts',
                'description' => 'Develop skills in culinary techniques, food preparation, and the art of cooking.',
                'tech_category' => 'he',
                'tasks' => [
                    [
                        'name' => 'Culinary Techniques',
                        'description' => 'Understand and apply fundamental culinary techniques in food preparation.',
                        'instructions' => "Task: Demonstrate understanding of fundamental culinary techniques and their application.\n\nComplete the following:\n- Explain basic culinary techniques and their purposes\n- Analyze the science behind cooking methods\n- Demonstrate knowledge of knife skills and food preparation\n- Apply appropriate techniques to different ingredients\n- Evaluate cooking outcomes based on technique application\n\nCulinary Techniques Assignment:\n1. Create a comprehensive guide to fundamental culinary techniques that includes:\n   a) Detailed explanations of the following cooking methods:\n      - Dry heat methods (roasting, baking, grilling, broiling, sautéing, pan-frying, deep-frying)\n      - Moist heat methods (boiling, simmering, poaching, steaming, braising, stewing)\n      - Combination methods (pressure cooking, sous vide)\n   For each method, include:\n      - Definition and process\n      - Appropriate foods for this method\n      - Equipment needed\n      - Temperature guidelines\n      - Food science principles involved\n      - Advantages and limitations\n\n2. Develop a knife skills guide that covers:\n   a) Types of kitchen knives and their uses\n   b) Proper knife handling and safety\n   c) Basic cutting techniques with step-by-step instructions and illustrations:\n      - Dicing, mincing, julienne, brunoise\n      - Chiffonade, slicing, chopping\n      - Specialty cuts (supreme, tournée, etc.)\n   d) Care and maintenance of knives\n\n3. Create a food preparation techniques guide that explains:\n   a) Mise en place principles and organization\n   b) Food preparation methods for different ingredients:\n      - Meat and poultry preparation (trimming, butterflying, tenderizing, etc.)\n      - Fish and seafood preparation (scaling, filleting, deveining, etc.)\n      - Vegetable preparation (peeling, coring, blanching, etc.)\n      - Fruit preparation (supreming, zesting, segmenting, etc.)\n   c) Seasoning techniques and flavor development\n   d) Thickening methods (roux, slurry, reduction, etc.)\n\n4. Develop a practical application plan that demonstrates how you would apply these techniques:\n   a) Select three different recipes that each showcase different culinary techniques\n   b) For each recipe, provide:\n      - Complete ingredient list\n      - Step-by-step preparation instructions highlighting specific techniques\n      - Critical control points and potential challenges\n      - Evaluation criteria for successful execution\n      - Troubleshooting guide for common issues",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Baking and Pastry Fundamentals',
                        'description' => 'Understand and apply principles of baking and pastry preparation.',
                        'instructions' => "Task: Demonstrate understanding of baking and pastry fundamentals and their application.\n\nComplete the following:\n- Explain the science behind baking processes\n- Analyze ingredients and their functions in baking\n- Demonstrate knowledge of baking techniques and methods\n- Apply baking principles to create various baked goods\n- Evaluate baking outcomes and troubleshoot issues\n\nBaking and Pastry Fundamentals Assignment:\n1. Create a comprehensive guide to baking science that includes:\n   a) Detailed explanations of key baking ingredients and their functions:\n      - Flours (wheat, alternative flours, gluten development)\n      - Leavening agents (yeast, baking powder, baking soda, steam)\n      - Fats (butter, oils, shortening)\n      - Sweeteners (sugar, honey, syrups)\n      - Eggs and dairy\n      - Salt and flavorings\n   b) Chemical and physical processes in baking:\n      - Gluten formation\n      - Gelatinization of starches\n      - Caramelization and Maillard reaction\n      - Coagulation of proteins\n      - Leavening processes\n\n2. Develop a techniques guide for the following baking categories:\n   a) Quick breads (muffins, biscuits, scones):\n      - Mixing methods (muffin, biscuit, creaming)\n      - Proper handling techniques\n      - Baking temperatures and times\n   b) Yeast breads:\n      - Yeast activation and fermentation\n      - Kneading techniques\n      - Proofing and shaping\n      - Scoring and baking\n   c) Pastry doughs:\n      - Pie dough (flaky vs. mealy)\n      - Puff pastry\n      - Choux pastry\n      - Cookie doughs\n   d) Cakes:\n      - Mixing methods (creaming, foaming, two-stage)\n      - Panning and baking\n      - Basic decorating techniques\n\n3. Create detailed recipes for three different baked items that demonstrate different techniques:\n   a) A yeast bread product\n   b) A pastry item\n   c) A cake or quick bread\n   \n   For each recipe, include:\n   - Ingredient list with measurements (by weight and volume)\n   - Step-by-step preparation instructions\n   - Specific techniques used and their purpose\n   - Baking science principles applied\n   - Visual cues for doneness\n   - Troubleshooting guide for common issues\n   - Storage recommendations\n\n4. Write a reflection (400-500 words) discussing:\n   a) How understanding baking science improves outcomes\n   b) Challenges in baking and strategies to overcome them\n   c) The role of precision and measurement in baking\n   d) Adaptations for special dietary needs (gluten-free, vegan, etc.)\n   e) Creative applications of baking techniques",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Menu Development and Food Presentation',
                        'description' => 'Develop skills in menu planning, food styling, and presentation techniques.',
                        'instructions' => "Task: Demonstrate understanding of menu development principles and food presentation techniques.\n\nComplete the following:\n- Analyze factors that influence menu planning\n- Apply principles of menu engineering and design\n- Demonstrate knowledge of food styling and plating techniques\n- Develop cohesive menus for different contexts\n- Evaluate food presentation for visual appeal and practicality\n\nMenu Development and Food Presentation Assignment:\n1. Create a comprehensive guide to menu development that includes:\n   a) Menu planning principles:\n      - Target audience and market analysis\n      - Concept development and theme\n      - Nutritional considerations\n      - Seasonality and ingredient availability\n      - Cost and pricing strategies\n      - Production capabilities and constraints\n   b) Menu engineering concepts:\n      - Menu categories and organization\n      - Item placement and psychology\n      - Profitability analysis (food cost percentage, contribution margin)\n      - Menu mix analysis (popularity vs. profitability)\n   c) Menu design elements:\n      - Layout and formatting\n      - Descriptive language and naming\n      - Typography and readability\n      - Visual elements\n\n2. Develop three different menu concepts for different contexts:\n   a) A fine dining restaurant (3-course prix fixe)\n   b) A casual family restaurant (à la carte)\n   c) A special event menu (wedding, celebration, etc.)\n   \n   For each menu concept, include:\n   - Complete menu with all items and descriptions\n   - Theme or concept statement\n   - Target audience description\n   - Pricing strategy\n   - Menu layout and design (create a visual mockup)\n   - Rationale for menu organization and item selection\n\n3. Create a food presentation and plating guide that covers:\n   a) Principles of food presentation:\n      - Balance, unity, focal point\n      - Color theory and contrast\n      - Texture and height variation\n      - Portion size and plate selection\n   b) Plating techniques with illustrations:\n      - Classic plating styles\n      - Contemporary approaches\n      - Sauce applications\n      - Garnishing techniques\n   c) Food styling techniques for different courses:\n      - Appetizers and small plates\n      - Main courses\n      - Desserts\n      - Buffet presentations\n\n4. Develop detailed plating designs for three dishes from your menus:\n   a) An appetizer or starter\n   b) A main course\n   c) A dessert\n   \n   For each dish, include:\n   - Sketch or diagram of the plating design\n   - List of components and their placement\n   - Garnishing details\n   - Plating instructions step by step\n   - Equipment needed\n   - Rationale for design choices",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Home Management',
                'description' => 'Develop skills in managing household resources, spaces, and systems efficiently and effectively.',
                'tech_category' => 'he',
                'tasks' => [
                    [
                        'name' => 'Resource Management',
                        'description' => 'Understand and apply principles of managing household resources effectively.',
                        'instructions' => "Task: Demonstrate understanding of resource management principles for household applications.\n\nComplete the following:\n- Identify different types of household resources\n- Analyze strategies for effective resource allocation\n- Develop budgeting and financial management plans\n- Apply time management principles to household tasks\n- Evaluate resource management for sustainability and efficiency\n\nResource Management Assignment:\n1. Create a comprehensive household resource management guide that includes:\n   a) Types of household resources:\n      - Financial resources (income, savings, investments)\n      - Material resources (property, possessions, equipment)\n      - Human resources (time, energy, skills, knowledge)\n      - Natural resources (water, energy, materials)\n   b) Resource management principles:\n      - Planning and goal setting\n      - Prioritization and decision-making\n      - Allocation and distribution\n      - Conservation and sustainability\n      - Evaluation and adjustment\n\n2. Develop a detailed household budgeting system:\n   a) Create a comprehensive budget template with categories for:\n      - Income sources\n      - Fixed expenses (housing, utilities, insurance, etc.)\n      - Variable expenses (food, transportation, entertainment, etc.)\n      - Savings and investments\n      - Debt management\n   b) Include guidelines for:\n      - Budget creation process\n      - Tracking expenses\n      - Budget review and adjustment\n      - Emergency fund planning\n      - Long-term financial goals\n   c) Provide strategies for:\n      - Reducing expenses in different categories\n      - Increasing income opportunities\n      - Managing financial emergencies\n      - Avoiding common budgeting pitfalls\n\n3. Create a time management system for household operations:\n   a) Develop a household task inventory and classification system\n   b) Create scheduling templates for:\n      - Daily routines\n      - Weekly cleaning and maintenance\n      - Monthly tasks\n      - Seasonal activities\n   c) Provide strategies for:\n      - Task prioritization\n      - Time-saving techniques\n      - Delegation and sharing responsibilities\n      - Balancing household management with work and personal time\n   d) Include a system for tracking and evaluating time use\n\n4. Develop a sustainability plan for household resource management:\n   a) Create an assessment tool for evaluating current resource use\n   b) Provide strategies for sustainable management of:\n      - Energy consumption\n      - Water usage\n      - Food resources (reducing waste, sustainable shopping)\n      - Material goods (reducing, reusing, recycling)\n   c) Include cost-benefit analysis of sustainable practices\n   d) Develop implementation timeline and measurement metrics",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Interior Design and Space Planning',
                        'description' => 'Apply principles of interior design and space planning to create functional and aesthetic living environments.',
                        'instructions' => "Task: Demonstrate understanding of interior design principles and space planning techniques.\n\nComplete the following:\n- Explain fundamental principles of interior design\n- Analyze space planning considerations for different rooms\n- Apply design elements to create functional and aesthetic spaces\n- Develop interior design plans for different needs\n- Evaluate design solutions for functionality and appeal\n\nInterior Design and Space Planning Assignment:\n1. Create a comprehensive guide to interior design principles that includes:\n   a) Elements of design:\n      - Color (color theory, schemes, psychology)\n      - Line and shape\n      - Form and space\n      - Texture and pattern\n      - Light and lighting\n   b) Principles of design:\n      - Balance (symmetrical, asymmetrical, radial)\n      - Rhythm and movement\n      - Emphasis and focal points\n      - Proportion and scale\n      - Unity and harmony\n   c) Design styles overview:\n      - Traditional styles (Colonial, Victorian, etc.)\n      - Contemporary and modern\n      - Transitional\n      - Industrial\n      - Minimalist\n      - Other popular styles (Scandinavian, Bohemian, etc.)\n\n2. Develop a space planning guide that covers:\n   a) Space planning process:\n      - Needs assessment and functional requirements\n      - Traffic flow analysis\n      - Zoning and activity areas\n      - Furniture arrangement principles\n      - Accessibility considerations\n   b) Room-specific planning guidelines for:\n      - Living rooms\n      - Kitchens\n      - Bedrooms\n      - Bathrooms\n      - Home offices\n      - Multi-purpose spaces\n   c) Space planning tools and techniques:\n      - Measuring and creating floor plans\n      - Furniture templates and space planning tools\n      - Visualization techniques\n\n3. Create detailed design plans for two different spaces:\n   a) A living room design:\n      - Floor plan with dimensions and furniture layout\n      - Color scheme with samples\n      - Furniture selections with specifications\n      - Lighting plan\n      - Accessories and décor recommendations\n      - Material and finish selections\n   b) A kitchen or bathroom design:\n      - Floor plan with dimensions and fixture layout\n      - Elevation drawings showing cabinetry and fixtures\n      - Material and finish selections\n      - Lighting plan\n      - Storage solutions\n      - Functional zone analysis\n\n4. Develop a design project for a specific client scenario:\n   a) Create a client profile with specific needs (e.g., family with young children, elderly couple, person with mobility limitations)\n   b) Identify design challenges and constraints\n   c) Develop a complete design solution including:\n      - Concept statement and inspiration\n      - Space planning and layout\n      - Color and material selections\n      - Furniture and fixture recommendations\n      - Budget considerations\n      - Implementation timeline\n   d) Include a rationale for how your design addresses the client's specific needs",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Household Systems and Maintenance',
                        'description' => 'Understand and manage household systems, equipment, and maintenance procedures.',
                        'instructions' => "Task: Demonstrate understanding of household systems and maintenance procedures.\n\nComplete the following:\n- Identify major household systems and their functions\n- Analyze maintenance requirements for home equipment and systems\n- Develop maintenance schedules and procedures\n- Apply troubleshooting techniques for common household issues\n- Evaluate home safety and security measures\n\nHousehold Systems and Maintenance Assignment:\n1. Create a comprehensive guide to household systems that includes:\n   a) Detailed explanations of major household systems:\n      - Electrical systems (service panels, circuits, outlets, lighting)\n      - Plumbing systems (supply lines, drainage, fixtures)\n      - HVAC systems (heating, ventilation, air conditioning)\n      - Appliance systems (kitchen, laundry)\n      - Structural systems (foundation, framing, roofing)\n   b) For each system, include:\n      - Basic components and how they work\n      - Common terminology\n      - Energy efficiency considerations\n      - Signs of problems or malfunction\n      - When to DIY vs. when to call professionals\n\n2. Develop a complete home maintenance calendar and checklist system:\n   a) Create seasonal maintenance checklists for:\n      - Spring maintenance tasks\n      - Summer maintenance tasks\n      - Fall maintenance tasks\n      - Winter maintenance tasks\n   b) Develop monthly maintenance schedules\n   c) Create a system for tracking maintenance history\n   d) Include maintenance procedures for major appliances\n   e) Provide guidelines for maintenance record-keeping\n\n3. Create a troubleshooting guide for common household issues:\n   a) Electrical problems (tripped breakers, non-working outlets, flickering lights)\n   b) Plumbing issues (leaks, clogs, low water pressure)\n   c) HVAC problems (insufficient heating/cooling, strange noises, efficiency issues)\n   d) Appliance troubleshooting (refrigerator, dishwasher, washing machine, dryer)\n   e) Structural concerns (cracks, leaks, drafts)\n   For each issue, include:\n      - Potential causes\n      - Diagnostic steps\n      - Simple DIY solutions when appropriate\n      - When to call a professional\n      - Preventive measures\n\n4. Develop a comprehensive home safety and security plan:\n   a) Safety assessment checklist for:\n      - Fire safety (smoke detectors, fire extinguishers, escape plans)\n      - Electrical safety\n      - Trip and fall hazards\n      - Chemical and poisoning hazards\n      - Water safety\n   b) Security assessment and recommendations for:\n      - Door and window security\n      - Lighting\n      - Security systems and technology\n      - Landscaping for security\n      - Vacation security measures\n   c) Emergency preparedness plan including:\n      - Emergency contact information\n      - Evacuation procedures\n      - Emergency supply kit checklist\n      - Utility shutoff procedures\n      - Communication plan",
                        'points_reward' => 100,
                    ],
                ]
            ],
        ];

        // Create challenges and tasks
        foreach ($heSubjects as $subjectData) {
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
                'strand_id' => $heStrand->id,
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

        $this->command->info('HE Subjects seeded successfully!');
    }
}
