<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

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
                        'name' => 'Communication Basics',
                        'description' => 'Understand the fundamental concepts of communication.',
                        'instructions' => "Task: List and briefly explain the five types of communication (verbal, non-verbal, written, visual, and listening). Provide one example of each type from everyday life.\n\nInclude:\n- A short definition of each type\n- How each type is used in different situations\n- Common barriers that can affect each type of communication",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Public Speaking Elements',
                        'description' => 'Identify and understand the key elements of effective public speaking.',
                        'instructions' => "Task: Identify and explain the three main components of persuasive speaking (ethos, pathos, and logos).\n\nFor each component:\n- Define what it means\n- Explain how it helps persuade an audience\n- Give an example of how it could be used in a speech about environmental protection",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Active Listening Skills',
                        'description' => 'Learn and apply active listening techniques.',
                        'instructions' => "Task: Describe five active listening techniques and explain how they improve communication.\n\nFor each technique:\n- Explain what the technique involves\n- Describe how to practice it\n- Explain how it helps improve understanding between people\n\nThen, identify three common barriers to active listening and suggest ways to overcome them.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Reading and Writing',
                'description' => 'Enhance reading comprehension and develop effective writing skills across various genres and formats.',
                'tasks' => [
                    [
                        'name' => 'Literary Devices Identification',
                        'description' => 'Identify and explain common literary devices used in literature.',
                        'instructions' => "Task: List and explain 10 common literary devices used in literature.\n\nFor each literary device:\n- Provide a clear definition\n- Give a simple example from literature or everyday language\n- Explain how it enhances the reader's experience\n\nLiterary devices to include: metaphor, simile, personification, alliteration, hyperbole, imagery, symbolism, irony, foreshadowing, and onomatopoeia.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Essay Structure Basics',
                        'description' => 'Learn and explain the basic structure of an essay.',
                        'instructions' => "Task: Explain the basic structure of a five-paragraph essay and the purpose of each component.\n\nInclude:\n- The purpose and components of an introduction paragraph (hook, background information, thesis statement)\n- How to structure three body paragraphs (topic sentences, supporting evidence, transitions)\n- What should be included in a conclusion paragraph\n- How to create effective transitions between paragraphs\n\nProvide a simple outline example for an essay on the topic of 'The Benefits of Reading'.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Reading Comprehension Strategies',
                        'description' => 'Identify and explain effective reading comprehension strategies.',
                        'instructions' => "Task: Describe five reading comprehension strategies and explain how to apply them.\n\nFor each strategy:\n- Explain what the strategy involves\n- Describe when it is most useful\n- Provide a step-by-step guide on how to use it\n\nStrategies to include: skimming and scanning, predicting, questioning, summarizing, and visualizing. Explain how these strategies help readers better understand and remember what they read.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Komunikasyon at Pananaliksik sa Wika at Kulturang Pilipino',
                'description' => 'Develop proficiency in Filipino language communication and research skills with focus on Filipino culture and linguistics.',
                'tasks' => [
                    [
                        'name' => 'Mga Uri ng Pangungusap',
                        'description' => 'Identify and explain different types of sentences in Filipino.',
                        'instructions' => "Task: Ilista at ipaliwanag ang limang uri ng pangungusap sa Filipino ayon sa gamit.\n\nPara sa bawat uri ng pangungusap:\n- Ibigay ang kahulugan nito\n- Magbigay ng tatlong halimbawa\n- Ipaliwanag kung kailan ito ginagamit sa pang-araw-araw na komunikasyon\n\nMga uri ng pangungusap na dapat isama: pasalaysay, patanong, pautos, padamdam, at pahangang.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Mga Tradisyonal na Pagdiriwang',
                        'description' => 'Identify and describe traditional Filipino celebrations.',
                        'instructions' => "Task: Ilista at ilarawan ang limang tradisyonal na pagdiriwang sa Pilipinas.\n\nPara sa bawat pagdiriwang:\n- Ipaliwanag kung kailan ito ginagawa\n- Ilarawan ang mga karaniwang aktibidad o ritwal na kasama nito\n- Ipaliwanag ang kahalagahan nito sa kulturang Pilipino\n- Banggitin kung paano ito nagbabago sa paglipas ng panahon\n\nMaaaring isama ang mga pagdiriwang tulad ng: Pasko, Bagong Taon, Semana Santa, Pista ng Patron, at Undas.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Mga Salawikain at Kasabihan',
                        'description' => 'Identify and explain Filipino proverbs and sayings.',
                        'instructions' => "Task: Ilista at ipaliwanag ang sampung salawikain o kasabihan sa Filipino.\n\nPara sa bawat salawikain o kasabihan:\n- Isulat ang salawikain sa Filipino\n- Ibigay ang literal na kahulugan nito\n- Ipaliwanag ang mas malalim na aral o mensahe nito\n- Magbigay ng isang sitwasyon kung saan angkop gamitin ang salawikain\n\nHalimbawa ng mga salawikain: \"Ang hindi marunong lumingon sa pinanggalingan ay hindi makakarating sa paroroonan.\"",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Pagbasa at Pagsusuri ng Iba\'t Ibang Teksto Tungo sa Pananaliksik',
                'description' => 'Develop skills in reading and analyzing various Filipino texts for research purposes.',
                'tasks' => [
                    [
                        'name' => 'Mga Uri ng Teksto',
                        'description' => 'Identify and explain different types of texts in Filipino.',
                        'instructions' => "Task: Ilista at ipaliwanag ang limang uri ng teksto sa Filipino.\n\nPara sa bawat uri ng teksto:\n- Ibigay ang kahulugan nito\n- Ipaliwanag ang mga katangian nito\n- Magbigay ng dalawang halimbawa\n\nMga uri ng teksto na dapat isama: naratibo, deskriptibo, ekspositibo, argumentatibo, at teknikal.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Mga Hakbang sa Pananaliksik',
                        'description' => 'Identify and explain the steps in conducting research in Filipino.',
                        'instructions' => "Task: Ilista at ipaliwanag ang mga hakbang sa pagsasagawa ng pananaliksik sa Filipino.\n\nPara sa bawat hakbang:\n- Ipaliwanag kung ano ang ginagawa sa hakbang na ito\n- Bakit mahalaga ang hakbang na ito\n- Ano ang mga posibleng problema na maaaring makaharap sa hakbang na ito\n\nMga hakbang na dapat isama: pagpili ng paksa, pagsasagawa ng literature review, pagbuo ng research question, pagkolekta ng datos, pagsusuri ng datos, at pagsulat ng konklusyon.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Mga Mapagkukunan ng Impormasyon',
                        'description' => 'Identify and evaluate sources of information for research.',
                        'instructions' => "Task: Ilista at suriin ang limang uri ng mapagkukunan ng impormasyon para sa pananaliksik.\n\nPara sa bawat uri ng mapagkukunan:\n- Ipaliwanag kung ano ito\n- Kailan ito pinakamainam gamitin\n- Paano masusuri ang kredibilidad nito\n\nMga mapagkukunan na dapat isama: primaryang dokumento, aklat, journal articles, website, at panayam/interbyu.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => '21st Century Literature from the Philippines and the World',
                'description' => 'Explore contemporary literature from the Philippines and around the world, analyzing themes, styles, and cultural contexts.',
                'tasks' => [
                    [
                        'name' => 'Contemporary Literary Genres',
                        'description' => 'Identify and explain contemporary literary genres of the 21st century.',
                        'instructions' => "Task: List and explain five contemporary literary genres that have emerged or evolved in the 21st century.\n\nFor each genre:\n- Provide a definition and key characteristics\n- Name two representative works and their authors\n- Explain how technology or modern society has influenced this genre\n\nGenres to consider: flash fiction, graphic novels, social media poetry, climate fiction (cli-fi), and digital interactive narratives.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Filipino Authors and Works',
                        'description' => 'Identify significant Filipino authors and their contributions to 21st century literature.',
                        'instructions' => "Task: Identify five significant Filipino authors of the 21st century and their notable works.\n\nFor each author:\n- Provide brief biographical information\n- Name their most significant work and when it was published\n- Describe the main themes they explore in their writing\n- Explain their contribution to Filipino literature\n\nInclude authors from different genres such as fiction, poetry, drama, and essays.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Global Literary Movements',
                        'description' => 'Identify and explain major global literary movements of the 21st century.',
                        'instructions' => "Task: Identify and explain three major literary movements or trends in 21st century world literature.\n\nFor each movement or trend:\n- Describe its key characteristics and philosophy\n- Explain when and why it emerged\n- Name three representative authors and works from different countries\n- Discuss how it reflects contemporary global issues or concerns\n\nMovements to consider: post-postmodernism, new sincerity, autofiction, digital humanities, or transnational literature.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Contemporary Philippine Arts from the Regions',
                'description' => 'Study and appreciate diverse contemporary art forms from different regions of the Philippines.',
                'tasks' => [
                    [
                        'name' => 'Regional Art Forms',
                        'description' => 'Identify and describe traditional art forms from different Philippine regions.',
                        'instructions' => "Task: Identify and describe five traditional art forms from different regions of the Philippines.\n\nFor each art form:\n- Name the specific region it comes from\n- Describe its key characteristics and materials used\n- Explain its cultural significance and historical background\n- Discuss how it has evolved in contemporary times\n\nArt forms to consider: weaving traditions (Abel Iloko, T'nalak), pottery (Palayok), indigenous tattoo art, wood carving, and traditional music instruments.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Contemporary Filipino Artists',
                        'description' => 'Identify significant contemporary Filipino artists and their contributions.',
                        'instructions' => "Task: Identify five contemporary Filipino artists from different regions and their contributions to Philippine art.\n\nFor each artist:\n- Provide brief biographical information including their region of origin\n- Describe their primary medium and artistic style\n- Name their most notable works\n- Explain how their art reflects their regional cultural heritage\n\nInclude artists working in different mediums such as painting, sculpture, installation, digital art, or performance.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Cultural Festivals',
                        'description' => 'Identify and describe major cultural festivals in different Philippine regions.',
                        'instructions' => "Task: Identify and describe five major cultural festivals from different regions of the Philippines.\n\nFor each festival:\n- Name the region and specific location where it's celebrated\n- Explain when and why it is celebrated\n- Describe the main activities, performances, and visual elements\n- Discuss its significance in preserving and promoting regional cultural identity\n\nFestivals to consider: Sinulog Festival (Cebu), Ati-Atihan (Aklan), Pahiyas Festival (Quezon), Kadayawan Festival (Davao), and Moriones Festival (Marinduque).",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Media and Information Literacy',
                'description' => 'Develop critical thinking skills for analyzing and creating media content in the digital age.',
                'tasks' => [
                    [
                        'name' => 'Types of Media',
                        'description' => 'Identify and explain different types of media and their characteristics.',
                        'instructions' => "Task: List and explain five different types of media platforms and their key characteristics.\n\nFor each type of media:\n- Define what it is and provide examples\n- Describe its primary audience and purpose\n- Explain its advantages and limitations\n- Discuss how it has evolved with technology\n\nTypes of media to include: traditional print media, broadcast media, social media, digital news platforms, and multimedia content platforms.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Media Bias Identification',
                        'description' => 'Identify and explain different types of media bias.',
                        'instructions' => "Task: Identify and explain six common types of media bias.\n\nFor each type of bias:\n- Define what it is and how it manifests in media content\n- Provide a specific example of how it might appear in news coverage\n- Explain how it can influence audience perception\n- Suggest ways readers/viewers can identify this type of bias\n\nTypes of bias to include: political bias, selection bias, omission bias, placement bias, labeling bias, and visual bias.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Fact-Checking Methods',
                        'description' => 'Identify and explain methods for verifying information and fact-checking.',
                        'instructions' => "Task: Describe five methods or strategies for fact-checking and verifying information online.\n\nFor each method:\n- Explain the process and steps involved\n- Identify what types of claims or content it works best for\n- List reliable resources or tools that can be used with this method\n- Explain potential limitations or challenges\n\nMethods to include: source verification, reverse image search, cross-referencing information, checking publication dates/context, and using fact-checking websites.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'General Mathematics',
                'description' => 'Develop mathematical reasoning and problem-solving skills applicable to real-world situations.',
                'tasks' => [
                    [
                        'name' => 'Function Optimization Problems',
                        'description' => 'Solve real-world optimization problems using functions and calculus.',
                        'instructions' => "Solve the following real-world optimization problems. Show all your work, including equations, derivatives, and calculations.\n\nTask 1: A local coffee shop finds that their daily profit (P) in pesos is related to the number of specialty drinks (x) they sell by the function P(x) = -0.5x² + 120x - 1000. How many specialty drinks should they sell to maximize their profit? What is the maximum profit?\n\nTask 2: A rectangular garden is being designed with a perimeter of 100 meters. What dimensions (length and width) will maximize the garden's area? What is the maximum area possible?\n\nTask 3: A company manufactures smartphones at a cost of ₱8,000 per unit. Market research suggests that if they price each phone at ₱p, they will sell (20,000 - 1000p) units. What price should they set to maximize profit? What is the maximum profit?",
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Financial Mathematics',
                        'description' => 'Apply mathematics to solve financial problems involving interest, loans, and investments.',
                        'instructions' => "Solve the following financial mathematics problems. Show all your calculations and formulas used.\n\nTask 1: Juan deposits ₱50,000 in a savings account that pays 4.5% annual interest, compounded monthly. How much will be in the account after 5 years? How much of that is interest earned?\n\nTask 2: Maria wants to buy a car worth ₱850,000. The dealer offers a 5-year loan with a 7.5% annual interest rate. Calculate her monthly payment. How much total interest will she pay over the life of the loan?\n\nTask 3: Pedro wants to save for retirement and needs ₱5,000,000 in 30 years. If he can invest in a fund with an average annual return of 8%, how much should he deposit each month to reach his goal?",
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Probability and Statistics Applications',
                        'description' => 'Apply probability and statistics concepts to analyze real-world scenarios.',
                        'instructions' => "Solve the following probability and statistics problems. Show all your work and explain your reasoning.\n\nTask 1: In a survey of 200 students, 85 are taking mathematics, 65 are taking physics, and 40 are taking both. What is the probability that a randomly selected student is taking mathematics or physics? What is the probability that a student taking mathematics is also taking physics?\n\nTask 2: A quality control inspector examines a sample of 50 light bulbs from a production line and finds 3 defective bulbs. Calculate the 95% confidence interval for the proportion of defective bulbs in the entire production. What sample size would be needed to reduce the margin of error to 2%?\n\nTask 3: The heights of adult women in a certain population are normally distributed with a mean of 162 cm and a standard deviation of 6.5 cm. What percentage of women are taller than 170 cm? If you randomly select 10 women, what is the probability that their average height exceeds 165 cm?",
                        'points_reward' => 120,
                    ],
                ]
            ],
            [
                'name' => 'Statistics and Probability',
                'description' => 'Learn to collect, analyze, and interpret data using statistical methods and probability theory.',
                'tasks' => [
                    [
                        'name' => 'Descriptive Statistics Analysis',
                        'description' => 'Analyze a real dataset using descriptive statistics methods.',
                        'instructions' => "Analyze the provided dataset of student test scores across three subjects (Math, Science, and English) for 50 students. Complete the following tasks:\n\nTask 1: Calculate the mean, median, mode, range, variance, and standard deviation for each subject. Which subject has the highest variability in scores?\n\nTask 2: Create appropriate visualizations (histogram, box plot, scatter plot) to represent the data distribution for each subject. What patterns or outliers do you observe?\n\nTask 3: Calculate the correlation coefficient between Math and Science scores, Math and English scores, and Science and English scores. Interpret these correlations and explain what they suggest about the relationships between performance in different subjects.",
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Probability Applications',
                        'description' => 'Apply probability concepts to solve real-world problems.',
                        'instructions' => "Solve the following probability problems. Show all your work and explain your reasoning.\n\nTask 1: A manufacturing company produces electronic components with a 3% defect rate. If 20 components are randomly selected for quality control inspection, what is the probability that exactly 2 are defective? What is the probability that at least one is defective?\n\nTask 2: In a certain hospital, 45% of patients have blood type O, 40% have blood type A, 11% have blood type B, and 4% have blood type AB. If a patient needs a blood transfusion, the probability of finding a compatible donor is 100% for type O recipients, 74% for type A, 70% for type B, and 43% for type AB. What is the probability that a randomly selected patient will be able to receive blood from a randomly selected donor?\n\nTask 3: A diagnostic test for a disease has a sensitivity of 92% (probability of a positive test given the disease is present) and a specificity of 95% (probability of a negative test given the disease is absent). If the prevalence of the disease in the population is 2%, what is the probability that a person who tests positive actually has the disease?",
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Statistical Inference',
                        'description' => 'Apply statistical inference techniques to make data-driven decisions.',
                        'instructions' => "Complete the following statistical inference tasks. Show all calculations and explain your conclusions.\n\nTask 1: A company claims that its new energy drink increases alertness by at least 30%. In a study, 40 participants showed an average increase of 32% with a standard deviation of 8%. Using a significance level of 0.05, test the company's claim. What is your conclusion?\n\nTask 2: A researcher wants to compare the effectiveness of two different teaching methods. Method A was used with 35 students who scored an average of 78 with a standard deviation of 12. Method B was used with 40 students who scored an average of 82 with a standard deviation of 10. Is there a significant difference between the two methods at a 0.05 significance level?\n\nTask 3: A quality control manager wants to estimate the mean lifetime of light bulbs produced by the factory. A sample of 36 bulbs has a mean lifetime of 1,200 hours with a standard deviation of 150 hours. Calculate the 95% confidence interval for the mean lifetime of all bulbs produced. How would the confidence interval change if the sample size was increased to 100 bulbs?",
                        'points_reward' => 120,
                    ],
                ]
            ],
            [
                'name' => 'Earth and Life Science',
                'description' => 'Study the interconnected systems of Earth and the diversity of life forms that inhabit it.',
                'tasks' => [
                    [
                        'name' => 'Ecosystem Energy Flow Analysis',
                        'description' => 'Analyze energy flow and nutrient cycling in a specific ecosystem.',
                        'instructions' => "Complete the following tasks related to ecosystem energy flow and nutrient cycling:\n\nTask 1: A tropical rainforest receives approximately 2,000 calories of solar energy per square centimeter per year. If plants convert about 1% of this energy into biomass through photosynthesis, calculate how much energy is available to primary consumers per square meter. If primary consumers are approximately 10% efficient at converting plant energy to biomass, how much energy is available to secondary consumers?\n\nTask 2: Examine the provided food web diagram of a coral reef ecosystem. Identify all trophic levels, and explain what would happen to the population sizes of at least three different organisms if the shark population declined by 80%. Support your answer with ecological principles.\n\nTask 3: The carbon cycle is being disrupted by human activities. Calculate the carbon footprint of the following scenario: A family of four drives a car that gets 12 km/L for 20,000 km per year (2.3 kg CO2 per liter of gasoline), uses 6,000 kWh of electricity annually (0.5 kg CO2 per kWh), and takes one round-trip flight of 8,000 km total (0.2 kg CO2 per passenger-km). What steps could this family take to reduce their carbon footprint by at least 25%?",
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Geological Processes and Natural Disasters',
                        'description' => 'Analyze geological processes and their relationship to natural disasters.',
                        'instructions' => "Complete the following tasks related to geological processes and natural disasters:\n\nTask 1: The Pacific Ring of Fire experiences approximately 90% of the world's earthquakes. Explain the plate tectonic processes that create this zone of high seismic activity. Then, analyze the data provided for three major earthquakes (magnitude, depth, distance from populated areas) and calculate the potential tsunami wave heights that could result using the formula: h = 0.2 × 10^(0.5M-D/1000), where h is wave height in meters, M is magnitude, and D is distance in kilometers.\n\nTask 2: Volcanic eruptions can be classified by their explosivity index (VEI). Compare the three volcanic eruptions in the provided data table (including VEI, ash column height, volume of ejected material). Calculate the area that would be covered by a 10 cm thick ash layer for each eruption. What factors determine how dangerous an eruption is to nearby populations?\n\nTask 3: Examine the provided topographic map of a coastal region. Identify areas at risk of flooding if sea levels rise by 0.5 meters, 1 meter, and 2 meters. Calculate the percentage of urban area that would be flooded in each scenario. What geological features make some coastal areas more vulnerable to sea level rise than others?",
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Biodiversity and Conservation',
                        'description' => 'Analyze biodiversity patterns and conservation strategies.',
                        'instructions' => "Complete the following tasks related to biodiversity and conservation:\n\nTask 1: The island of Madagascar has approximately 250,000 species, of which about 70% are endemic (found nowhere else). If the current deforestation rate is 1.5% per year and continues unchanged, calculate how many endemic species might be lost in the next 20 years, assuming a direct relationship between habitat loss and species extinction. What conservation strategies would be most effective in this situation?\n\nTask 2: A population of endangered tigers has 120 individuals remaining in a protected area. Genetic analysis shows the population has an effective population size of only 40 breeding individuals. Using the formula for genetic diversity loss per generation (1/(2Ne), where Ne is effective population size), calculate how much genetic diversity is lost each generation. If tigers reproduce every 3-4 years, how long will it take for the population to lose 25% of its genetic diversity? What management strategies could help preserve genetic diversity?\n\nTask 3: Analyze the provided data on three different conservation approaches (strict protection, sustainable use, and restoration) applied to similar forest ecosystems. The data includes costs per hectare, species recovery rates, and community economic benefits. Calculate the cost-effectiveness of each approach in terms of species preserved per dollar invested. Which approach would you recommend for a region with high biodiversity, high poverty rates, and limited conservation funding? Justify your answer.",
                        'points_reward' => 120,
                    ],
                ]
            ],
            [
                'name' => 'Physical Science',
                'description' => 'Explore the fundamental principles of physics and chemistry that govern the natural world.',
                'tasks' => [
                    [
                        'name' => 'Mechanics and Motion',
                        'description' => 'Apply principles of mechanics to solve real-world physics problems.',
                        'instructions' => "Solve the following physics problems related to mechanics and motion. Show all your work, including formulas, calculations, and units.\n\nTask 1: A roller coaster car (mass 500 kg with passengers) starts from rest at a height of 45 meters. Calculate its speed at the bottom of the first drop (height = 5 meters), assuming no friction. If the actual measured speed at the bottom is 25 m/s, calculate the energy lost to friction and determine the coefficient of friction. (Use g = 9.8 m/s²)\n\nTask 2: A 2000 kg car traveling at 15 m/s applies its brakes and comes to a complete stop in 8 seconds. Calculate the braking force applied and the distance traveled during braking. If the same car needs to stop in half the distance, how much more braking force would be required?\n\nTask 3: A projectile is launched from ground level with an initial velocity of 50 m/s at an angle of 30° above the horizontal. Calculate the maximum height reached, the total time in the air, and the horizontal distance traveled before hitting the ground. How would these values change if the launch angle was 45° instead? (Use g = 9.8 m/s²)",
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Chemical Reactions and Stoichiometry',
                        'description' => 'Analyze chemical reactions and perform stoichiometric calculations.',
                        'instructions' => "Complete the following tasks related to chemical reactions and stoichiometry. Show all your work, including balanced equations and calculations.\n\nTask 1: Balance the following chemical equations:\na) ___ Fe + ___ O₂ → ___ Fe₂O₃\nb) ___ C₃H₈ + ___ O₂ → ___ CO₂ + ___ H₂O\nc) ___ Al + ___ CuSO₄ → ___ Al₂(SO₄)₃ + ___ Cu\n\nTask 2: When 25.0 g of calcium carbonate (CaCO₃) reacts with excess hydrochloric acid according to the reaction: CaCO₃ + 2 HCl → CaCl₂ + H₂O + CO₂, what mass of carbon dioxide is produced? If the actual yield in an experiment was 9.2 g of CO₂, calculate the percent yield of the reaction.\n\nTask 3: A buffer solution is prepared by mixing 125 mL of 0.20 M acetic acid (CH₃COOH) with 75 mL of 0.15 M sodium acetate (CH₃COONa). Calculate the pH of this buffer solution. (Ka of acetic acid = 1.8 × 10⁻⁵)",
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Electricity and Magnetism',
                        'description' => 'Apply principles of electricity and magnetism to solve practical problems.',
                        'instructions' => "Solve the following problems related to electricity and magnetism. Show all your work, including formulas, calculations, and units.\n\nTask 1: A circuit contains a 12 V battery connected to three resistors in series: 4 Ω, 6 Ω, and 10 Ω. Calculate the current flowing through the circuit and the voltage drop across each resistor. If the resistors were connected in parallel instead, what would be the total current drawn from the battery?\n\nTask 2: A rectangular coil with 200 turns, dimensions 5 cm × 8 cm, is placed in a magnetic field of 0.3 T. If the coil is rotated from a position where its plane is parallel to the field to one where it is perpendicular to the field in 0.1 seconds, calculate the average induced EMF in the coil. What current would flow if the coil has a resistance of 2 Ω?\n\nTask 3: A household uses the following electrical appliances daily: refrigerator (150 W for 24 hours), five LED light bulbs (10 W each for 6 hours), television (80 W for 4 hours), computer (120 W for 8 hours), and air conditioner (1200 W for 6 hours). Calculate the total daily energy consumption in kilowatt-hours and the monthly electricity cost if electricity costs ₱12 per kWh.",
                        'points_reward' => 120,
                    ],
                ]
            ],
            [
                'name' => 'Introduction to the Philosophy of the Human Person',
                'description' => 'Explore philosophical questions about human existence, consciousness, ethics, and the meaning of life.',
                'tasks' => [
                    [
                        'name' => 'Free Will vs. Determinism Analysis',
                        'description' => 'Analyze the philosophical debate between free will and determinism.',
                        'instructions' => "Complete the following tasks related to the philosophical debate between free will and determinism:\n\nTask 1: Consider this real-world scenario: A person with a history of childhood abuse commits a violent crime. Some argue they should receive a reduced sentence due to their past trauma affecting their development and choices. Others argue they still made a conscious choice and should be fully responsible. Analyze this scenario from both determinist and libertarian free will perspectives. Which position do you find more convincing and why?\n\nTask 2: Compare and contrast the views on free will of two philosophers: John Locke (compatibilist) and Baron d'Holbach (hard determinist). Explain how each would respond to modern neuroscientific findings suggesting that our brains make decisions before we become consciously aware of them (e.g., Libet's experiments). Which philosopher's view better accommodates these findings?\n\nTask 3: Imagine you are designing a society from scratch. Would your legal and educational systems be based more on determinist or free will assumptions? Explain how your philosophical position would influence specific policies on criminal justice, education, and social welfare. What practical problems might arise from your approach?",
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Ethical Frameworks Application',
                        'description' => 'Apply different ethical frameworks to real-world moral dilemmas.',
                        'instructions' => "Complete the following tasks applying different ethical frameworks to real-world moral dilemmas:\n\nTask 1: A new medical treatment could save 1,000 lives but costs $10 million to implement, meaning other healthcare programs would lose funding. Analyze this dilemma using utilitarian ethics (consequentialist) and Kantian ethics (deontological). Calculate the potential outcomes in terms of lives affected and explain which approach you find more convincing for this specific case.\n\nTask 2: During a pandemic, should governments mandate vaccines or prioritize individual liberty? Analyze this question using John Stuart Mill's harm principle and Aristotle's virtue ethics. Identify the key virtues at stake and explain how each framework balances individual rights with community welfare. Which approach would lead to better real-world outcomes?\n\nTask 3: A self-driving car must decide whether to swerve to avoid hitting five pedestrians, knowing the swerve would kill its single passenger. Using the ethical frameworks of care ethics and social contract theory, analyze how the car should be programmed. What specific decision-making algorithm would you implement based on your ethical reasoning?",
                        'points_reward' => 120,
                    ],
                    [
                        'name' => 'Mind-Body Problem Investigation',
                        'description' => 'Investigate the philosophical mind-body problem and its implications.',
                        'instructions' => "Complete the following tasks related to the mind-body problem in philosophy:\n\nTask 1: A patient has severe brain damage but shows some signs of consciousness. The family must decide whether to continue life support. How would a dualist (like Descartes) and a physicalist (like Patricia Churchland) approach this situation differently? Which position provides better guidance for this real-world ethical dilemma?\n\nTask 2: Artificial Intelligence systems now display behaviors that mimic human intelligence. Could an AI system ever be conscious according to functionalist theories of mind? Analyze this question by comparing John Searle's Chinese Room argument with Daniel Dennett's multiple drafts theory of consciousness. Which theory better explains the possibility of machine consciousness?\n\nTask 3: Recent studies show meditation practices can physically change brain structure and function. Analyze how these findings relate to the mind-body problem. Do they support monism, dualism, or another position? Develop a philosophical position that best accounts for both subjective experience and scientific evidence about the brain-mind relationship.",
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
                'difficulty_level' => 'beginner',
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
