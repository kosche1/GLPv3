<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use League\Csv\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GameProgressExport
{
    protected Collection $users;

    public function __construct()
    {
        $this->users = User::query()
            ->with([
                'typing_test_results',
                'equation_drop_results',
                'historical_timeline_maze_results',
                'invest_smart_results',
                'user_recipes',
                'roles'
            ])
            ->get();
    }

    /**
     * Export game progress as CSV
     */
    public function exportCsv(): StreamedResponse
    {
        $csv = Writer::createFromString();

        // Add headers
        $csv->insertOne([
            'Student Name',
            'Email',
            'Role',
            'Typing Speed Attempts',
            'Best Typing Speed (WPM)',
            'Best Typing Accuracy (%)',
            'Equation Drop Attempts',
            'Best Equation Score',
            'Historical Maze Attempts',
            'Best Maze Score',
            'InvestSmart Attempts',
            'Best Investment Value',
            'Recipe Builder Attempts',
            'Latest Recipe',
            'Total Game Attempts',
            'Joined Date'
        ]);

        // Add data rows
        foreach ($this->users as $user) {
            $typingResults = $user->typing_test_results;
            $equationResults = $user->equation_drop_results;
            $mazeResults = $user->historical_timeline_maze_results;
            $investResults = $user->invest_smart_results;
            $recipeResults = $user->user_recipes;

            $csv->insertOne([
                $user->name,
                $user->email,
                $user->getRoleNames()->first() ?? 'student',
                $typingResults->count(),
                $typingResults->max('wpm') ?? 0,
                $typingResults->max('accuracy') ?? 0,
                $equationResults->count(),
                $equationResults->max('score') ?? 0,
                $mazeResults->count(),
                $mazeResults->max('score') ?? 0,
                $investResults->count(),
                $investResults->max('total_value') ?? 0,
                $recipeResults->count(),
                $recipeResults->first()?->recipeTemplate?->name ?? 'N/A',
                $typingResults->count() + $equationResults->count() + $mazeResults->count() + $investResults->count() + $recipeResults->count(),
                $user->created_at->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s')
            ]);
        }

        return response()->streamDownload(
            fn () => print($csv->toString()),
            'game-progress-report-' . now()->setTimezone(config('app.timezone'))->format('Y-m-d_H-i-s') . '.csv',
            [
                'Content-Type' => 'text/csv',
            ]
        );
    }

    /**
     * Export game progress as Excel (using CSV format for now)
     */
    public function exportExcel(): StreamedResponse
    {
        // For now, we'll use CSV format which Excel can open
        // Later this can be enhanced with actual Excel format using maatwebsite/excel
        return $this->exportCsv();
    }

    /**
     * Export game progress as PDF
     */
    public function exportPdf(): StreamedResponse
    {
        $html = $this->generatePdfHtml();

        // For now, return HTML that can be printed as PDF
        // Later this can be enhanced with actual PDF generation using dompdf
        return response()->streamDownload(
            fn () => print($html),
            'game-progress-report-' . now()->setTimezone(config('app.timezone'))->format('Y-m-d_H-i-s') . '.html',
            [
                'Content-Type' => 'text/html',
            ]
        );
    }

    /**
     * Generate HTML for PDF export
     */
    protected function generatePdfHtml(): string
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <title>Game Progress Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .report-info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .summary { background-color: #f9f9f9; padding: 15px; margin-bottom: 20px; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Game Progress Report</h1>
        <h2>GameLearnPro (GLP)</h2>
    </div>

    <div class="report-info">
        <p><strong>Generated on:</strong> ' . now()->setTimezone(config('app.timezone'))->format('F j, Y \a\t g:i A') . '</p>
        <p><strong>Total Students:</strong> ' . $this->users->count() . '</p>
    </div>

    <div class="summary">
        <h3>Summary Statistics</h3>
        <p><strong>Total Typing Test Attempts:</strong> ' . $this->users->sum(fn($u) => $u->typing_test_results->count()) . '</p>
        <p><strong>Total Equation Drop Attempts:</strong> ' . $this->users->sum(fn($u) => $u->equation_drop_results->count()) . '</p>
        <p><strong>Total Historical Maze Attempts:</strong> ' . $this->users->sum(fn($u) => $u->historical_timeline_maze_results->count()) . '</p>
        <p><strong>Total InvestSmart Attempts:</strong> ' . $this->users->sum(fn($u) => $u->invest_smart_results->count()) . '</p>
        <p><strong>Total Recipe Builder Attempts:</strong> ' . $this->users->sum(fn($u) => $u->user_recipes->count()) . '</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Typing Speed</th>
                <th>Equation Drop</th>
                <th>Historical Maze</th>
                <th>InvestSmart</th>
                <th>Recipe Builder</th>
                <th>Total Attempts</th>
                <th>Joined Date</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($this->users as $user) {
            $typingResults = $user->typing_test_results;
            $equationResults = $user->equation_drop_results;
            $mazeResults = $user->historical_timeline_maze_results;
            $investResults = $user->invest_smart_results;
            $recipeResults = $user->user_recipes;

            $totalAttempts = $typingResults->count() + $equationResults->count() +
                           $mazeResults->count() + $investResults->count() + $recipeResults->count();

            $html .= '<tr>
                <td>' . htmlspecialchars($user->name) . '</td>
                <td>' . htmlspecialchars($user->email) . '</td>
                <td>' . htmlspecialchars($user->getRoleNames()->first() ?? 'student') . '</td>
                <td>' . $typingResults->count() . ' attempts<br>Best: ' . ($typingResults->max('wpm') ?? 0) . ' WPM</td>
                <td>' . $equationResults->count() . ' attempts<br>Best: ' . ($equationResults->max('score') ?? 0) . ' points</td>
                <td>' . $mazeResults->count() . ' attempts<br>Best: ' . ($mazeResults->max('score') ?? 0) . ' points</td>
                <td>' . $investResults->count() . ' attempts<br>Best: ₱' . number_format($investResults->max('total_value') ?? 0, 2) . '</td>
                <td>' . $recipeResults->count() . ' attempts</td>
                <td>' . $totalAttempts . '</td>
                <td>' . $user->created_at->setTimezone(config('app.timezone'))->format('M j, Y') . '</td>
            </tr>';
        }

        $html .= '</tbody>
    </table>

    <div class="footer">
        <p>This report was generated by GameLearnPro (GLP) - Educational Gaming Platform</p>
    </div>
</body>
</html>';

        return $html;
    }
}
