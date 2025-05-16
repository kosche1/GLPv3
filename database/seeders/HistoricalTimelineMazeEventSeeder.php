<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HistoricalTimelineMaze;
use App\Models\HistoricalTimelineMazeEvent;

class HistoricalTimelineMazeEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the main Historical Timeline Maze game
        $historicalTimelineMaze = HistoricalTimelineMaze::where('is_active', true)->first();

        if (!$historicalTimelineMaze) {
            // Create the main game if it doesn't exist
            $historicalTimelineMaze = HistoricalTimelineMaze::create([
                'title' => 'Historical Timeline Maze',
                'description' => 'A fun and educational game where students navigate through historical events by placing them in chronological order. Test your knowledge of world history across different eras!',
                'is_active' => true,
            ]);
        }

        // Create events for each era
        $this->createAncientEvents($historicalTimelineMaze);
        $this->createMedievalEvents($historicalTimelineMaze);
        $this->createRenaissanceEvents($historicalTimelineMaze);
        $this->createModernEvents($historicalTimelineMaze);
        $this->createContemporaryEvents($historicalTimelineMaze);
    }

    /**
     * Create ancient era events
     */
    private function createAncientEvents(HistoricalTimelineMaze $historicalTimelineMaze): void
    {
        $events = [
            [
                'title' => 'Building of the Great Pyramid of Giza',
                'year' => '2560 BCE',
                'description' => 'One of the Seven Wonders of the Ancient World, built as a tomb for Pharaoh Khufu.',
                'order' => 1,
            ],
            [
                'title' => 'Code of Hammurabi',
                'year' => '1754 BCE',
                'description' => 'One of the earliest and most complete legal codes from ancient Mesopotamia.',
                'order' => 2,
            ],
            [
                'title' => 'Founding of the Roman Republic',
                'year' => '509 BCE',
                'description' => 'Established after the overthrow of the Roman Kingdom, introducing a new system of government.',
                'order' => 3,
            ],
            [
                'title' => 'Birth of Democracy in Athens',
                'year' => '508 BCE',
                'description' => 'Cleisthenes introduces democratic reforms in Athens, creating the world\'s first democratic system.',
                'order' => 4,
            ],
            [
                'title' => 'Birth of Jesus Christ',
                'year' => '~4 BCE',
                'description' => 'The birth of Jesus of Nazareth, central figure of Christianity and basis for the Western calendar system.',
                'order' => 5,
            ],
            [
                'title' => 'Fall of the Western Roman Empire',
                'year' => '476 CE',
                'description' => 'The Western Roman Empire falls when Emperor Romulus Augustus is deposed by Odoacer, marking the end of Ancient Rome.',
                'order' => 6,
            ],
        ];

        foreach ($events as $event) {
            HistoricalTimelineMazeEvent::updateOrCreate(
                [
                    'historical_timeline_maze_id' => $historicalTimelineMaze->id,
                    'era' => 'ancient',
                    'title' => $event['title'],
                ],
                [
                    'year' => $event['year'],
                    'description' => $event['description'],
                    'order' => $event['order'],
                    'is_active' => true,
                ]
            );
        }
    }

    /**
     * Create medieval era events
     */
    private function createMedievalEvents(HistoricalTimelineMaze $historicalTimelineMaze): void
    {
        $events = [
            [
                'title' => 'Justinian\'s Code',
                'year' => '529 CE',
                'description' => 'Emperor Justinian I codifies Roman law, creating a unified legal system for the Byzantine Empire.',
                'order' => 1,
            ],
            [
                'title' => 'Rise of Islam',
                'year' => '622 CE',
                'description' => 'Muhammad\'s migration from Mecca to Medina marks the beginning of the Islamic calendar.',
                'order' => 2,
            ],
            [
                'title' => 'Charlemagne Crowned Emperor',
                'year' => '800 CE',
                'description' => 'Charlemagne is crowned Emperor of the Romans by Pope Leo III, reviving the concept of a Western European empire.',
                'order' => 3,
            ],
            [
                'title' => 'Magna Carta Signed',
                'year' => '1215 CE',
                'description' => 'King John of England signs the Magna Carta, limiting royal power and establishing that everyone is subject to the law.',
                'order' => 4,
            ],
            [
                'title' => 'Black Death Pandemic',
                'year' => '1347-1351 CE',
                'description' => 'The bubonic plague kills an estimated 75-200 million people across Eurasia and North Africa.',
                'order' => 5,
            ],
            [
                'title' => 'Fall of Constantinople',
                'year' => '1453 CE',
                'description' => 'The Byzantine Empire falls when Constantinople is captured by the Ottoman Empire, marking the end of the Medieval Period.',
                'order' => 6,
            ],
        ];

        foreach ($events as $event) {
            HistoricalTimelineMazeEvent::updateOrCreate(
                [
                    'historical_timeline_maze_id' => $historicalTimelineMaze->id,
                    'era' => 'medieval',
                    'title' => $event['title'],
                ],
                [
                    'year' => $event['year'],
                    'description' => $event['description'],
                    'order' => $event['order'],
                    'is_active' => true,
                ]
            );
        }
    }

    /**
     * Create renaissance era events
     */
    private function createRenaissanceEvents(HistoricalTimelineMaze $historicalTimelineMaze): void
    {
        $events = [
            [
                'title' => 'Gutenberg Prints the Bible',
                'year' => '1455 CE',
                'description' => 'Johannes Gutenberg produces the first printed Bible using movable type, revolutionizing information sharing.',
                'order' => 1,
            ],
            [
                'title' => 'Columbus Reaches the Americas',
                'year' => '1492 CE',
                'description' => 'Christopher Columbus reaches the Americas, beginning the Columbian Exchange and European colonization.',
                'order' => 2,
            ],
            [
                'title' => 'Leonardo da Vinci Paints the Mona Lisa',
                'year' => '1503 CE',
                'description' => 'Leonardo da Vinci begins painting the Mona Lisa, one of the most famous paintings in the world.',
                'order' => 3,
            ],
            [
                'title' => 'Protestant Reformation Begins',
                'year' => '1517 CE',
                'description' => 'Martin Luther publishes his Ninety-five Theses, challenging the Catholic Church and starting the Protestant Reformation.',
                'order' => 4,
            ],
            [
                'title' => 'Scientific Revolution',
                'year' => '1543 CE',
                'description' => 'Copernicus publishes "On the Revolutions of the Celestial Spheres," proposing a heliocentric model of the universe.',
                'order' => 5,
            ],
            [
                'title' => 'American Declaration of Independence',
                'year' => '1776 CE',
                'description' => 'The United States declares independence from Great Britain, establishing a new nation.',
                'order' => 6,
            ],
        ];

        foreach ($events as $event) {
            HistoricalTimelineMazeEvent::updateOrCreate(
                [
                    'historical_timeline_maze_id' => $historicalTimelineMaze->id,
                    'era' => 'renaissance',
                    'title' => $event['title'],
                ],
                [
                    'year' => $event['year'],
                    'description' => $event['description'],
                    'order' => $event['order'],
                    'is_active' => true,
                ]
            );
        }
    }

    /**
     * Create modern era events
     */
    private function createModernEvents(HistoricalTimelineMaze $historicalTimelineMaze): void
    {
        $events = [
            [
                'title' => 'French Revolution',
                'year' => '1789 CE',
                'description' => 'The French Revolution begins with the storming of the Bastille, leading to radical social and political change.',
                'order' => 1,
            ],
            [
                'title' => 'Industrial Revolution',
                'year' => '1760-1840 CE',
                'description' => 'A period of transition to new manufacturing processes in Europe and the United States.',
                'order' => 2,
            ],
            [
                'title' => 'Abolition of Slavery in the US',
                'year' => '1865 CE',
                'description' => 'The 13th Amendment to the US Constitution abolishes slavery following the American Civil War.',
                'order' => 3,
            ],
            [
                'title' => 'First World War',
                'year' => '1914-1918 CE',
                'description' => 'A global conflict that led to major political changes and the redrawing of national boundaries.',
                'order' => 4,
            ],
            [
                'title' => 'Russian Revolution',
                'year' => '1917 CE',
                'description' => 'The Russian Revolution overthrows the Tsarist autocracy and leads to the creation of the Soviet Union.',
                'order' => 5,
            ],
            [
                'title' => 'End of World War II',
                'year' => '1945 CE',
                'description' => 'World War II ends with the surrender of Nazi Germany and Imperial Japan, leading to a new global order.',
                'order' => 6,
            ],
        ];

        foreach ($events as $event) {
            HistoricalTimelineMazeEvent::updateOrCreate(
                [
                    'historical_timeline_maze_id' => $historicalTimelineMaze->id,
                    'era' => 'modern',
                    'title' => $event['title'],
                ],
                [
                    'year' => $event['year'],
                    'description' => $event['description'],
                    'order' => $event['order'],
                    'is_active' => true,
                ]
            );
        }
    }

    /**
     * Create contemporary era events
     */
    private function createContemporaryEvents(HistoricalTimelineMaze $historicalTimelineMaze): void
    {
        $events = [
            [
                'title' => 'United Nations Founded',
                'year' => '1945 CE',
                'description' => 'The United Nations is established to promote international cooperation after World War II.',
                'order' => 1,
            ],
            [
                'title' => 'First Human in Space',
                'year' => '1961 CE',
                'description' => 'Yuri Gagarin becomes the first human to journey into outer space, completing one orbit of Earth.',
                'order' => 2,
            ],
            [
                'title' => 'Moon Landing',
                'year' => '1969 CE',
                'description' => 'Neil Armstrong becomes the first person to walk on the Moon during the Apollo 11 mission.',
                'order' => 3,
            ],
            [
                'title' => 'Fall of the Berlin Wall',
                'year' => '1989 CE',
                'description' => 'The Berlin Wall falls, symbolizing the end of the Cold War and the reunification of Germany.',
                'order' => 4,
            ],
            [
                'title' => 'World Wide Web Invented',
                'year' => '1989 CE',
                'description' => 'Tim Berners-Lee invents the World Wide Web, revolutionizing global communication and information sharing.',
                'order' => 5,
            ],
            [
                'title' => 'COVID-19 Pandemic',
                'year' => '2019-2023 CE',
                'description' => 'A global pandemic caused by the SARS-CoV-2 virus, leading to significant social and economic disruption worldwide.',
                'order' => 6,
            ],
        ];

        foreach ($events as $event) {
            HistoricalTimelineMazeEvent::updateOrCreate(
                [
                    'historical_timeline_maze_id' => $historicalTimelineMaze->id,
                    'era' => 'contemporary',
                    'title' => $event['title'],
                ],
                [
                    'year' => $event['year'],
                    'description' => $event['description'],
                    'order' => $event['order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
