<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuditTrailPrintController extends Controller
{
    /**
     * Print a single audit trail record.
     */
    public function printRecord(AuditTrail $record)
    {
        $record->load('user');
        
        return view('audit-trail.print', [
            'record' => $record,
        ]);
    }
    
    /**
     * Print multiple audit trail records.
     */
    public function printBulk(Request $request, $batchId)
    {
        $recordIds = Session::get("audit-trail-print-{$batchId}", []);
        
        if (empty($recordIds)) {
            return redirect()->route('filament.admin.resources.audit-trails.index')
                ->with('error', 'No records found for printing.');
        }
        
        $records = AuditTrail::whereIn('id', $recordIds)
            ->with('user')
            ->get();
            
        return view('audit-trail.bulk-print', [
            'records' => $records,
        ]);
    }
}
