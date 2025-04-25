<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AbmSubjectsSeeder extends Seeder
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

        // Define ABM subjects
        $abmSubjects = [
            [
                'name' => 'Business Mathematics',
                'description' => 'Develop mathematical skills and concepts applied to business and financial scenarios.',
                'tech_category' => 'abm',
                'tasks' => [
                    [
                        'name' => 'Financial Mathematics',
                        'description' => 'Apply mathematical concepts to financial calculations and analysis.',
                        'instructions' => "Task: Demonstrate understanding of financial mathematics by solving business-related problems.\n\nComplete the following:\n- Calculate simple and compound interest for various scenarios\n- Determine present and future values of investments\n- Calculate loan amortization and payment schedules\n- Analyze investment options using mathematical tools\n- Apply financial mathematics to a real-world business scenario\n\nProblems to Solve:\n1. Calculate the simple interest on a loan of $5,000 at 6% annual interest rate for 3 years.\n\n2. Calculate the compound interest and final amount if $10,000 is invested at 5% annual interest compounded quarterly for 4 years.\n\n3. Determine the present value of $20,000 to be received in 5 years, assuming an annual discount rate of 7%.\n\n4. Calculate the monthly payment for a 30-year mortgage of $250,000 with an annual interest rate of 4.5%.\n\n5. Compare two investment options:\n   - Option A: $15,000 at 6% simple interest for 5 years\n   - Option B: $15,000 at 5.5% compound interest (compounded annually) for 5 years\n   Which option yields a better return and by how much?",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Business Statistics',
                        'description' => 'Apply statistical methods to analyze business data and make informed decisions.',
                        'instructions' => "Task: Demonstrate understanding of business statistics and data analysis techniques.\n\nComplete the following:\n- Calculate and interpret measures of central tendency and dispersion for business data\n- Apply probability concepts to business scenarios\n- Perform correlation and regression analysis on business variables\n- Interpret statistical results in a business context\n- Make data-driven recommendations based on statistical analysis\n\nBusiness Statistics Problems:\n1. The following data represents the monthly sales (in thousands of dollars) for a retail store over the past year: 45, 52, 49, 53, 58, 60, 57, 61, 65, 59, 63, 68\n   a) Calculate the mean, median, and mode\n   b) Calculate the range, variance, and standard deviation\n   c) Interpret what these measures tell you about the store's sales performance\n\n2. A company is considering two locations for a new store. Based on market research:\n   - Location A has a 70% chance of high customer traffic and a 60% chance of low competition\n   - Location B has a 60% chance of high customer traffic and a 80% chance of low competition\n   Assuming these factors are independent, calculate the probability of each location having both high traffic and low competition. Which location would you recommend?\n\n3. A company has collected data on advertising expenditure (x, in thousands of dollars) and monthly sales (y, in thousands of dollars) for the past 10 months:\n   x: 5, 7, 10, 12, 14, 16, 18, 20, 22, 25\n   y: 50, 52, 60, 68, 71, 75, 78, 82, 85, 90\n   a) Calculate the correlation coefficient\n   b) Develop a linear regression equation\n   c) Predict the sales if advertising expenditure is $15,000\n   d) Interpret the business implications of your findings",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Business Forecasting',
                        'description' => 'Apply mathematical models to forecast business trends and make predictions.',
                        'instructions' => "Task: Demonstrate understanding of business forecasting techniques and their applications.\n\nComplete the following:\n- Explain different forecasting methods used in business\n- Apply time series analysis to identify trends and patterns\n- Develop forecasting models for business data\n- Evaluate the accuracy of forecasting methods\n- Make business recommendations based on forecasting results\n\nBusiness Forecasting Problems:\n1. The following data represents quarterly sales (in thousands of dollars) for a company over the past 3 years:\n   Year 1: 120, 145, 165, 130\n   Year 2: 135, 160, 180, 145\n   Year 3: 150, 175, 195, 160\n   a) Identify any trends or seasonal patterns in the data\n   b) Calculate a 4-quarter moving average\n   c) Use the trend-based forecasting method to predict sales for the next 2 quarters\n   d) Discuss the limitations of your forecast\n\n2. A retail business has collected monthly sales data for a product over the past year:\n   Jan: 45, Feb: 42, Mar: 50, Apr: 55, May: 60, Jun: 65, Jul: 70, Aug: 68, Sep: 62, Oct: 58, Nov: 65, Dec: 75\n   a) Calculate the seasonal indices for each month\n   b) Deseasonalize the data\n   c) Develop a forecast for the next 6 months, incorporating both trend and seasonality\n   d) Explain how this forecast could be used for inventory planning\n\n3. A company is considering expanding its product line. Based on market research and historical data, they've estimated the following probabilities for different sales scenarios:\n   - High sales: 30% probability, $500,000 profit\n   - Medium sales: 45% probability, $300,000 profit\n   - Low sales: 25% probability, $100,000 profit\n   a) Calculate the expected value of this business decision\n   b) If the initial investment required is $250,000, would you recommend proceeding?\n   c) Perform a sensitivity analysis by adjusting the probabilities and discuss how it affects the decision",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Fundamentals of Accountancy',
                'description' => 'Develop understanding of accounting principles, financial statements, and accounting systems.',
                'tech_category' => 'abm',
                'tasks' => [
                    [
                        'name' => 'Accounting Principles and Concepts',
                        'description' => 'Understand and apply fundamental accounting principles and concepts.',
                        'instructions' => "Task: Demonstrate understanding of fundamental accounting principles and concepts.\n\nComplete the following:\n- Explain the basic accounting equation and its components\n- Describe the principles of double-entry bookkeeping\n- Identify and explain GAAP (Generally Accepted Accounting Principles)\n- Distinguish between different types of accounts (assets, liabilities, equity, revenue, expenses)\n- Apply accounting concepts to business transactions\n\nAccounting Principles Problems:\n1. For each of the following transactions, identify the accounts affected and whether they increase or decrease. Then show how the accounting equation (Assets = Liabilities + Equity) remains balanced:\n   a) A business owner invests $50,000 cash to start a company\n   b) The company purchases equipment for $15,000 cash\n   c) The company borrows $20,000 from a bank\n   d) The company provides services to customers for $5,000 cash\n   e) The company pays $2,000 in rent expense\n\n2. Classify each of the following accounts as an Asset, Liability, Equity, Revenue, or Expense:\n   a) Accounts Receivable\n   b) Unearned Revenue\n   c) Supplies Expense\n   d) Retained Earnings\n   e) Prepaid Insurance\n   f) Notes Payable\n   g) Service Revenue\n   h) Common Stock\n   i) Equipment\n   j) Salaries Payable\n\n3. Explain how each of the following accounting principles or concepts applies to a business situation:\n   a) Revenue Recognition Principle\n   b) Matching Principle\n   c) Cost Principle\n   d) Going Concern Concept\n   e) Materiality Concept",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Financial Statements Analysis',
                        'description' => 'Prepare and analyze financial statements to evaluate business performance.',
                        'instructions' => "Task: Demonstrate ability to prepare and analyze financial statements.\n\nComplete the following:\n- Prepare an income statement, balance sheet, and cash flow statement from given data\n- Calculate and interpret key financial ratios\n- Analyze financial statements to assess business performance\n- Identify strengths and weaknesses based on financial analysis\n- Make recommendations for improving financial performance\n\nFinancial Statements Problems:\n1. Using the following information, prepare an income statement for ABC Company for the year ended December 31, 2023:\n   - Sales Revenue: $250,000\n   - Cost of Goods Sold: $150,000\n   - Operating Expenses: $50,000\n   - Interest Expense: $5,000\n   - Tax Rate: 25%\n\n2. Using the following information, prepare a balance sheet for ABC Company as of December 31, 2023:\n   - Cash: $45,000\n   - Accounts Receivable: $35,000\n   - Inventory: $60,000\n   - Property, Plant & Equipment: $200,000\n   - Accumulated Depreciation: $40,000\n   - Accounts Payable: $30,000\n   - Notes Payable: $70,000\n   - Common Stock: $100,000\n   - Retained Earnings: $100,000 (beginning balance) plus net income from problem 1\n\n3. Calculate the following financial ratios for ABC Company and interpret what they indicate about the company's financial health:\n   a) Current Ratio\n   b) Debt-to-Equity Ratio\n   c) Gross Profit Margin\n   d) Net Profit Margin\n   e) Return on Assets\n   f) Return on Equity\n\n4. Based on your analysis, identify two financial strengths and two financial weaknesses of ABC Company. Provide recommendations for addressing the weaknesses.",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Accounting Cycle',
                        'description' => 'Understand and apply the steps in the accounting cycle.',
                        'instructions' => "Task: Demonstrate understanding of the accounting cycle and its application.\n\nComplete the following:\n- Identify and explain the steps in the accounting cycle\n- Record business transactions in a journal\n- Post journal entries to ledger accounts\n- Prepare a trial balance\n- Make adjusting entries and prepare an adjusted trial balance\n- Complete the accounting cycle with closing entries\n\nAccounting Cycle Problems:\n1. List and briefly explain the eight steps of the accounting cycle in the correct order.\n\n2. Record the following transactions in a general journal for XYZ Services for the month of January 2023:\n   Jan 1: Owner invested $30,000 cash to start the business\n   Jan 5: Purchased office equipment for $8,000 cash\n   Jan 8: Paid $6,000 for three months' rent in advance\n   Jan 12: Performed services for clients and received $4,500 cash\n   Jan 15: Purchased supplies on account for $1,200\n   Jan 20: Performed services for clients on account for $3,800\n   Jan 25: Paid employee salaries of $2,200\n   Jan 28: Received $1,500 from clients on account\n   Jan 30: Paid $800 on accounts payable\n\n3. Post the journal entries from problem 2 to T-accounts and prepare a trial balance as of January 31, 2023.\n\n4. Prepare the following adjusting entries for XYZ Services as of January 31, 2023:\n   a) Supplies count shows $700 remaining from the purchase on Jan 15\n   b) Depreciation on office equipment is $100 per month\n   c) One month of the prepaid rent has expired\n   d) Accrued salaries at month-end are $500\n\n5. Prepare an adjusted trial balance after recording the adjusting entries.\n\n6. Prepare closing entries for XYZ Services and explain their purpose in the accounting cycle.",
                        'points_reward' => 100,
                    ],
                ]
            ],
            [
                'name' => 'Business Ethics',
                'description' => 'Develop understanding of ethical principles and their application in business contexts.',
                'tech_category' => 'abm',
                'tasks' => [
                    [
                        'name' => 'Ethical Frameworks in Business',
                        'description' => 'Understand and apply ethical frameworks to business decision-making.',
                        'instructions' => "Task: Demonstrate understanding of ethical frameworks and their application to business scenarios.\n\nComplete the following:\n- Explain major ethical frameworks (utilitarianism, deontology, virtue ethics, etc.)\n- Compare and contrast different ethical approaches to business decisions\n- Apply ethical frameworks to analyze business cases\n- Identify ethical dilemmas in business contexts\n- Develop ethically sound solutions to business problems\n\nEthical Frameworks Problems:\n1. Explain each of the following ethical frameworks and how they might be applied to business decision-making:\n   a) Utilitarianism\n   b) Kantian Ethics (Deontology)\n   c) Virtue Ethics\n   d) Social Contract Theory\n   e) Stakeholder Theory\n\n2. Analyze the following business scenario using three different ethical frameworks:\n   A pharmaceutical company has developed a drug that can save lives but has significant side effects. The company must decide whether to:\n   a) Delay release for further testing (potentially losing lives that could be saved now)\n   b) Release now with strong warnings (potentially causing harm to some patients)\n   c) Modify the drug to reduce side effects (increasing cost and reducing accessibility)\n   \n   For each ethical framework, explain which option would be considered most ethical and why.\n\n3. Identify the ethical dilemmas in the following business scenarios and suggest how they might be resolved:\n   a) A company discovers that its supplier is using child labor in a country where this practice is legal\n   b) A manager is pressured to manipulate financial reports to meet quarterly targets\n   c) A marketing team is considering an advertising campaign that plays on consumers' insecurities\n   d) A technology company must decide whether to comply with a government request for user data\n   e) An employee discovers that a product has a minor safety issue that management has decided not to disclose",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Corporate Social Responsibility',
                        'description' => 'Understand the principles and practices of corporate social responsibility.',
                        'instructions' => "Task: Demonstrate understanding of corporate social responsibility (CSR) and its implementation.\n\nComplete the following:\n- Define corporate social responsibility and its key components\n- Explain different models and approaches to CSR\n- Analyze the benefits and challenges of implementing CSR initiatives\n- Evaluate CSR programs of existing companies\n- Develop a CSR strategy for a hypothetical business\n\nCorporate Social Responsibility Problems:\n1. Explain the following components of CSR and provide a business example for each:\n   a) Environmental responsibility\n   b) Ethical business practices\n   c) Philanthropic initiatives\n   d) Economic responsibility\n   e) Stakeholder engagement\n\n2. Compare and contrast the following approaches to CSR:\n   a) The shareholder approach (Friedman doctrine)\n   b) The stakeholder approach\n   c) The triple bottom line approach\n   d) Strategic CSR\n   e) Shared value creation\n\n3. Research and analyze the CSR initiatives of two companies in the same industry. For each company:\n   a) Identify their key CSR programs and priorities\n   b) Evaluate the effectiveness and authenticity of their CSR efforts\n   c) Assess how their CSR activities align with their business model\n   d) Compare their approaches and determine which company has a more effective CSR strategy\n\n4. Develop a comprehensive CSR strategy for a hypothetical retail clothing company with the following characteristics:\n   - 500 employees across 50 stores nationwide\n   - Manufacturing operations outsourced to factories in Southeast Asia\n   - Target market is young adults aged 18-30\n   - Facing increasing competition and pressure to reduce costs\n   \n   Your strategy should include:\n   a) CSR vision and mission statement\n   b) Key focus areas and initiatives\n   c) Implementation plan\n   d) Stakeholder engagement approach\n   e) Measurement and reporting framework\n   f) Budget considerations and business case",
                        'points_reward' => 100,
                    ],
                    [
                        'name' => 'Ethical Leadership',
                        'description' => 'Understand the principles and practices of ethical leadership in business.',
                        'instructions' => "Task: Demonstrate understanding of ethical leadership and its impact on organizations.\n\nComplete the following:\n- Define ethical leadership and its key characteristics\n- Explain the relationship between ethical leadership and organizational culture\n- Analyze the challenges and obstacles to ethical leadership\n- Evaluate case studies of ethical and unethical leadership\n- Develop strategies for promoting ethical leadership in organizations\n\nEthical Leadership Problems:\n1. Identify and explain five key characteristics of ethical leaders, providing examples of how each characteristic might be demonstrated in a business context.\n\n2. Explain how ethical leadership influences the following aspects of an organization:\n   a) Employee morale and engagement\n   b) Organizational culture and climate\n   c) Decision-making processes\n   d) Stakeholder relationships\n   e) Long-term business performance\n\n3. Analyze the following ethical leadership challenges and propose strategies for addressing them:\n   a) Balancing profit goals with ethical considerations\n   b) Managing cross-cultural ethical differences in a global organization\n   c) Responding to pressure from shareholders for short-term results\n   d) Addressing unethical behavior by high-performing employees\n   e) Maintaining ethical standards during organizational crises or financial difficulties\n\n4. Research and analyze a case of ethical failure in leadership (e.g., Enron, Wells Fargo, Theranos). Address the following:\n   a) What were the key ethical lapses?\n   b) What leadership behaviors contributed to the ethical failure?\n   c) What organizational factors enabled or encouraged unethical behavior?\n   d) What were the consequences for various stakeholders?\n   e) What lessons can be learned about ethical leadership from this case?\n\n5. Develop a comprehensive plan for promoting ethical leadership in an organization. Your plan should include:\n   a) Leadership selection and development practices\n   b) Organizational policies and systems\n   c) Communication and transparency initiatives\n   d) Accountability mechanisms\n   e) Metrics for evaluating ethical leadership effectiveness",
                        'points_reward' => 100,
                    ],
                ]
            ],
        ];

        // Create challenges and tasks
        foreach ($abmSubjects as $subjectData) {
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

        $this->command->info('ABM Subjects seeded successfully!');
    }
}
