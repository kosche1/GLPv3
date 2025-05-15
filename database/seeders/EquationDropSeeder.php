<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EquationDrop;

class EquationDropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the main Equation Drop game
        $equationDrop = EquationDrop::create([
            'title' => 'Equation Drop',
            'description' => 'A fun and educational game where students drag and drop the correct answer to complete equations. Test your knowledge of physics, chemistry, and mathematics!',
            'is_active' => true,
        ]);

        // Create easy difficulty questions
        $this->createEasyQuestions($equationDrop);

        // Create medium difficulty questions
        $this->createMediumQuestions($equationDrop);

        // Create hard difficulty questions
        $this->createHardQuestions($equationDrop);
    }

    /**
     * Create easy difficulty questions
     */
    private function createEasyQuestions(EquationDrop $equationDrop): void
    {
        $easyQuestions = [
            [
                'display_elements' => [
                    ['element' => 'F'],
                    ['element' => '='],
                    ['element' => '?'],
                    ['element' => '×'],
                    ['element' => 'a'],
                ],
                'answer' => 'm',
                'hint' => "Hint: Newton's Second Law of Motion",
                'options' => [
                    ['value' => 'm', 'type' => 'Variable'],
                    ['value' => 'p', 'type' => 'Variable'],
                    ['value' => 'E', 'type' => 'Variable'],
                    ['value' => 'v', 'type' => 'Variable'],
                ],
                'points' => 100,
                'order' => 1,
            ],
            [
                'display_elements' => [
                    ['element' => 'H'],
                    ['element' => '<sub>2</sub>'],
                    ['element' => '+'],
                    ['element' => 'O'],
                    ['element' => '<sub>2</sub>'],
                    ['element' => '='],
                    ['element' => '?'],
                ],
                'answer' => 'H₂O',
                'hint' => "Hint: Water formation chemical equation",
                'options' => [
                    ['value' => 'H₂O', 'type' => 'Compound'],
                    ['value' => 'CO₂', 'type' => 'Compound'],
                    ['value' => 'O₃', 'type' => 'Compound'],
                    ['value' => 'H₂O₂', 'type' => 'Compound'],
                ],
                'points' => 120,
                'order' => 2,
            ],
            [
                'display_elements' => [
                    ['element' => 'E'],
                    ['element' => '='],
                    ['element' => 'm'],
                    ['element' => '×'],
                    ['element' => '?'],
                    ['element' => '<sup>2</sup>'],
                ],
                'answer' => 'c',
                'hint' => "Hint: Einstein's famous equation",
                'options' => [
                    ['value' => 'c', 'type' => 'Constant'],
                    ['value' => 'v', 'type' => 'Variable'],
                    ['value' => 'g', 'type' => 'Constant'],
                    ['value' => 'a', 'type' => 'Variable'],
                ],
                'points' => 150,
                'order' => 3,
            ],
        ];

        foreach ($easyQuestions as $question) {
            $equationDrop->questions()->create([
                'difficulty' => 'easy',
                'display_elements' => $question['display_elements'],
                'answer' => $question['answer'],
                'hint' => $question['hint'],
                'options' => $question['options'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }
    }

    /**
     * Create medium difficulty questions
     */
    private function createMediumQuestions(EquationDrop $equationDrop): void
    {
        $mediumQuestions = [
            [
                'display_elements' => [
                    ['element' => 'P'],
                    ['element' => '×'],
                    ['element' => 'V'],
                    ['element' => '='],
                    ['element' => 'n'],
                    ['element' => '×'],
                    ['element' => 'R'],
                    ['element' => '×'],
                    ['element' => '?'],
                ],
                'answer' => 'T',
                'hint' => "Hint: Ideal Gas Law",
                'options' => [
                    ['value' => 'T', 'type' => 'Variable'],
                    ['value' => 'P', 'type' => 'Variable'],
                    ['value' => 'm', 'type' => 'Variable'],
                    ['value' => 'V', 'type' => 'Variable'],
                ],
                'points' => 200,
                'order' => 1,
            ],
            [
                'display_elements' => [
                    ['element' => 'a'],
                    ['element' => '<sup>2</sup>'],
                    ['element' => '+'],
                    ['element' => 'b'],
                    ['element' => '<sup>2</sup>'],
                    ['element' => '='],
                    ['element' => '?'],
                ],
                'answer' => 'c²',
                'hint' => "Hint: Pythagorean theorem",
                'options' => [
                    ['value' => 'c²', 'type' => 'Expression'],
                    ['value' => 'd²', 'type' => 'Expression'],
                    ['value' => 'ab', 'type' => 'Expression'],
                    ['value' => '2ab', 'type' => 'Expression'],
                ],
                'points' => 250,
                'order' => 2,
            ],
            [
                'display_elements' => [
                    ['element' => 'F'],
                    ['element' => '='],
                    ['element' => 'G'],
                    ['element' => '×'],
                    ['element' => '('],
                    ['element' => 'm₁'],
                    ['element' => '×'],
                    ['element' => 'm₂'],
                    ['element' => ')'],
                    ['element' => '÷'],
                    ['element' => '?'],
                ],
                'answer' => 'r²',
                'hint' => "Hint: Newton's Law of Universal Gravitation",
                'options' => [
                    ['value' => 'r²', 'type' => 'Expression'],
                    ['value' => 'r', 'type' => 'Variable'],
                    ['value' => 'd²', 'type' => 'Expression'],
                    ['value' => 't²', 'type' => 'Expression'],
                ],
                'points' => 300,
                'order' => 3,
            ],
        ];

        foreach ($mediumQuestions as $question) {
            $equationDrop->questions()->create([
                'difficulty' => 'medium',
                'display_elements' => $question['display_elements'],
                'answer' => $question['answer'],
                'hint' => $question['hint'],
                'options' => $question['options'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }
    }

    /**
     * Create hard difficulty questions
     */
    private function createHardQuestions(EquationDrop $equationDrop): void
    {
        $hardQuestions = [
            [
                'display_elements' => [
                    ['element' => '∇'],
                    ['element' => '×'],
                    ['element' => 'E'],
                    ['element' => '='],
                    ['element' => '-'],
                    ['element' => '?'],
                    ['element' => '∂B'],
                    ['element' => '/'],
                    ['element' => '∂t'],
                ],
                'answer' => '∂',
                'hint' => "Hint: Maxwell's equations (Faraday's law)",
                'options' => [
                    ['value' => '∂', 'type' => 'Operator'],
                    ['value' => '∇', 'type' => 'Operator'],
                    ['value' => 'ρ', 'type' => 'Variable'],
                    ['value' => 'μ', 'type' => 'Constant'],
                ],
                'points' => 400,
                'order' => 1,
            ],
            [
                'display_elements' => [
                    ['element' => '∫'],
                    ['element' => 'f(x)'],
                    ['element' => 'dx'],
                    ['element' => '='],
                    ['element' => 'F(x)'],
                    ['element' => '+'],
                    ['element' => '?'],
                ],
                'answer' => 'C',
                'hint' => "Hint: Indefinite integral",
                'options' => [
                    ['value' => 'C', 'type' => 'Constant'],
                    ['value' => 'K', 'type' => 'Constant'],
                    ['value' => 'x', 'type' => 'Variable'],
                    ['value' => '0', 'type' => 'Number'],
                ],
                'points' => 450,
                'order' => 2,
            ],
            [
                'display_elements' => [
                    ['element' => 'e'],
                    ['element' => '<sup>i', 'π</sup>'],
                    ['element' => '+'],
                    ['element' => '1'],
                    ['element' => '='],
                    ['element' => '?'],
                ],
                'answer' => '0',
                'hint' => "Hint: Euler's identity",
                'options' => [
                    ['value' => '0', 'type' => 'Number'],
                    ['value' => 'e', 'type' => 'Constant'],
                    ['value' => 'π', 'type' => 'Constant'],
                    ['value' => 'i', 'type' => 'Number'],
                ],
                'points' => 500,
                'order' => 3,
            ],
        ];

        foreach ($hardQuestions as $question) {
            $equationDrop->questions()->create([
                'difficulty' => 'hard',
                'display_elements' => $question['display_elements'],
                'answer' => $question['answer'],
                'hint' => $question['hint'],
                'options' => $question['options'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }
    }
}
