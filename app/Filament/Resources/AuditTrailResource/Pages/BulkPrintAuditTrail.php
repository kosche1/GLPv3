<?php

namespace App\Filament\Resources\AuditTrailResource\Pages;

use App\Filament\Resources\AuditTrailResource;
use App\Models\AuditTrail;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

class BulkPrintAuditTrail extends Page
{
    protected static string $resource = AuditTrailResource::class;

    protected static string $view = 'filament.resources.audit-trail-resource.pages.bulk-print-audit-trail';
    
    public array $records = [];
    
    public function mount(string $batchId): void
    {
        $recordIds = Session::get("audit-trail-print-{$batchId}", []);
        
        if (empty($recordIds)) {
            $this->redirect(route('filament.admin.resources.audit-trails.index'));
            return;
        }
        
        $this->records = AuditTrail::whereIn('id', $recordIds)
            ->with('user')
            ->get()
            ->toArray();
    }
    
    protected function getHeaderActions(): array
    {
        return [];
    }
    
    public function getTitle(): string
    {
        return "Print Audit Trail Records";
    }
}
