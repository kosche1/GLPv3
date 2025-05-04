<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SolutionController;
use App\Http\Controllers\Api\TextSolutionController;

// Existing routes
Route::post('/submit-solution', [SolutionController::class, 'submit']);
Route::post('/execute-python', function (Request $request) {
    return executeCode($request, 'python');
});
Route::post('/execute-java', function (Request $request) {
    return executeCode($request, 'java');
});

// New route for text-based solutions
Route::post('/submit-text-solution', [TextSolutionController::class, 'submit'])
    ->name('api.submit-text-solution');
    // Removed auth middleware for testing

// Debugging route for text solutions
Route::get('/test-text-solution', function() {
    return response()->json(['message' => 'Text solution route is working']);
});

// Direct route to TextSolutionController - this is the one that works
Route::post('/direct-text-solution', function(Request $request) {
    $controller = new \App\Http\Controllers\Api\TextSolutionController();
    return $controller->submit($request);
});

if (!function_exists('executeCode')) {
    function executeCode(Request $request, string $language) {
        try {
            $code = $request->input('code');
            if (empty($code)) {
                return response()->json(['error' => 'No code provided'], 400);
            }

            // Validate code length
            if (strlen($code) > 10000) {
                return response()->json(['error' => 'Code exceeds maximum length (10000 characters)'], 400);
            }

            // Create a temporary file with .py extension
            $tempFile = tempnam(sys_get_temp_dir(), $language . '_') . ($language === 'python' ? '.py' : '.java');
            if ($tempFile === false) {
                return response()->json(['error' => 'Failed to create temporary file'], 500);
            }

            // Write code to temporary file with error handling
            try {
                if (file_put_contents($tempFile, $code) === false) {
                    throw new \Exception('Failed to write code to file');
                }
            } catch (\Exception $e) {
                if (file_exists($tempFile)) {
                    unlink($tempFile);
                }
                return response()->json(['error' => 'Failed to write code to temporary file'], 500);
            }

            // Execute the Python code with improved error handling and timeout
            $output = '';
            $returnCode = 0;
            if ($language === 'java') {
                // Compile Java code first
                $compileCommand = sprintf('javac "%s" 2>&1', $tempFile);
                $compileProcess = proc_open($compileCommand, [
                    0 => ['pipe', 'r'],
                    1 => ['pipe', 'w'],
                    2 => ['pipe', 'w']
                ], $compilePipes);

                if (!is_resource($compileProcess)) {
                    unlink($tempFile);
                    return response()->json(['error' => 'Failed to start Java compilation process'], 500);
                }

                // Wait for compilation to finish
                $compileStatus = proc_get_status($compileProcess);
                while ($compileStatus['running']) {
                    usleep(100000); // Sleep for 100ms
                    $compileStatus = proc_get_status($compileProcess);
                }

                // Check compilation result
                if ($compileStatus['exitcode'] !== 0) {
                    $compileOutput = stream_get_contents($compilePipes[1]);
                    foreach ($compilePipes as $pipe) {
                        fclose($pipe);
                    }
                    proc_close($compileProcess);
                    unlink($tempFile);
                    return response()->json(['error' => 'Java compilation failed: ' . trim($compileOutput)], 400);
                }

                // Close compilation process pipes
                foreach ($compilePipes as $pipe) {
                    fclose($pipe);
                }
                proc_close($compileProcess);

                // Run compiled Java class
                $className = pathinfo($tempFile, PATHINFO_FILENAME);
                $command = sprintf('java -cp "%s" %s 2>&1', dirname($tempFile), $className);
            } else {
                $command = sprintf('python "%s" 2>&1', $tempFile);
            }
            $process = proc_open($command, [
                0 => ['pipe', 'r'],
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w']
            ], $pipes);

            if (!is_resource($process)) {
                unlink($tempFile);
                return response()->json(['error' => 'Failed to start Python process'], 500);
            }

            // Set non-blocking mode for output pipes
            stream_set_blocking($pipes[1], false);
            stream_set_blocking($pipes[2], false);

            $start = microtime(true);
            $timeout = 5.0; // 5 seconds timeout

            // Read output with timeout using microtime for better precision
            while (microtime(true) - $start < $timeout) {
                $read = [$pipes[1], $pipes[2]];
                $write = null;
                $except = null;

                // Use a shorter select timeout for more responsive reading
                if (stream_select($read, $write, $except, 0, 200000) > 0) {
                    foreach ($read as $pipe) {
                        $output .= stream_get_contents($pipe);
                    }
                }

                $status = proc_get_status($process);
                if (!$status['running']) {
                    $returnCode = $status['exitcode'];
                    break;
                }
            }

            // Check for timeout
            $status = proc_get_status($process);
            if ($status['running']) {
                proc_terminate($process, 9); // Force kill with SIGKILL
                proc_close($process);
                unlink($tempFile);
                return response()->json(['error' => 'Execution timeout (5 seconds)'], 408);
            }

            // Clean up resources
            foreach ($pipes as $pipe) {
                fclose($pipe);
            }
            proc_close($process);
            unlink($tempFile);

            // Handle execution results
            if ($returnCode !== 0) {
                return response()->json([
                    'error' => trim($output) ?: 'Unknown error occurred during execution'
                ]);
            }

            return response()->json([
                'output' => trim($output)
            ]);
        } catch (\Exception $e) {
            // Ensure temporary file is cleaned up in case of errors
            if (isset($tempFile) && file_exists($tempFile)) {
                unlink($tempFile);
            }
            return response()->json(['error' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }
}

// Debugging endpoint
Route::get('/debug-task/{task}', function (\App\Models\Task $task) {
    return response()->json([
        'task' => $task,
        'challenge' => $task->challenge,
        'programming_language' => $task->challenge->programming_language ?? 'unknown'
    ]);
});

// Investment Challenge Routes - All made public for development
Route::get('/investment-challenges', [\App\Http\Controllers\API\InvestmentChallengeController::class, 'index']);
Route::get('/user-investment-challenges', [\App\Http\Controllers\API\InvestmentChallengeController::class, 'userChallenges']);
Route::post('/investment-challenges/start', [\App\Http\Controllers\API\InvestmentChallengeController::class, 'startChallenge']);
Route::put('/user-investment-challenges/{id}/progress', [\App\Http\Controllers\API\InvestmentChallengeController::class, 'updateProgress']);
Route::post('/user-investment-challenges/{id}/submit', [\App\Http\Controllers\API\InvestmentChallengeController::class, 'submitChallenge']);
Route::delete('/user-investment-challenges/{id}', [\App\Http\Controllers\API\InvestmentChallengeController::class, 'deleteChallenge']);

