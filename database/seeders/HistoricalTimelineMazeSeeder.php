<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HistoricalTimelineMaze;

class HistoricalTimelineMazeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the main Historical Timeline Maze game
        $historicalTimelineMaze = HistoricalTimelineMaze::create([
            'title' => 'Historical Timeline Maze',
            'description' => 'A fun and educational game where students navigate through historical events by placing them in chronological order. Test your knowledge of world history across different eras!',
            'is_active' => true,
        ]);

        // Create questions for each era and difficulty
        $this->createAncientQuestions($historicalTimelineMaze);
        $this->createMedievalQuestions($historicalTimelineMaze);
        $this->createRenaissanceQuestions($historicalTimelineMaze);
        $this->createModernQuestions($historicalTimelineMaze);
        $this->createContemporaryQuestions($historicalTimelineMaze);
    }

    /**
     * Create ancient history questions
     */
    private function createAncientQuestions(HistoricalTimelineMaze $historicalTimelineMaze): void
    {
        // Easy difficulty questions
        $easyQuestions = [
            [
                'question' => "Which of these events happened first in ancient history?",
                'options' => [
                    ['id' => 1, 'title' => 'Building of the Great Pyramid of Giza', 'year' => '2560 BCE', 'correct' => true],
                    ['id' => 2, 'title' => 'Code of Hammurabi', 'year' => '1754 BCE', 'correct' => false],
                    ['id' => 3, 'title' => 'Founding of the Roman Republic', 'year' => '509 BCE', 'correct' => false]
                ],
                'hint' => 'The Great Pyramid was built during the Old Kingdom period of Ancient Egypt.',
                'points' => 100,
                'order' => 1,
            ],
            [
                'question' => "Which ancient civilization development came next?",
                'options' => [
                    ['id' => 1, 'title' => 'Code of Hammurabi', 'year' => '1754 BCE', 'correct' => true],
                    ['id' => 2, 'title' => 'Trojan War', 'year' => '1200 BCE', 'correct' => false],
                    ['id' => 3, 'title' => 'First Olympic Games', 'year' => '776 BCE', 'correct' => false]
                ],
                'hint' => 'The Code of Hammurabi was one of the earliest written legal codes.',
                'points' => 100,
                'order' => 2,
            ],
            [
                'question' => "Which of these events occurred last in the ancient world?",
                'options' => [
                    ['id' => 1, 'title' => 'Birth of Jesus Christ', 'year' => '~4 BCE', 'correct' => true],
                    ['id' => 2, 'title' => 'Founding of the Roman Republic', 'year' => '509 BCE', 'correct' => false],
                    ['id' => 3, 'title' => 'Birth of Democracy in Athens', 'year' => '508 BCE', 'correct' => false]
                ],
                'hint' => 'This event marks the transition to the Common Era in the Western calendar.',
                'points' => 100,
                'order' => 3,
            ],
        ];

        // Medium difficulty questions
        $mediumQuestions = [
            [
                'question' => "Place these ancient events in chronological order. Which came first?",
                'options' => [
                    ['id' => 1, 'title' => 'Construction of the Great Wall of China', 'year' => '700-214 BCE', 'correct' => true],
                    ['id' => 2, 'title' => 'Alexander the Great conquers Persia', 'year' => '330 BCE', 'correct' => false],
                    ['id' => 3, 'title' => 'Julius Caesar becomes dictator of Rome', 'year' => '49 BCE', 'correct' => false]
                ],
                'hint' => 'The Great Wall was built over many centuries, with early sections dating back to the 7th century BCE.',
                'points' => 200,
                'order' => 1,
            ],
            [
                'question' => "Which of these ancient inventions was developed first?",
                'options' => [
                    ['id' => 1, 'title' => 'Invention of Paper in China', 'year' => '105 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'First use of concrete by Romans', 'year' => '300 BCE', 'correct' => false],
                    ['id' => 3, 'title' => 'Development of the Compass', 'year' => '200 CE', 'correct' => false]
                ],
                'hint' => 'Paper was invented by Cai Lun during the Han Dynasty.',
                'points' => 200,
                'order' => 2,
            ],
            [
                'question' => "Which ancient empire reached its peak first?",
                'options' => [
                    ['id' => 1, 'title' => 'Persian Empire under Darius I', 'year' => '522-486 BCE', 'correct' => true],
                    ['id' => 2, 'title' => 'Roman Empire under Augustus', 'year' => '27 BCE-14 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Han Dynasty in China', 'year' => '206 BCE-220 CE', 'correct' => false]
                ],
                'hint' => 'The Persian Empire was the largest empire in history at its time.',
                'points' => 200,
                'order' => 3,
            ],
        ];

        // Hard difficulty questions
        $hardQuestions = [
            [
                'question' => "Which of these lesser-known ancient events occurred first?",
                'options' => [
                    ['id' => 1, 'title' => 'Ashoka the Great converts to Buddhism', 'year' => '263 BCE', 'correct' => true],
                    ['id' => 2, 'title' => 'The Silk Road trade route established', 'year' => '130 BCE', 'correct' => false],
                    ['id' => 3, 'title' => 'Ptolemy creates his world map', 'year' => '150 CE', 'correct' => false]
                ],
                'hint' => 'Ashoka ruled the Mauryan Empire in India and converted after witnessing the devastation of the Kalinga War.',
                'points' => 300,
                'order' => 1,
            ],
            [
                'question' => "Arrange these ancient battles chronologically. Which happened first?",
                'options' => [
                    ['id' => 1, 'title' => 'Battle of Marathon', 'year' => '490 BCE', 'correct' => true],
                    ['id' => 2, 'title' => 'Battle of Thermopylae', 'year' => '480 BCE', 'correct' => false],
                    ['id' => 3, 'title' => 'Battle of Gaugamela', 'year' => '331 BCE', 'correct' => false]
                ],
                'hint' => 'The Battle of Marathon was fought during the first Persian invasion of Greece.',
                'points' => 300,
                'order' => 2,
            ],
            [
                'question' => "Which of these ancient scientific achievements came first?",
                'options' => [
                    ['id' => 1, 'title' => 'Eratosthenes measures Earth\'s circumference', 'year' => '240 BCE', 'correct' => true],
                    ['id' => 2, 'title' => 'Archimedes\' principle of buoyancy', 'year' => '212 BCE', 'correct' => false],
                    ['id' => 3, 'title' => 'Hipparchus creates trigonometry', 'year' => '150 BCE', 'correct' => false]
                ],
                'hint' => 'Eratosthenes calculated the Earth\'s circumference with remarkable accuracy using shadows and geometry.',
                'points' => 300,
                'order' => 3,
            ],
        ];

        // Create easy questions
        foreach ($easyQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'ancient',
                'difficulty' => 'easy',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }

        // Create medium questions
        foreach ($mediumQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'ancient',
                'difficulty' => 'medium',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }

        // Create hard questions
        foreach ($hardQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'ancient',
                'difficulty' => 'hard',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }
    }
    /**
     * Create medieval period questions
     */
    private function createMedievalQuestions(HistoricalTimelineMaze $historicalTimelineMaze): void
    {
        // Easy difficulty questions
        $easyQuestions = [
            [
                'question' => "Which event marked the beginning of the Medieval period?",
                'options' => [
                    ['id' => 1, 'title' => 'Fall of the Western Roman Empire', 'year' => '476 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Crowning of Charlemagne', 'year' => '800 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Beginning of the First Crusade', 'year' => '1096 CE', 'correct' => false]
                ],
                'hint' => 'This event is traditionally used to mark the end of Ancient history and the beginning of the Middle Ages.',
                'points' => 100,
                'order' => 1,
            ],
            [
                'question' => "Which medieval development came next?",
                'options' => [
                    ['id' => 1, 'title' => 'Magna Carta Signed', 'year' => '1215 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Black Death Pandemic', 'year' => '1347 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Hundred Years\' War Begins', 'year' => '1337 CE', 'correct' => false]
                ],
                'hint' => 'This document limited the power of the English monarchy and is considered a cornerstone of constitutional governance.',
                'points' => 100,
                'order' => 2,
            ],
            [
                'question' => "Which event signaled the end of the Medieval period?",
                'options' => [
                    ['id' => 1, 'title' => 'Fall of Constantinople', 'year' => '1453 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Columbus reaches the Americas', 'year' => '1492 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Protestant Reformation Begins', 'year' => '1517 CE', 'correct' => false]
                ],
                'hint' => 'The fall of this Byzantine capital to the Ottoman Empire is often used to mark the end of the Middle Ages.',
                'points' => 100,
                'order' => 3,
            ],
        ];

        // Medium difficulty questions
        $mediumQuestions = [
            [
                'question' => "Which medieval empire was established first?",
                'options' => [
                    ['id' => 1, 'title' => 'Byzantine Empire under Justinian', 'year' => '527-565 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Carolingian Empire under Charlemagne', 'year' => '800-814 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Holy Roman Empire under Otto I', 'year' => '962 CE', 'correct' => false]
                ],
                'hint' => 'Justinian I attempted to restore the Roman Empire to its former glory in the 6th century.',
                'points' => 200,
                'order' => 1,
            ],
            [
                'question' => "Which medieval university was founded first?",
                'options' => [
                    ['id' => 1, 'title' => 'University of Bologna', 'year' => '1088 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'University of Oxford', 'year' => '1096 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'University of Paris', 'year' => '1150 CE', 'correct' => false]
                ],
                'hint' => 'This Italian university is considered the oldest university in continuous operation.',
                'points' => 200,
                'order' => 2,
            ],
            [
                'question' => "Which medieval technological innovation came first?",
                'options' => [
                    ['id' => 1, 'title' => 'Heavy Plow in Europe', 'year' => '~700 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Mechanical Clock', 'year' => '~1300 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Gunpowder weapons in Europe', 'year' => '~1320 CE', 'correct' => false]
                ],
                'hint' => 'This agricultural innovation revolutionized farming in Northern Europe.',
                'points' => 200,
                'order' => 3,
            ],
        ];

        // Hard difficulty questions
        $hardQuestions = [
            [
                'question' => "Which medieval scholar's work was completed first?",
                'options' => [
                    ['id' => 1, 'title' => 'Al-Khwarizmi\'s algebra treatise', 'year' => '~820 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Avicenna\'s Canon of Medicine', 'year' => '1025 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Thomas Aquinas\' Summa Theologica', 'year' => '1274 CE', 'correct' => false]
                ],
                'hint' => 'This Persian mathematician\'s work introduced algebraic methods to Europe through Latin translations.',
                'points' => 300,
                'order' => 1,
            ],
            [
                'question' => "Which medieval trade network was established first?",
                'options' => [
                    ['id' => 1, 'title' => 'Viking trade routes in Northern Europe', 'year' => '~800 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Hanseatic League', 'year' => '~1150 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Venetian trade monopoly in Mediterranean', 'year' => '~1200 CE', 'correct' => false]
                ],
                'hint' => 'These seafaring traders established routes from Scandinavia to Constantinople and beyond.',
                'points' => 300,
                'order' => 2,
            ],
            [
                'question' => "Which medieval military order was founded first?",
                'options' => [
                    ['id' => 1, 'title' => 'Knights Hospitaller', 'year' => '1099 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Knights Templar', 'year' => '1119 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Teutonic Knights', 'year' => '1190 CE', 'correct' => false]
                ],
                'hint' => 'This order began as a hospital to care for pilgrims in Jerusalem before becoming a military order.',
                'points' => 300,
                'order' => 3,
            ],
        ];

        // Create easy questions
        foreach ($easyQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'medieval',
                'difficulty' => 'easy',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }

        // Create medium questions
        foreach ($mediumQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'medieval',
                'difficulty' => 'medium',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }

        // Create hard questions
        foreach ($hardQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'medieval',
                'difficulty' => 'hard',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }
    }

    /**
     * Create renaissance & early modern questions
     */
    private function createRenaissanceQuestions(HistoricalTimelineMaze $historicalTimelineMaze): void
    {
        // Easy difficulty questions
        $easyQuestions = [
            [
                'question' => "Which Renaissance event happened first?",
                'options' => [
                    ['id' => 1, 'title' => 'Gutenberg prints the Bible', 'year' => '1455 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Columbus reaches the Americas', 'year' => '1492 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Leonardo da Vinci paints the Mona Lisa', 'year' => '~1503 CE', 'correct' => false]
                ],
                'hint' => 'This invention revolutionized the spread of knowledge in Europe.',
                'points' => 100,
                'order' => 1,
            ],
            [
                'question' => "Which Renaissance artist was born first?",
                'options' => [
                    ['id' => 1, 'title' => 'Leonardo da Vinci', 'year' => '1452 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Michelangelo', 'year' => '1475 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Raphael', 'year' => '1483 CE', 'correct' => false]
                ],
                'hint' => 'This artist is known for works like "The Last Supper" and "Vitruvian Man".',
                'points' => 100,
                'order' => 2,
            ],
            [
                'question' => "Which early modern event occurred first?",
                'options' => [
                    ['id' => 1, 'title' => 'Protestant Reformation begins', 'year' => '1517 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Copernicus publishes heliocentric theory', 'year' => '1543 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Shakespeare writes Romeo and Juliet', 'year' => '~1595 CE', 'correct' => false]
                ],
                'hint' => 'This religious movement began when Martin Luther posted his 95 Theses.',
                'points' => 100,
                'order' => 3,
            ],
        ];

        // Medium difficulty questions
        $mediumQuestions = [
            [
                'question' => "Which Renaissance scientific discovery came first?",
                'options' => [
                    ['id' => 1, 'title' => 'Vesalius publishes anatomy book', 'year' => '1543 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Galileo improves the telescope', 'year' => '1609 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Harvey discovers blood circulation', 'year' => '1628 CE', 'correct' => false]
                ],
                'hint' => 'Andreas Vesalius revolutionized the study of human anatomy with detailed illustrations.',
                'points' => 200,
                'order' => 1,
            ],
            [
                'question' => "Which early modern empire was established first?",
                'options' => [
                    ['id' => 1, 'title' => 'Spanish Empire under Charles V', 'year' => '1519-1556 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Mughal Empire under Akbar', 'year' => '1556-1605 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Ottoman Empire under Suleiman', 'year' => '1520-1566 CE', 'correct' => false]
                ],
                'hint' => 'This empire included territories in Europe, the Americas, and Asia.',
                'points' => 200,
                'order' => 2,
            ],
            [
                'question' => "Which early modern war began first?",
                'options' => [
                    ['id' => 1, 'title' => 'Thirty Years\' War', 'year' => '1618 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'English Civil War', 'year' => '1642 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'War of Spanish Succession', 'year' => '1701 CE', 'correct' => false]
                ],
                'hint' => 'This devastating conflict began in the Holy Roman Empire and eventually involved most of Europe.',
                'points' => 200,
                'order' => 3,
            ],
        ];

        // Hard difficulty questions
        $hardQuestions = [
            [
                'question' => "Which Renaissance philosophical work was published first?",
                'options' => [
                    ['id' => 1, 'title' => 'Machiavelli\'s The Prince', 'year' => '1532 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Thomas More\'s Utopia', 'year' => '1516 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Francis Bacon\'s Novum Organum', 'year' => '1620 CE', 'correct' => false]
                ],
                'hint' => 'This political treatise advised rulers to be feared rather than loved if they cannot be both.',
                'points' => 300,
                'order' => 1,
            ],
            [
                'question' => "Which early modern exploration happened first?",
                'options' => [
                    ['id' => 1, 'title' => 'Magellan\'s expedition circumnavigates the globe', 'year' => '1519-1522 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Drake\'s circumnavigation of the globe', 'year' => '1577-1580 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Hudson explores North America', 'year' => '1609-1611 CE', 'correct' => false]
                ],
                'hint' => 'Although the captain died during the journey, his expedition was the first to sail around the world.',
                'points' => 300,
                'order' => 2,
            ],
            [
                'question' => "Which early modern scientific theory was proposed first?",
                'options' => [
                    ['id' => 1, 'title' => 'Kepler\'s laws of planetary motion', 'year' => '1609-1619 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Newton\'s law of universal gravitation', 'year' => '1687 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Boyle\'s law of gases', 'year' => '1662 CE', 'correct' => false]
                ],
                'hint' => 'These three laws described how planets move around the sun in elliptical orbits.',
                'points' => 300,
                'order' => 3,
            ],
        ];

        // Create easy questions
        foreach ($easyQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'renaissance',
                'difficulty' => 'easy',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }

        // Create medium questions
        foreach ($mediumQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'renaissance',
                'difficulty' => 'medium',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }

        // Create hard questions
        foreach ($hardQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'renaissance',
                'difficulty' => 'hard',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }
    }

    /**
     * Create modern era questions
     */
    private function createModernQuestions(HistoricalTimelineMaze $historicalTimelineMaze): void
    {
        // Easy difficulty questions
        $easyQuestions = [
            [
                'question' => "Which modern revolution happened first?",
                'options' => [
                    ['id' => 1, 'title' => 'American Revolution', 'year' => '1775-1783 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'French Revolution', 'year' => '1789-1799 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Industrial Revolution', 'year' => '~1760-1840 CE', 'correct' => false]
                ],
                'hint' => 'This revolution led to the independence of the United States from Great Britain.',
                'points' => 100,
                'order' => 1,
            ],
            [
                'question' => "Which modern invention came first?",
                'options' => [
                    ['id' => 1, 'title' => 'Steam locomotive', 'year' => '1804 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Telegraph', 'year' => '1837 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Telephone', 'year' => '1876 CE', 'correct' => false]
                ],
                'hint' => 'This invention revolutionized transportation during the Industrial Revolution.',
                'points' => 100,
                'order' => 2,
            ],
            [
                'question' => "Which modern war began first?",
                'options' => [
                    ['id' => 1, 'title' => 'American Civil War', 'year' => '1861 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'World War I', 'year' => '1914 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Russo-Japanese War', 'year' => '1904 CE', 'correct' => false]
                ],
                'hint' => 'This conflict was fought between the Union and the Confederacy over issues including slavery.',
                'points' => 100,
                'order' => 3,
            ],
        ];

        // Medium difficulty questions
        $mediumQuestions = [
            [
                'question' => "Which modern political movement began first?",
                'options' => [
                    ['id' => 1, 'title' => 'Abolition movement in Britain', 'year' => '1787 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Women\'s suffrage movement', 'year' => '~1840s CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Labor movement', 'year' => '~1830s CE', 'correct' => false]
                ],
                'hint' => 'This movement sought to end the slave trade and was led by figures like William Wilberforce.',
                'points' => 200,
                'order' => 1,
            ],
            [
                'question' => "Which modern scientific theory was proposed first?",
                'options' => [
                    ['id' => 1, 'title' => 'Darwin\'s theory of evolution', 'year' => '1859 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Einstein\'s theory of relativity', 'year' => '1905 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Mendeleev\'s periodic table', 'year' => '1869 CE', 'correct' => false]
                ],
                'hint' => 'This theory was published in "On the Origin of Species" and revolutionized biology.',
                'points' => 200,
                'order' => 2,
            ],
            [
                'question' => "Which modern empire collapsed first?",
                'options' => [
                    ['id' => 1, 'title' => 'Qing Dynasty in China', 'year' => '1912 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Ottoman Empire', 'year' => '1922 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Russian Empire', 'year' => '1917 CE', 'correct' => false]
                ],
                'hint' => 'This dynasty ruled China for nearly 300 years before being overthrown by revolution.',
                'points' => 200,
                'order' => 3,
            ],
        ];

        // Hard difficulty questions
        $hardQuestions = [
            [
                'question' => "Which modern economic crisis happened first?",
                'options' => [
                    ['id' => 1, 'title' => 'Panic of 1873', 'year' => '1873 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Great Depression', 'year' => '1929 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Panic of 1893', 'year' => '1893 CE', 'correct' => false]
                ],
                'hint' => 'This financial crisis began with the failure of Jay Cooke & Company and affected Europe and North America.',
                'points' => 300,
                'order' => 1,
            ],
            [
                'question' => "Which modern international organization was founded first?",
                'options' => [
                    ['id' => 1, 'title' => 'International Red Cross', 'year' => '1863 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'League of Nations', 'year' => '1920 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'International Labour Organization', 'year' => '1919 CE', 'correct' => false]
                ],
                'hint' => 'This humanitarian organization was founded by Henry Dunant after the Battle of Solferino.',
                'points' => 300,
                'order' => 2,
            ],
            [
                'question' => "Which modern medical breakthrough came first?",
                'options' => [
                    ['id' => 1, 'title' => 'Pasteur\'s germ theory of disease', 'year' => '1862 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Discovery of X-rays', 'year' => '1895 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Discovery of penicillin', 'year' => '1928 CE', 'correct' => false]
                ],
                'hint' => 'This theory proposed that microorganisms cause infectious diseases.',
                'points' => 300,
                'order' => 3,
            ],
        ];

        // Create easy questions
        foreach ($easyQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'modern',
                'difficulty' => 'easy',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }

        // Create medium questions
        foreach ($mediumQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'modern',
                'difficulty' => 'medium',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }

        // Create hard questions
        foreach ($hardQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'modern',
                'difficulty' => 'hard',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }
    }

    /**
     * Create contemporary history questions
     */
    private function createContemporaryQuestions(HistoricalTimelineMaze $historicalTimelineMaze): void
    {
        // Easy difficulty questions
        $easyQuestions = [
            [
                'question' => "Which of these events happened first in contemporary history?",
                'options' => [
                    ['id' => 1, 'title' => 'End of World War II', 'year' => '1945 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Korean War begins', 'year' => '1950 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Cuban Missile Crisis', 'year' => '1962 CE', 'correct' => false]
                ],
                'hint' => 'This global conflict ended with the surrender of Japan after atomic bombs were dropped on Hiroshima and Nagasaki.',
                'points' => 100,
                'order' => 1,
            ],
            [
                'question' => "Which space exploration milestone happened first?",
                'options' => [
                    ['id' => 1, 'title' => 'First human in space (Yuri Gagarin)', 'year' => '1961 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'First human on the Moon (Neil Armstrong)', 'year' => '1969 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'First space station (Salyut 1)', 'year' => '1971 CE', 'correct' => false]
                ],
                'hint' => 'This Soviet cosmonaut became the first human to journey into outer space.',
                'points' => 100,
                'order' => 2,
            ],
            [
                'question' => "Which of these Cold War events happened first?",
                'options' => [
                    ['id' => 1, 'title' => 'Fall of the Berlin Wall', 'year' => '1989 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Dissolution of the Soviet Union', 'year' => '1991 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Reunification of Germany', 'year' => '1990 CE', 'correct' => false]
                ],
                'hint' => 'This event symbolized the beginning of the end of the Cold War.',
                'points' => 100,
                'order' => 3,
            ],
        ];

        // Medium difficulty questions
        $mediumQuestions = [
            [
                'question' => "Which technological innovation was introduced first?",
                'options' => [
                    ['id' => 1, 'title' => 'First personal computer (Altair 8800)', 'year' => '1975 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'World Wide Web', 'year' => '1989 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'First smartphone (IBM Simon)', 'year' => '1992 CE', 'correct' => false]
                ],
                'hint' => 'This early microcomputer came as a kit that hobbyists had to assemble themselves.',
                'points' => 200,
                'order' => 1,
            ],
            [
                'question' => "Which international agreement was signed first?",
                'options' => [
                    ['id' => 1, 'title' => 'Helsinki Accords', 'year' => '1975 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Maastricht Treaty (European Union)', 'year' => '1992 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'North American Free Trade Agreement', 'year' => '1994 CE', 'correct' => false]
                ],
                'hint' => 'This agreement attempted to improve relations between the Communist bloc and the West during the Cold War.',
                'points' => 200,
                'order' => 2,
            ],
            [
                'question' => "Which major political change happened first?",
                'options' => [
                    ['id' => 1, 'title' => 'End of Apartheid in South Africa', 'year' => '1994 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Hong Kong returns to Chinese rule', 'year' => '1997 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Introduction of the Euro currency', 'year' => '1999 CE', 'correct' => false]
                ],
                'hint' => 'This change led to the election of Nelson Mandela as president.',
                'points' => 200,
                'order' => 3,
            ],
        ];

        // Hard difficulty questions
        $hardQuestions = [
            [
                'question' => "Which economic development happened first?",
                'options' => [
                    ['id' => 1, 'title' => 'Bretton Woods system ends', 'year' => '1971 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Oil crisis', 'year' => '1973 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Stagflation in Western economies', 'year' => '1974-1982 CE', 'correct' => false]
                ],
                'hint' => 'This system of monetary management established the rules for commercial and financial relations among major industrial states.',
                'points' => 300,
                'order' => 1,
            ],
            [
                'question' => "Which environmental agreement was established first?",
                'options' => [
                    ['id' => 1, 'title' => 'Montreal Protocol (ozone layer)', 'year' => '1987 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Kyoto Protocol (climate change)', 'year' => '1997 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Paris Agreement (climate change)', 'year' => '2015 CE', 'correct' => false]
                ],
                'hint' => 'This international treaty was designed to protect the ozone layer by phasing out substances that deplete it.',
                'points' => 300,
                'order' => 2,
            ],
            [
                'question' => "Which 21st century event happened first?",
                'options' => [
                    ['id' => 1, 'title' => 'September 11 attacks', 'year' => '2001 CE', 'correct' => true],
                    ['id' => 2, 'title' => 'Global financial crisis', 'year' => '2008 CE', 'correct' => false],
                    ['id' => 3, 'title' => 'Arab Spring begins', 'year' => '2010 CE', 'correct' => false]
                ],
                'hint' => 'This series of terrorist attacks in the United States led to significant changes in global politics and security.',
                'points' => 300,
                'order' => 3,
            ],
        ];

        // Create easy questions
        foreach ($easyQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'contemporary',
                'difficulty' => 'easy',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }

        // Create medium questions
        foreach ($mediumQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'contemporary',
                'difficulty' => 'medium',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }

        // Create hard questions
        foreach ($hardQuestions as $question) {
            $historicalTimelineMaze->questions()->create([
                'era' => 'contemporary',
                'difficulty' => 'hard',
                'question' => $question['question'],
                'options' => $question['options'],
                'hint' => $question['hint'],
                'points' => $question['points'],
                'order' => $question['order'],
                'is_active' => true,
            ]);
        }
    }
}