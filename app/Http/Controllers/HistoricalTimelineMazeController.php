<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HistoricalTimelineMazeController extends Controller
{
    /**
     * Display the Historical Timeline Maze game page.
     */
    public function index(): View
    {
        // Data for the Historical Timeline Maze game
        $data = [
            'trackName' => 'HUMMS',
            'pageTitle' => 'Historical Timeline Maze',
            'user' => Auth::user()
        ];
        
        return view('historical-timeline-maze.index', $data);
    }
    
    /**
     * Get historical events for the maze.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvents(Request $request)
    {
        // Sample historical events data
        // In a production environment, this would come from a database
        $events = [
            'ancient' => [
                [
                    'id' => 1,
                    'title' => 'Building of the Great Pyramid of Giza',
                    'year' => '2560 BCE',
                    'description' => 'Construction of the Great Pyramid of Giza, one of the Seven Wonders of the Ancient World.',
                    'difficulty' => 'easy'
                ],
                [
                    'id' => 2,
                    'title' => 'Birth of Democracy in Athens',
                    'year' => '508 BCE',
                    'description' => 'Cleisthenes introduces democratic reforms in Athens, creating the world\'s first democratic system.',
                    'difficulty' => 'medium'
                ],
                [
                    'id' => 3,
                    'title' => 'Founding of the Roman Republic',
                    'year' => '509 BCE',
                    'description' => 'The Roman Republic is established after the overthrow of the Roman Kingdom.',
                    'difficulty' => 'medium'
                ],
            ],
            'medieval' => [
                [
                    'id' => 4,
                    'title' => 'Fall of the Western Roman Empire',
                    'year' => '476 CE',
                    'description' => 'The Western Roman Empire falls when Emperor Romulus Augustus is deposed by Odoacer.',
                    'difficulty' => 'medium'
                ],
                [
                    'id' => 5,
                    'title' => 'Charlemagne Crowned Emperor',
                    'year' => '800 CE',
                    'description' => 'Charlemagne is crowned Emperor of the Romans by Pope Leo III, reviving the concept of a Western European empire.',
                    'difficulty' => 'medium'
                ],
                [
                    'id' => 6,
                    'title' => 'Magna Carta Signed',
                    'year' => '1215 CE',
                    'description' => 'King John of England signs the Magna Carta, limiting royal power and establishing that everyone is subject to the law.',
                    'difficulty' => 'easy'
                ],
            ],
            'renaissance' => [
                [
                    'id' => 7,
                    'title' => 'Gutenberg Prints the Bible',
                    'year' => '1455 CE',
                    'description' => 'Johannes Gutenberg produces the first printed Bible using movable type, revolutionizing information sharing.',
                    'difficulty' => 'easy'
                ],
                [
                    'id' => 8,
                    'title' => 'Columbus Reaches the Americas',
                    'year' => '1492 CE',
                    'description' => 'Christopher Columbus reaches the Americas, beginning the Columbian Exchange and European colonization.',
                    'difficulty' => 'easy'
                ],
                [
                    'id' => 9,
                    'title' => 'Leonardo da Vinci Paints the Mona Lisa',
                    'year' => '1503 CE',
                    'description' => 'Leonardo da Vinci begins painting the Mona Lisa, one of the most famous paintings in the world.',
                    'difficulty' => 'medium'
                ],
            ],
            'modern' => [
                [
                    'id' => 10,
                    'title' => 'American Declaration of Independence',
                    'year' => '1776 CE',
                    'description' => 'The United States declares independence from Great Britain, establishing a new nation.',
                    'difficulty' => 'easy'
                ],
                [
                    'id' => 11,
                    'title' => 'French Revolution Begins',
                    'year' => '1789 CE',
                    'description' => 'The French Revolution begins with the storming of the Bastille, leading to radical social and political change.',
                    'difficulty' => 'medium'
                ],
                [
                    'id' => 12,
                    'title' => 'World War I Begins',
                    'year' => '1914 CE',
                    'description' => 'World War I begins, involving many of the world\'s nations in a global conflict.',
                    'difficulty' => 'easy'
                ],
            ],
            'contemporary' => [
                [
                    'id' => 13,
                    'title' => 'United Nations Founded',
                    'year' => '1945 CE',
                    'description' => 'The United Nations is established to promote international cooperation after World War II.',
                    'difficulty' => 'easy'
                ],
                [
                    'id' => 14,
                    'title' => 'Fall of the Berlin Wall',
                    'year' => '1989 CE',
                    'description' => 'The Berlin Wall falls, symbolizing the end of the Cold War and the reunification of Germany.',
                    'difficulty' => 'easy'
                ],
                [
                    'id' => 15,
                    'title' => 'World Wide Web Invented',
                    'year' => '1989 CE',
                    'description' => 'Tim Berners-Lee invents the World Wide Web, revolutionizing global communication and information sharing.',
                    'difficulty' => 'medium'
                ],
            ],
        ];

        // Get the requested era or return all eras
        $era = $request->input('era', null);
        if ($era && isset($events[$era])) {
            return response()->json(['events' => $events[$era]]);
        }

        return response()->json(['events' => $events]);
    }

    /**
     * Save user's game progress and score.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveProgress(Request $request)
    {
        $request->validate([
            'score' => 'required|integer',
            'level_completed' => 'required|string',
            'time_taken' => 'required|integer',
        ]);

        // In a production environment, you would save this to a database
        // For now, we'll just return a success response
        return response()->json([
            'success' => true,
            'message' => 'Progress saved successfully',
        ]);
    }
}
