<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogPrintController extends Controller
{
    public function print($record)
    {
        // Find the activity log record
        $record = Activity::findOrFail($record);
        
        // Load relationships
        $record->load(['causer', 'subject']);
        
        // Return the print view with the record
        return view('filament.resources.activity-log-resource.pages.print-view', [
            'record' => $record,
        ]);
    }
}
