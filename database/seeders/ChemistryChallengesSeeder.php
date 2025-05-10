<?php

namespace Database\Seeders;

use App\Models\ChemistryChallenge;
use Illuminate\Database\Seeder;

class ChemistryChallengesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $challenges = [
            [
                'title' => 'Acid-Base Neutralization',
                'description' => 'Learn about acid-base reactions by neutralizing hydrochloric acid with sodium hydroxide using a pH indicator.',
                'difficulty_level' => 'beginner',
                'points_reward' => 100,
                'is_active' => true,
                'time_limit' => 15,
                'instructions' => "1. Add 10ml of hydrochloric acid to a beaker\n2. Add 2-3 drops of phenolphthalein indicator\n3. Slowly add sodium hydroxide solution until the solution turns pink\n4. Record your observations",
                'challenge_data' => json_encode([
                    'chemicals' => [
                        [
                            'id' => 'hcl',
                            'name' => 'Hydrochloric Acid',
                            'symbol' => 'HCl',
                            'color' => 'yellow'
                        ],
                        [
                            'id' => 'naoh',
                            'name' => 'Sodium Hydroxide',
                            'symbol' => 'NaOH',
                            'color' => 'purple'
                        ],
                        [
                            'id' => 'phenolphthalein',
                            'name' => 'Phenolphthalein',
                            'symbol' => 'Ph',
                            'color' => 'pink'
                        ],
                        [
                            'id' => 'water',
                            'name' => 'Water',
                            'symbol' => 'H₂O',
                            'color' => 'blue'
                        ]
                    ],
                    'equipment' => [
                        [
                            'id' => 'beaker',
                            'name' => 'Beaker',
                            'svg_path' => '<path d="M7 3H17V7C17 7 17 13 12 13C7 13 7 7 7 7V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 21H19V19C19 17 17 15 12 15C7 15 5 17 5 19V21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>'
                        ],
                        [
                            'id' => 'pipette',
                            'name' => 'Pipette',
                            'svg_path' => '<path d="M12 3V7M12 21V17M12 7V17M8 7H16M9 21H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>'
                        ],
                        [
                            'id' => 'stirring-rod',
                            'name' => 'Stirring Rod',
                            'svg_path' => '<path d="M12 3V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>'
                        ]
                    ],
                    'expected_reaction' => [
                        'type' => 'neutralization',
                        'equation' => 'HCl + NaOH → NaCl + H2O',
                        'color_change' => 'clear to pink',
                        'ph_change' => 'acidic to neutral'
                    ]
                ]),
                'expected_result' => json_encode([
                    'final_solution' => 'neutral',
                    'color' => 'pink',
                    'products' => ['NaCl', 'H2O']
                ]),
                'hints' => json_encode([
                    'Phenolphthalein turns pink in basic solutions.',
                    'Add the sodium hydroxide slowly to avoid overshooting the neutralization point.',
                    'The reaction produces sodium chloride (table salt) and water.'
                ])
            ],
            [
                'title' => 'Precipitation Reaction',
                'description' => 'Observe a precipitation reaction between silver nitrate and sodium chloride to form silver chloride.',
                'difficulty_level' => 'beginner',
                'points_reward' => 100,
                'is_active' => true,
                'time_limit' => 15,
                'instructions' => "1. Add 5ml of silver nitrate solution to a test tube\n2. Add 5ml of sodium chloride solution\n3. Observe the formation of a white precipitate\n4. Record your observations",
                'challenge_data' => json_encode([
                    'chemicals' => [
                        [
                            'id' => 'agno3',
                            'name' => 'Silver Nitrate',
                            'symbol' => 'AgNO₃',
                            'color' => 'gray'
                        ],
                        [
                            'id' => 'nacl',
                            'name' => 'Sodium Chloride',
                            'symbol' => 'NaCl',
                            'color' => 'blue'
                        ],
                        [
                            'id' => 'water',
                            'name' => 'Water',
                            'symbol' => 'H₂O',
                            'color' => 'blue'
                        ]
                    ],
                    'equipment' => [
                        [
                            'id' => 'test-tube',
                            'name' => 'Test Tube',
                            'svg_path' => '<path d="M9 3H15V8C15 8 15 16 12 16C9 16 9 8 9 8V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 21H17V19C17 18 15 17 12 17C9 17 7 18 7 19V21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>'
                        ],
                        [
                            'id' => 'pipette',
                            'name' => 'Pipette',
                            'svg_path' => '<path d="M12 3V7M12 21V17M12 7V17M8 7H16M9 21H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>'
                        ],
                        [
                            'id' => 'test-tube-rack',
                            'name' => 'Test Tube Rack',
                            'svg_path' => '<path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>'
                        ]
                    ],
                    'expected_reaction' => [
                        'type' => 'precipitation',
                        'equation' => 'AgNO₃ + NaCl → AgCl↓ + NaNO₃',
                        'precipitate' => 'white solid (AgCl)'
                    ]
                ]),
                'expected_result' => json_encode([
                    'precipitate' => 'AgCl',
                    'color' => 'white',
                    'soluble_products' => ['NaNO₃']
                ]),
                'hints' => json_encode([
                    'Silver chloride is insoluble in water and forms a white precipitate.',
                    'The reaction follows the double displacement pattern.',
                    'The sodium nitrate remains dissolved in the solution.'
                ])
            ],
            [
                'title' => 'Endothermic vs. Exothermic Reactions',
                'description' => 'Compare endothermic and exothermic reactions by dissolving different salts in water and measuring temperature changes.',
                'difficulty_level' => 'intermediate',
                'points_reward' => 150,
                'is_active' => true,
                'time_limit' => 20,
                'instructions' => "1. Add 50ml of water to two separate beakers\n2. Measure and record the initial temperature of both\n3. Add ammonium nitrate to one beaker and calcium chloride to the other\n4. Stir both solutions and record temperature changes\n5. Identify which reaction is endothermic and which is exothermic",
                'challenge_data' => json_encode([
                    'chemicals' => [
                        [
                            'id' => 'nh4no3',
                            'name' => 'Ammonium Nitrate',
                            'symbol' => 'NH₄NO₃',
                            'color' => 'white'
                        ],
                        [
                            'id' => 'cacl2',
                            'name' => 'Calcium Chloride',
                            'symbol' => 'CaCl₂',
                            'color' => 'orange'
                        ],
                        [
                            'id' => 'water',
                            'name' => 'Water',
                            'symbol' => 'H₂O',
                            'color' => 'blue'
                        ]
                    ],
                    'equipment' => [
                        [
                            'id' => 'beaker',
                            'name' => 'Beaker',
                            'svg_path' => '<path d="M7 3H17V7C17 7 17 13 12 13C7 13 7 7 7 7V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 21H19V19C19 17 17 15 12 15C7 15 5 17 5 19V21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>'
                        ],
                        [
                            'id' => 'thermometer',
                            'name' => 'Thermometer',
                            'svg_path' => '<path d="M12 3V14M12 14C10.3431 14 9 15.3431 9 17C9 18.6569 10.3431 20 12 20C13.6569 20 15 18.6569 15 17C15 15.3431 13.6569 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>'
                        ],
                        [
                            'id' => 'stirring-rod',
                            'name' => 'Stirring Rod',
                            'svg_path' => '<path d="M12 3V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>'
                        ]
                    ],
                    'expected_reactions' => [
                        [
                            'type' => 'endothermic',
                            'chemical' => 'NH₄NO₃',
                            'temperature_change' => 'decrease',
                            'equation' => 'NH₄NO₃ + H₂O → NH₄⁺ + NO₃⁻ + Heat absorption'
                        ],
                        [
                            'type' => 'exothermic',
                            'chemical' => 'CaCl₂',
                            'temperature_change' => 'increase',
                            'equation' => 'CaCl₂ + H₂O → Ca²⁺ + 2Cl⁻ + Heat release'
                        ]
                    ]
                ]),
                'expected_result' => json_encode([
                    'nh4no3_reaction' => 'endothermic',
                    'cacl2_reaction' => 'exothermic',
                    'temperature_changes' => [
                        'nh4no3' => 'decrease',
                        'cacl2' => 'increase'
                    ]
                ]),
                'hints' => json_encode([
                    'Endothermic reactions absorb heat from the surroundings, causing a temperature decrease.',
                    'Exothermic reactions release heat to the surroundings, causing a temperature increase.',
                    'The temperature changes are due to the energy required to break or form bonds during dissolution.'
                ])
            ]
        ];

        foreach ($challenges as $challenge) {
            ChemistryChallenge::create($challenge);
        }

        $this->command->info('Chemistry challenges seeded successfully!');
    }
}
